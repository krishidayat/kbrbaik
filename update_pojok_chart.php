<?php
$f = '/var/www/radio/resources/views/pojok.blade.php';
$html = file_get_contents($f);

// Add chart CSS before </style>
$chartCss = '
.chart{display:flex;flex-direction:column;align-items:center;gap:2rem;margin:2rem 0}
.chart-level{display:flex;gap:1.5rem;flex-wrap:wrap;justify-content:center}
.chart-node{background:var(--white);border:0.5px solid var(--border);border-radius:var(--rl);padding:1rem 1.5rem;text-align:center;min-width:160px;transition:box-shadow 0.25s,transform 0.25s}
.chart-node:hover{box-shadow:0 4px 20px rgba(0,0,0,0.06);transform:translateY(-2px)}
.chart-node .label{font-size:0.7rem;font-family:var(--mono);text-transform:uppercase;letter-spacing:0.08em;color:var(--ink-faint);margin-bottom:0.2rem}
.chart-node .title{font-weight:600;font-size:0.95rem}
.chart-node .sub{font-size:0.8rem;color:var(--ink-muted);margin-top:0.2rem}
.chart-node.teal{border-top:3px solid var(--teal)}
.chart-node.blue{border-top:3px solid var(--blue)}
.chart-node.amber{border-top:3px solid var(--amber)}
.chart-connector{width:2px;height:24px;background:var(--border-strong)}
';

$html = str_replace('</style>', $chartCss . '</style>', $html);

// Add chart section after hero
$chartSection = '
<section id="struktur" class="section">
  <h2>Struktur</h2>
  <p>Bagan organisasi Pojok KbrBaik</p>
  <div class="chart">
    <div class="chart-level">
      <div class="chart-node teal">
        <div class="label">Pembina</div>
        <div class="title">MPH PGIW Jabar</div>
        <div class="sub">Majelis Pekerja Harian</div>
      </div>
    </div>
    <div class="chart-connector"></div>
    <div class="chart-level">
      <div class="chart-node blue">
        <div class="label">Pengelola</div>
        <div class="title">Pojok KbrBaik</div>
        <div class="sub">Tim Redaksi & Produksi</div>
      </div>
    </div>
    <div class="chart-connector"></div>
    <div class="chart-level" style="gap:1rem">
      <div class="chart-node amber"><div class="label">Studio</div><div class="title">SiKDig</div><div class="sub">Kepemimpinan Digital</div></div>
      <div class="chart-node amber"><div class="label">Studio</div><div class="title">Signal Media AI</div><div class="sub">AI & Media</div></div>
      <div class="chart-node amber"><div class="label">Studio</div><div class="title">SobatTTM</div><div class="sub">Podcast & Audio</div></div>
    </div>
    <div class="chart-connector"></div>
    <div class="chart-level" style="gap:1rem">
      <div class="chart-node"><div class="label">Kegiatan</div><div class="title">🎙 Podcast</div></div>
      <div class="chart-node"><div class="label">Kegiatan</div><div class="title">✍️ Narasi</div></div>
      <div class="chart-node"><div class="label">Kegiatan</div><div class="title">📸 Foto</div></div>
      <div class="chart-node"><div class="label">Kegiatan</div><div class="title">📡 Live</div></div>
    </div>
  </div>
</section>
';

$html = str_replace('<section id="komunitas"', $chartSection . '<section id="komunitas"', $html);

file_put_contents($f, $html);
echo "OK\n";
