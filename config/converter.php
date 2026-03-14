<?php

return [
    'temp_dir' => storage_path('app/temp'),
    'imagemagick' => env('IMAGEMAGICK_BINARY', 'magick'),
    'ghostscript' => env('GHOSTSCRIPT_BINARY', 'gs'),
];