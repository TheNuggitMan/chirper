import os
import subprocess
import sys

try:
    from PIL import Image
except ImportError:
    print("Pillow not found. Installing...")
    subprocess.check_call([sys.executable, "-m", "pip", "install", "Pillow"])
    from PIL import Image

converted_files = []

for filename in os.listdir('.'):
    if filename.lower().endswith('.png'):
        webp_name = os.path.splitext(filename)[0] + '.webp'
        if os.path.exists(webp_name):
            print(f"Skipped: {webp_name} already exists")
        else:
            try:
                with Image.open(filename) as img:
                    img.save(webp_name, 'WEBP')
                    print(f"Converted: {filename} → {webp_name}")
                    converted_files.append(filename)
            except Exception as e:
                print(f"Error converting {filename}: {e}")

if converted_files:
    delete = input(f"\n{len(converted_files)} PNG file(s) converted. Delete original PNGs? (y/N): ").strip().lower()
    if delete in ('y', 'yes'):
        for png in converted_files:
            try:
                os.remove(png)
                print(f"Deleted: {png}")
            except Exception as e:
                print(f"Failed to delete {png}: {e}")
    else:
        print("PNG files kept.")
else:
    print("No files were converted.")