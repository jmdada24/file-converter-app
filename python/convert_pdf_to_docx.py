import sys
from pathlib import Path
from pdf2docx import Converter


def main():
    if len(sys.argv) != 3:
        print("Usage: python convert_pdf_to_docx.py input.pdf output.docx", file=sys.stderr)
        sys.exit(1)

    input_path = Path(sys.argv[1]).resolve()
    output_path = Path(sys.argv[2]).resolve()

    if not input_path.exists():
        print(f"Input file not found: {input_path}", file=sys.stderr)
        sys.exit(1)

    cv = Converter(str(input_path))
    try:
        cv.convert(str(output_path))
    finally:
        cv.close()

    if not output_path.exists():
        print("Conversion failed: output DOCX was not created.", file=sys.stderr)
        sys.exit(1)


if __name__ == "__main__":
    main()