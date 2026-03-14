<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Process\Process;

class PdfToImageService
{
    /**
     * Create a new class instance.
     */
    public function convert(UploadedFile $file): array
    {

        $tempDir = config('converter.temp_dir');

        if (! is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $inputFileName = Str::uuid() . '.pdf';
        $outputBaseName = (string) Str::uuid();
        $outputFileName = $outputBaseName . '.png';

        $inputPath = $tempDir . DIRECTORY_SEPARATOR . $inputFileName;
        $outputPath = $tempDir . DIRECTORY_SEPARATOR . $outputFileName;

        $file->move($tempDir, $inputFileName);


        $binary = config('converter.ghostscript', 'gs');
        $command = [
            $binary,
            '-dSAFER',
            '-dBATCH',
            '-dNOPAUSE',
            '-sDEVICE=pngalpha',
            '-r144',
            '-dFirstPage=1',
            '-dLastPage=1',
            '-sOutputFile=' . $outputPath,
            $inputPath,
        ];


        $process = new Process($command);

        $process->setTimeout(60);

        $process->run();

        if (! $process->isSuccessful()) {
            if (file_exists($inputPath)) {
                @unlink($inputPath);
            }

            throw new RuntimeException(
                'PDF to image conversion failed: ' . $process->getErrorOutput()
            );
        }


        if (! file_exists($outputPath)) {
            if (file_exists($inputPath)) {
                @unlink($inputPath);
            }

            throw new RuntimeException('PDF to image conversion failed: output image was not created.');
        }

        if (file_exists($inputPath)) {
            @unlink($inputPath);
        }


        return [
            'output_path' => $outputPath,
            'output_name' => 'converted-page-1.png',

        ];
    }
}
