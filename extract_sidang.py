#!/usr/bin/env python3
"""Extract sidang MPL PGIW Jabar 2026 content for Wiki.js"""
import re

with open('/tmp/sidang-mpl.txt', 'r') as f:
    text = f.read()

# Split by keputusan sections
sections = re.split(r'KEPUTUSAN\s*\nSIDANG MAJELIS PEKERJA LENGKAP', text)

print(f"# Buku Hasil Sidang MPL PGIW Jawa Barat 2026\n")
print(f"**Tanggal:** 13-14 Februari 2026  \n**Lokasi:** Sutan Raja Hotel, Soreang  \n**Tema:** \"Hiduplah Sebagai Terang yang Membuahkan Kebaikan, Keadilan dan Kebenaran\" (Efesus 5:9)\n")

# Find program section
lines = text.split('\n')
in_program = False
program_lines = []
for i, line in enumerate(lines):
    if 'PROGRAM' in line and 'MPH' in line and not in_program:
        in_program = True
    if in_program:
        program_lines.append(line)
        if i > 0 and line.strip() == '' and program_lines and program_lines[-2].strip() == '':
            if len(program_lines) > 50:
                break

print("## Keputusan Sidang\n")
for s in sections[1:]:
    lines_s = s.strip().split('\n')
    title = lines_s[0].strip().rstrip(':')
    title = re.sub(r'^\d+\.?\s*', '', title)
    print(f"- {title}")

print(f"\n## Dokumen Lengkap\n")
print(f"Unduh PDF: [Buku Hasil Sidang MPL PGIW Jabar 2026](/pgiw/sidang-mpl-2026/buku-sidang-mpl-2026.pdf)\n")

# Extract section about programs 2026
print("## Program PGIW Jabar 2026\n")
print("(Ekstraksi dari keputusan sidang)\n")
