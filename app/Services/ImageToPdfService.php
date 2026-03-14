<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use RuntimeException;

class ImageToPdfService
{

    /**
     * Create a new class instance.
     */


    public function convert(UploadedFile $file): array
    {
        $tempDir = config('converter.temp_dir');


        $extension = $file->getClientOriginalExtension();
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeBaseName = Str::slug($originalName) ?: 'converted-file';



        $inputFileName = Str::uuid() . '.' . $extension;
        $outputFileName = Str::uuid() . '.' . 'pdf';

        $inputPath = $tempDir . DIRECTORY_SEPARATOR . $inputFileName;
        $outputPath = $tempDir . DIRECTORY_SEPARATOR . $outputFileName;

        $file->move($tempDir, $inputFileName);

        $binary = config('converter.imagemagick', 'convert');

        $command = $binary === 'magick' ? [$binary, $inputPath, $outputPath] : [$binary, $inputPath, $outputPath];

        $process = new Process($command);
        $process->setTimeout(60);
        $process->run();



        if (! $process->isSuccessful()) {
            if (file_exists($inputPath)) {
                @unlink($inputPath);
            }
            throw new RuntimeException('Image to PDF conversion failed: ' . $process->getErrorOutput());
        }


        if (file_exists($inputPath)) {
            @unlink($inputPath);
        }

        return [
            'output_path' => $outputPath,
            'output_name' => $safeBaseName . '.pdf',

        ];
    }
}
