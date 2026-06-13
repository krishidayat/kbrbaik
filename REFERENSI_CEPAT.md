# KBRBaik Wiki — Referensi Cepat

## Server
- IP/Host: kbrbaik.live (VPS 43.134.87.200)
- User: ubuntu
- SSH Key: laptop_key (di ~/.ssh/)
- Repo: /home/ubuntu/kbrbaik-wiki/

## Services
| Service | URL | Port |
|---------|-----|------|
| Wiki.js | https://wiki.kbrbaik.live | 3002 (internal) |
| Botpress | (port 3100) | 3100 |
| Laravel CMS | https://kbrbaik.live | 9119 (ssl) |
| Icecast | http://kbrbaik.live:8000 | 8000 |
| Hermes Gateway | localhost | 3200 |

## Wiki.js
- Admin: komikpgiwjabar@gmail.com
- Storage: Git → /wiki-repo
- Internal repo: /wiki/data/repo/
- DB file: /wiki-data/wiki.db

## Wiki Repo
- Path: /home/ubuntu/kbrbaik-wiki/
- Branch: main
- Struktur: wiki/{kategori}/
- Pipeline: scripts/wiki-process.sh

## Pipeline (agentic-wiki-builder)
- Repo: /home/ubuntu/agentic-wiki-builder/
- Proses: `./scripts/wiki-process.sh <file> [kategori] [prompt]`
- Alur: Writer → Editor → Linker → Commit → Merge

## Hermes Skills
- wiki-kbrbaik: manage wiki via WA/Telegram
- humas-pgiw-jabar: PR & publikasi
- suara-pgiw-jabar: content management

## Docker
- Container: wikijs
- Compose: /home/ubuntu/docker-compose.wiki.yml
- Data: /home/ubuntu/wiki.js-data/

## Local Access (Windows)
- D:\kbrbaik\ — project root
- C:\Users\lenovo\.ssh\vps-key — SSH key
- C:\Users\lenovo\AGENTS.md — project instructions

## Quick Start
```bash
# Proses dokumen ke wiki
ssh ubuntu@kbrbaik.live "./kbrbaik-wiki/scripts/wiki-process.sh ~/file.pdf kategori"

# Sync wiki ke git
ssh ubuntu@kbrbaik.live "cd ~/kbrbaik-wiki && git add -A && git commit -m 'update'"

# Cek status Wiki.js
ssh ubuntu@kbrbaik.live "sudo docker logs wikijs --tail 10"

# Restart Wiki.js
ssh ubuntu@kbrbaik.live "sudo docker restart wikijs"
```
