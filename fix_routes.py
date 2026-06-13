import re

files = [
    "/var/www/radio/resources/views/kbrbaik-komunitas.blade.php",
    "/var/www/radio/resources/views/kbrbaik-komunitas-show.blade.php",
    "/var/www/radio/resources/views/kbrbaik-studio-show.blade.php",
]

for f in files:
    with open(f, "r") as fh:
        content = fh.read()
    content = content.replace('route("kbrbaik.komunitas")', 'route("komunitas")')
    content = content.replace("route('kbrbaik.komunitas')", "route('komunitas')")
    content = content.replace('route("kbrbaik.komunitas.show', 'route("komunitas.show')
    content = content.replace("route('kbrbaik.komunitas.show", "route('komunitas.show")
    with open(f, "w") as fh:
        fh.write(content)
    print("Fixed " + f)

print("done")
