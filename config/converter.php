<?php

return [
    'temp_dir' => storage_path('app/temp'),
    'imagemagick' => env('IMAGEMAGICK_BINARY', 'magick'),
    'ghostscript' => env('GHOSTSCRIPT_BINARY', 'gs'),
   
    'python_binary' => env('PYTHON_BINARY', '/opt/venv/bin/python'),
    'pdf_to_word_script' => env('PDF_TO_WORD_SCRIPT', base_path('python/convert_pdf_to_docx.py')),

];