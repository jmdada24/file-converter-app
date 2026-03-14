# File Converter App

A private file converter built with Laravel, Blade, Tailwind CSS, Docker, and Python.

This project focuses on simple and privacy-friendly file conversion. Files are uploaded, converted, downloaded, and automatically removed from temporary storage after processing. The goal is to provide a safer alternative to random online converter websites by keeping the app straightforward and transparent.

## Features

Currently supported converters:

- Image → PDF
- PDF → Image
- PDF → Word

### Current behavior

- upload a file
- convert it on the server
- download the converted result
- automatically delete temporary files after sending the download
- no permanent file storage
- no database required for the current version

## Why this project exists

Many free converter websites feel sketchy. Some users do not know what happens to their files after upload, and that creates trust issues, especially for personal, school, or work documents.

This project was built as a hobby project and learning project with a privacy-first direction:

- simple conversion flow
- temporary processing only
- no user accounts
- no conversion history storage
- no unnecessary database setup

## Tech Stack

- **Backend:** Laravel 12
- **Frontend:** Blade + Tailwind CSS
- **Build tool:** Vite
- **Containerization:** Docker + Docker Compose
- **Conversion tools:**
  - ImageMagick
  - Ghostscript
  - Python
  - pdf2docx

## Supported Converters

### Image → PDF
Converts uploaded JPG, JPEG, PNG, and WEBP images into PDF files.

### PDF → Image
Converts the first page of an uploaded PDF into a PNG image.

### PDF → Word
Converts an uploaded PDF into a DOCX file using a Python-based conversion script.

## Project Structure

```text
app/
├── Http/Controllers/
│   └── ConverterController.php
├── Services/
│   ├── ImageToPdfService.php
│   ├── PdfToImageService.php
│   └── PdfToWordService.php

config/
└── converter.php

python/
├── convert_pdf_to_docx.py
└── requirements.txt

resources/views/
├── components/
├── layouts/
└── pages/

routes/
└── web.php

## How it works

The app uses a simple request flow:

- User opens a converter page
- User uploads a file
- Laravel validates the request
- A service class handles the conversion logic
- The converted file is returned as a download
- Temporary files are removed after processing

## Privacy Approach

This app is designed to be privacy-friendly:

- Files are stored only temporarily during processing
- Converted files are deleted after download
- Uploaded source files are deleted after conversion
- No database is used for storing user files
- No user accounts are required

This does not automatically make the app secure for all production use, but the project is intentionally designed to avoid unnecessary file retention.

## Local Development

### Requirements

- PHP 8.2+
- Composer
- Node.js and npm
- Docker and Docker Compose

You can run the project either locally or through Docker, but Docker is the recommended setup for consistency.

### Running with Docker

1. Clone the repository
   ```bash
   git clone https://github.com/your-username/file-converter-app.git
   cd file-converter-app
   ```

2. Copy environment file
   ```bash
   cp .env.example .env
   ```

3. Set important environment values

   Make sure these values are correct for Docker:

   ```bash
   APP_ENV=local
   APP_DEBUG=true
   SESSION_DRIVER=file

   IMAGEMAGICK_BINARY=magick
   GHOSTSCRIPT_BINARY=gs
   PYTHON_BINARY=/opt/venv/bin/python
   ```

4. Start the containers
   ```bash
   docker compose up --build
   ```

5. Generate the application key

   If needed:
   ```bash
   docker compose exec app php artisan key:generate
   ```

6. Clear config and cache if environment changes
   ```bash
   docker compose exec app php artisan optimize:clear
   ```

The app should then be available at: `http://localhost:8000`

### Development Notes

Because the project is mounted as a Docker volume, most source code changes are reflected immediately inside the container.

Usually, you do not need to rebuild Docker when changing:

- Controllers
- Services
- Routes
- Blade views
- Tailwind or frontend source files

You usually do need to rebuild when changing:

- Dockerfile
- System packages
- PHP extensions
- Python dependencies
- Major container configuration

### Useful commands

```bash
docker compose up
docker compose down
docker compose exec app php artisan optimize:clear
docker compose exec app composer dump-autoload
```

### PDF → Word Python Setup

The PDF → Word converter uses Python and pdf2docx.

Python dependencies are listed in: `python/requirements.txt`

The conversion script is: `python/convert_pdf_to_docx.py`

Inside Docker, the configured Python binary should be: `/opt/venv/bin/python`

## Configuration

Custom converter-related configuration lives in: `config/converter.php`

Example:

```php
return [
    'temp_dir' => storage_path('app/temp'),
    'imagemagick' => env('IMAGEMAGICK_BINARY', 'magick'),
    'ghostscript' => env('GHOSTSCRIPT_BINARY', 'gs'),
    'python_binary' => env('PYTHON_BINARY', '/opt/venv/bin/python'),
    'pdf_to_word_script' => env('PDF_TO_WORD_SCRIPT', base_path('python/convert_pdf_to_docx.py')),
];
```

## Current Limitations

This project is still evolving, and there are some known limitations:

- PDF → Image currently converts the first page only
- PDF → Word quality depends on the structure of the original PDF
- Highly complex PDFs may not convert perfectly to DOCX
- No async queue system yet for heavy conversions
- No drag-and-drop upload UI yet
- No progress tracking yet
- Free hosting may struggle with large files or heavy usage

## Deployment Notes

This project is Dockerized and can be deployed to platforms that support Docker-based web services.

A deployment target such as Render works well for hobby or demo use, especially because:

- The app does not require a database
- Files are temporary
- Persistent storage is not required for the current architecture

For production-style deployment, use environment variables such as:

```bash
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:your-generated-key
SESSION_DRIVER=file
CACHE_STORE=file
FILESYSTEM_DISK=local
IMAGEMAGICK_BINARY=magick
GHOSTSCRIPT_BINARY=gs
PYTHON_BINARY=/opt/venv/bin/python
```

## Future Improvements

Planned or possible future features:

- Word → PDF
- Merge PDF
- Split PDF
- Compress PDF
- Image resize and compression
- Reusable upload form component
- Better loading states and conversion feedback
- Scheduled cleanup fallback
- Conversion registry pattern for scaling to more tools
- Improved deployment setup for production

## Learning Goals Behind This Project

This project is also part of a hands-on learning journey around:

- Laravel request lifecycle
- Controllers and service classes
- File uploads and downloads
- Temporary file handling
- Docker-based development
- Integrating Python scripts into a Laravel application
- Building a cleaner architecture for multiple converter tools

## License

This project is open-source and available under the MIT License.