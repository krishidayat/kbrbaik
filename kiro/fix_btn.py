path = '/var/www/radio/resources/views/studio/dashboard_v2.blade.php'
content = open(path, encoding='utf-8').read()

# Fix baris toolbar yang rusak
content = content.replace(
    '<button class="btn btn-primary" onclick="openUpload()"&#8679; Upload</button>',
    '<button class="btn btn-primary" onclick="openUpload()">&#8679; Upload</button>'
)

open(path, 'w', encoding='utf-8').write(content)
print('Fixed')
