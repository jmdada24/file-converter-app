<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
// use PhpOffice\PhpWord\IOFactory;
// use PhpOffice\PhpWord\PhpWord;
use RuntimeException;
use Symfony\Component\Process\Process;

class PdfToWordService
{
    /**
     * Create a new class instance.
     */
    public function convert(UploadedFile $file): array
    {
        //
        $tempDir = config('converter.temp_dir');


        if (! is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeBaseName = Str::slug($originalName) ?: 'converted-file';

        $inputFileName = Str::uuid() . '.pdf';
        $textFileName = Str::uuid() . '.txt';
        $outputFileName = Str::uuid() . '.docx';


        $inputPath = $tempDir . DIRECTORY_SEPARATOR . $inputFileName;
        $textPath =  $tempDir . DIRECTORY_SEPARATOR . $textFileName;
        $outputPath = $tempDir . DIRECTORY_SEPARATOR . $outputFileName;


        $file->move($tempDir, $inputFileName);


        $pythonBinary = config('converter.python_binary');
        $scriptPath = config('converter.pdf_to_word_script');

        if (! file_exists($scriptPath)) {
            throw new RuntimeException('Python script not found at: ' . $scriptPath);
        }

        // // For the non-docker kay dili basig lang...
        // $process = new Process([
        //     '/usr/bin/arch',
        //     '-arm64',
        //     $pythonBinary,
        //     $scriptPath,
        //     $inputPath,
        //     $outputPath,
        // ]);


        $process = new Process([
            $pythonBinary,
            $scriptPath,
            $inputPath,
            $outputPath,
        ]);


        $process->setTimeout(180);
        $process->run();

        if (! $process->isSuccessful()) {
            if (file_exists($inputPath)) {
                @unlink($inputPath);
            }

            if (file_exists($outputPath)) {
                @unlink($outputPath);
            }

            throw new RuntimeException(
                'PDF to Word conversion failed: ' . $process->getErrorOutput()
            );
        }

        if (! file_exists($outputPath)) {
            if (file_exists($inputPath)) {
                @unlink($inputPath);
            }

            throw new RuntimeException('PDF to Word conversion failed: output DOCX was not created.');
        }

        if (file_exists($inputPath)) {
            @unlink($inputPath);
        }

        return [
            'output_path' => $outputPath,
            'output_name' => $safeBaseName . '.docx',
        ];
    }
}
