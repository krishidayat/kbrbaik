<?php
$f = '/var/www/radio/resources/views/pojok.blade.php';
$c = file_get_contents($f);

$chart = <<<'HTML'

<section id="struktur" style="padding:4rem 2rem;max-width:1100px;margin:0 auto">
  <h2 style="font-family:'Cormorant Garamond',Georgia,serif;font-size:2rem;font-weight:600;margin-bottom:0.5rem">Struktur</h2>
  <p style="color:#555;font-size:0.95rem;margin-bottom:2rem">Bagan organisasi Pojok KbrBaik</p>
  <div style="display:flex;flex-direction:column;align-items:center;gap:1.5rem">
    <div style="display:flex;gap:1rem;flex-wrap:wrap;justify-content:center">
      <div style="background:#fff;border:0.5px solid rgba(0,0,0,0.08);border-radius:16px;padding:1rem 1.5rem;text-align:center;min-width:160px;border-top:3px solid #1D9E75"><div style="font-size:0.7rem;font-family:'DM Mono',monospace;text-transform:uppercase;color:#999">Pembina</div><div style="font-weight:600">MPH PGIW Jabar</div></div>
    </div>
    <div style="width:2px;height:20px;background:rgba(0,0,0,0.15)"></div>
    <div style="display:flex;gap:1rem;flex-wrap:wrap;justify-content:center">
      <div style="background:#fff;border:0.5px solid rgba(0,0,0,0.08);border-radius:16px;padding:1rem 1.5rem;text-align:center;min-width:160px;border-top:3px solid #2563EB"><div style="font-size:0.7rem;font-family:'DM Mono',monospace;text-transform:uppercase;color:#999">Pengelola</div><div style="font-weight:600">Pojok KbrBaik</div><div style="font-size:0.8rem;color:#555">Tim Redaksi & Produksi</div></div>
    </div>
    <div style="width:2px;height:20px;background:rgba(0,0,0,0.15)"></div>
    <div style="display:flex;gap:0.8rem;flex-wrap:wrap;justify-content:center">
      <div style="background:#fff;border:0.5px solid rgba(0,0,0,0.08);border-radius:16px;padding:0.8rem 1.2rem;text-align:center;min-width:130px;border-top:3px solid #B45309"><div style="font-size:0.7rem;font-family:'DM Mono',monospace;text-transform:uppercase;color:#999">Studio</div><div style="font-weight:600;font-size:0.9rem">SiKDig</div></div>
      <div style="background:#fff;border:0.5px solid rgba(0,0,0,0.08);border-radius:16px;padding:0.8rem 1.2rem;text-align:center;min-width:130px;border-top:3px solid #B45309"><div style="font-size:0.7rem;font-family:'DM Mono',monospace;text-transform:uppercase;color:#999">Studio</div><div style="font-weight:600;font-size:0.9rem">Signal Media AI</div></div>
      <div style="background:#fff;border:0.5px solid rgba(0,0,0,0.08);border-radius:16px;padding:0.8rem 1.2rem;text-align:center;min-width:130px;border-top:3px solid #B45309"><div style="font-size:0.7rem;font-family:'DM Mono',monospace;text-transform:uppercase;color:#999">Studio</div><div style="font-weight:600;font-size:0.9rem">SobatTTM</div></div>
    </div>
    <div style="width:2px;height:20px;background:rgba(0,0,0,0.15)"></div>
    <div style="display:flex;gap:0.8rem;flex-wrap:wrap;justify-content:center">
      <div style="background:#fff;border:0.5px solid rgba(0,0,0,0.08);border-radius:12px;padding:0.6rem 1rem;text-align:center;min-width:100px"><div style="font-weight:600;font-size:0.85rem">Podcast</div></div>
      <div style="background:#fff;border:0.5px solid rgba(0,0,0,0.08);border-radius:12px;padding:0.6rem 1rem;text-align:center;min-width:100px"><div style="font-weight:600;font-size:0.85rem">Narasi</div></div>
      <div style="background:#fff;border:0.5px solid rgba(0,0,0,0.08);border-radius:12px;padding:0.6rem 1rem;text-align:center;min-width:100px"><div style="font-weight:600;font-size:0.85rem">Foto</div></div>
      <div style="background:#fff;border:0.5px solid rgba(0,0,0,0.08);border-radius:12px;padding:0.6rem 1rem;text-align:center;min-width:100px"><div style="font-weight:600;font-size:0.85rem">Live</div></div>
    </div>
  </div>
</section>

HTML;

$c = str_replace('<footer>', $chart . "\n<footer>", $c);
file_put_contents($f, $c);
echo "OK\n";
