const now = new Date().toISOString().replace('T', ' ').substring(0, 19);

const pgisData = [
  {id:11,name:'PGIS Kota Bandung',slug:'pgis-kota-bandung'},
  {id:12,name:'PGIS Kota Cimahi',slug:'pgis-kota-cimahi'},
  {id:13,name:'PGIS Kabupaten Bandung',slug:'pgis-kab-bandung'},
  {id:14,name:'PGIS Kabupaten Bandung Barat',slug:'pgis-kab-bandung-barat'},
  {id:15,name:'PGIS Kabupaten Karawang',slug:'pgis-kab-karawang'},
  {id:16,name:'PGIS Kota Bekasi',slug:'pgis-kota-bekasi'},
  {id:17,name:'PGIS Kabupaten Bekasi',slug:'pgis-kab-bekasi'},
  {id:18,name:'PGIS Kota Depok',slug:'pgis-kota-depok'},
  {id:19,name:'PGIS Kota Bogor',slug:'pgis-kota-bogor'},
  {id:20,name:'PGIS Kabupaten Bogor',slug:'pgis-kab-bogor'},
  {id:21,name:'PGIS Sukabumi',slug:'pgis-sukabumi'},
  {id:22,name:'PGIS Cirebon',slug:'pgis-cirebon'},
  {id:23,name:'PGIS Cianjur',slug:'pgis-cianjur'},
  {id:24,name:'PGIS Subang',slug:'pgis-subang'},
  {id:25,name:'PGIS Purwakarta',slug:'pgis-purwakarta'},
];

const topics = [
  ['Ibadah Syukur', 'ibadah-syukur', 'Ibadah Syukur', 'ibadah syukur bersama digelar oleh'],
  ['Rapat Koordinasi', 'rapat-koordinasi', 'Rapat Koordinasi', 'rapat koordinasi rutin telah dilaksanakan oleh'],
  ['Pelayanan Kasih', 'pelayanan-kasih', 'Pelayanan Kasih', 'pelayanan kasih telah dilaksanakan oleh'],
  ['Retreat Pemuda', 'retreat-pemuda', 'Retreat Pemuda', 'kegiatan retreat pemuda diikuti oleh pemuda dari'],
  ['Bakti Sosial', 'bakti-sosial', 'Bakti Sosial', 'bakti sosial digelar oleh'],
];

let sql = '';
pgisData.forEach((p, i) => {
  const t1 = topics[i % topics.length];
  const t2 = topics[(i + 3) % topics.length];
  const ts1 = p.slug + '-' + t1[1];
  const ts2 = p.slug + '-' + t2[1];
  const t1Title = t1[2] + ' ' + p.name;
  const t2Title = t2[2] + ' ' + p.name;
  const t1Body = t1[3] + ' ' + p.name + '. Acara berlangsung penuh sukacita dan dihadiri jemaat serta pelayan gereja.';
  const t2Body = t2[3] + ' ' + p.name + '. Kegiatan berjalan lancar mendapat dukungan penuh dari jemaat dan pengurus.';

  sql += "INSERT INTO posts (station_id, category_id, title, slug, excerpt, body, type, is_published, published_at, created_at, updated_at) VALUES\n";
  sql += "(2, " + p.id + ", '" + t1Title + "', '" + ts1 + "', '" + t1Body + "', '<p>" + t1Body + "</p><p>Kegiatan ini merupakan wujud komitmen " + p.name + " dalam membangun persekutuan dan pelayanan di lingkungan PGIW Jawa Barat.</p>', 'article', 1, '" + now + "', '" + now + "', '" + now + "'),\n";
  sql += "(2, " + p.id + ", '" + t2Title + "', '" + ts2 + "', '" + t2Body + "', '<p>" + t2Body + "</p><p>Semoga melalui kegiatan ini pelayanan " + p.name + " semakin bertumbuh dan menjadi berkat bagi masyarakat sekitar.</p>', 'article', 1, '" + now + "', '" + now + "', '" + now + "');\n\n";
});

require('fs').writeFileSync('D:/KbrBaik/pgis-posts.sql', sql);
console.log(pgisData.length * 2 + ' PGIS posts SQL generated');
