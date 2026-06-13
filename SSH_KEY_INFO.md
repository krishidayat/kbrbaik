# SSH Key — KBRBaik VPS

## Lokasi Key

| Lokasi | Path |
|--------|------|
| **VPS** (sudah aman) | `/home/ubuntu/.ssh/laptop_key` |
| **VPS** public | `/home/ubuntu/.ssh/laptop_key.pub` |
| **VPS** authorized | `/home/ubuntu/.ssh/authorized_keys` |
| **Lokal Windows** | `C:\Users\lenovo\.ssh\vps-key` |
| **Backup lokal ini** | `D:\kbrbaik\vps-key-backup.txt` |

## Cara Pakai dari Lokal
```bash
ssh -i "C:\Users\lenovo\.ssh\vps-key" ubuntu@kbrbaik.live
```

## Cara Konek (kalau key ilang)
1. SSH ke VPS dari console provider
2. Generate ulang: `ssh-keygen -t ed25519 -f ~/.ssh/laptop_key -N ""`
3. Aktivasi: `cat ~/.ssh/laptop_key.pub >> ~/.ssh/authorized_keys`
4. Copy isi `~/.ssh/laptop_key` ke file lokal

## Server
- Host: kbrbaik.live (43.134.87.200)
- User: ubuntu
- Domain: *.kbrbaik.live
