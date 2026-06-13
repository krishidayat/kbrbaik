<?php
$sandbox = '/var/www/wiki/sandbox';
$max_size = 100 * 1024 * 1024; // 100MB
$allowed = ['pdf', 'docx', 'doc', 'txt', 'md'];
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') ?: '';



// Simple auth
$token_file = __DIR__ . '/.token';
$is_auth = false;
if (file_exists($token_file)) {
    $valid_token = trim(file_get_contents($token_file));
    $is_auth = isset($_COOKIE['token']) && $_COOKIE['token'] === $valid_token;
}

// Login
if (isset($_POST['login'])) {
    if ($_POST['password'] === 'pgiw2026') {
        $token = bin2hex(random_bytes(16));
        file_put_contents($token_file, $token);
        setcookie('token', $token, time() + 86400 * 7);
        header('Location: ' . $base . '/');
        exit;
    }
    $login_error = true;
}

// Handle upload
$message = '';
$msg_type = 'info';
if ($is_auth && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    if ($file['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            $message = 'Tipe file tidak didukung. Gunakan: PDF, DOCX, DOC, TXT, MD';
            $msg_type = 'error';
        } elseif ($file['size'] > $max_size) {
            $message = 'File terlalu besar. Maksimal 100MB.';
            $msg_type = 'error';
        } else {
            $dest = $sandbox . '/' . basename($file['name']);
            if (move_uploaded_file($file['tmp_name'], $dest)) {
                $message = '✅ ' . htmlspecialchars($file['name']) . ' berhasil diupload!';
                $msg_type = 'success';

                // Trigger auto-process (optional)
                if (isset($_POST['auto_process'])) {
                    $escaped_file = escapeshellarg($dest);
                    $output = shell_exec("cd /home/ubuntu/kbrbaik-wiki && scripts/wiki-process.sh $escaped_file 2>&1");
                    $message .= ' File sudah diproses ke wiki.';
                } else {
                    $message .= ' File siap diproses. Chat Hermes: "Proses file di sandbox"';
                }
            } else {
                $message = 'Gagal upload file. Coba lagi.';
                $msg_type = 'error';
            }
        }
    } elseif ($file['error'] !== UPLOAD_ERR_NO_FILE) {
        $message = 'Error upload: ' . $file['error'];
        $msg_type = 'error';
    }
}

// List files
$files = [];
if ($is_auth && is_dir($sandbox)) {
    $items = scandir($sandbox);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..' || $item === 'processed' || $item === 'README.md') continue;
        $path = $sandbox . '/' . $item;
        if (is_file($path)) {
            $ext = strtolower(pathinfo($item, PATHINFO_EXTENSION));
            $files[] = [
                'name' => $item,
                'size' => filesize($path),
                'date' => date('d M Y H:i', filemtime($path)),
                'ext' => $ext
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upload — PGIW Jabar</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f0f2f5; color: #333; min-height: 100vh; }
.container { max-width: 600px; margin: 0 auto; padding: 20px; }
.header { text-align: center; padding: 30px 0 20px; }
.header h1 { font-size: 22px; color: #1a237e; }
.header p { font-size: 13px; color: #666; margin-top: 4px; }
.card { background: white; border-radius: 12px; padding: 24px; margin-bottom: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
.card h2 { font-size: 16px; color: #1a237e; margin-bottom: 16px; }

.upload-zone { border: 2px dashed #bbb; border-radius: 8px; padding: 30px 20px; text-align: center; cursor: pointer; transition: all 0.3s; }
.upload-zone:hover, .upload-zone.dragover { border-color: #1a237e; background: #f5f6ff; }
.upload-zone .icon { font-size: 40px; margin-bottom: 10px; }
.upload-zone p { color: #666; font-size: 14px; }
.upload-zone .hint { font-size: 12px; color: #999; margin-top: 8px; }
.upload-zone input[type=file] { display: none; }

.btn { display: inline-block; padding: 10px 24px; border: none; border-radius: 8px; font-size: 14px; cursor: pointer; transition: all 0.2s; }
.btn-primary { background: #1a237e; color: white; }
.btn-primary:hover { background: #283593; }
.btn-sm { padding: 6px 14px; font-size: 12px; }
.btn-success { background: #2e7d32; color: white; }
.btn-success:hover { background: #388e3c; }
.btn-warning { background: #f9a825; color: #333; }
.btn-warning:hover { background: #fbc02d; }
.btn-danger { background: #c62828; color: white; }
.btn-danger:hover { background: #d32f2f; }

.option-row { display: flex; align-items: center; gap: 8px; margin-top: 12px; font-size: 13px; }
.option-row input[type=checkbox] { width: 16px; height: 16px; }

.message { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
.message.success { background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
.message.error { background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }
.message.info { background: #e3f2fd; color: #1565c0; border: 1px solid #bbdefb; }

.file-list { list-style: none; }
.file-list li { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f0f0f0; font-size: 13px; }
.file-list li:last-child { border-bottom: none; }
.file-list .file-info { flex: 1; }
.file-list .file-name { font-weight: 500; }
.file-list .file-meta { font-size: 11px; color: #999; margin-top: 2px; }
.file-list .file-ext { display: inline-block; padding: 1px 6px; border-radius: 3px; font-size: 10px; font-weight: 600; text-transform: uppercase; margin-right: 8px; }
.ext-pdf { background: #ffebee; color: #c62828; }
.ext-docx, .ext-doc { background: #e3f2fd; color: #1565c0; }
.ext-txt, .ext-md { background: #e8f5e9; color: #2e7d32; }

.empty-state { text-align: center; color: #999; padding: 20px; font-size: 13px; }

.footer { text-align: center; padding: 20px; font-size: 12px; color: #999; }
.footer a { color: #1a237e; text-decoration: none; }

.login-form { max-width: 320px; margin: 40px auto; }
.login-form input[type=password] { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px; margin-bottom: 12px; }
.login-form .btn { width: 100%; }

@media (max-width: 480px) {
    .container { padding: 12px; }
    .card { padding: 16px; }
    .upload-zone { padding: 20px 12px; }
}
</style>
</head>
<body>

<?php if (!$is_auth): ?>
<div class="container">
    <div class="header">
        <h1>📤 Upload Dokumen</h1>
        <p>PGIW Jawa Barat — Wiki</p>
    </div>
    <div class="card login-form">
        <form method="post">
            <input type="password" name="password" placeholder="Masukkan password" autofocus>
            <button type="submit" name="login" class="btn btn-primary">Masuk</button>
        </form>
        <?php if (isset($login_error)): ?>
        <p style="color:#c62828;font-size:13px;text-align:center;margin-top:8px">Password salah. Coba lagi.</p>
        <?php endif; ?>
    </div>
</div>

<?php else: ?>
<div class="container">
    <div class="header">
        <h1>📤 Upload Dokumen</h1>
        <p>PGIW Jawa Barat — Sandbox Wiki</p>
    </div>

    <?php if ($message): ?>
    <div class="message <?= $msg_type ?>"><?= $message ?></div>
    <?php endif; ?>

    <div class="card">
        <h2>Upload File Baru</h2>
        <form method="post" enctype="multipart/form-data" id="upload-form">
            <div class="upload-zone" id="drop-zone">
                <div class="icon">📄</div>
                <p>Klik atau drag & drop file di sini</p>
                <p class="hint">PDF, DOCX, DOC, TXT, MD — Maks 100MB</p>
                <input type="file" name="file" id="file-input" accept=".pdf,.docx,.doc,.txt,.md">
            </div>
            <div class="option-row">
                <input type="checkbox" name="auto_process" id="auto_process">
                <label for="auto_process">Proses otomatis ke wiki setelah upload</label>
            </div>
            <div style="text-align:center;margin-top:16px">
                <button type="submit" class="btn btn-primary" id="upload-btn">Upload</button>
            </div>
        </form>
    </div>

    <div class="card">
        <h2>File di Sandbox (<?= count($files) ?>)</h2>
        <?php if (empty($files)): ?>
        <div class="empty-state">Belum ada file. Upload file di atas.</div>
        <?php else: ?>
        <ul class="file-list">
            <?php foreach ($files as $f): ?>
            <li>
                <div class="file-info">
                    <span class="file-ext ext-<?= $f['ext'] ?>"><?= $f['ext'] ?></span>
                    <span class="file-name"><?= htmlspecialchars($f['name']) ?></span>
                    <div class="file-meta"><?= number_format($f['size'] / 1024, 1) ?> KB — <?= $f['date'] ?></div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <?php if (!empty($files)): ?>
        <div style="text-align:center;margin-top:12px">
            <a href="?process=all" class="btn btn-success btn-sm">Proses Semua ke Wiki</a>
        </div>
        <?php endif; ?>
    </div>

    <div class="footer">
        <p>Chat Hermes: <strong>"Proses file di sandbox"</strong> untuk memproses ke wiki</p>
        <p style="margin-top:4px"><a href="?logout=1">Logout</a></p>
    </div>
</div>

<script>
const zone = document.getElementById('drop-zone');
const input = document.getElementById('file-input');

zone.addEventListener('click', () => input.click());
zone.addEventListener('dragover', (e) => { e.preventDefault(); zone.classList.add('dragover'); });
zone.addEventListener('dragleave', () => zone.classList.remove('dragover'));
zone.addEventListener('drop', (e) => {
    e.preventDefault();
    zone.classList.remove('dragover');
    if (e.dataTransfer.files.length) {
        input.files = e.dataTransfer.files;
        document.getElementById('upload-form').submit();
    }
});

document.getElementById('upload-btn').addEventListener('click', (e) => {
    if (!input.files.length) {
        e.preventDefault();
        alert('Pilih file dulu.');
    }
});
</script>
<?php endif; ?>
</body>
</html>
