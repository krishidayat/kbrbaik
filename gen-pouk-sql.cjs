const now = new Date().toISOString().replace('T', ' ').substring(0, 19);

const poukData = [
  {id:26,name:'POUK Depok II Timur',slug:'pouk-depok-ii-timur'},
  {id:27,name:'POUK Pelita',slug:'pouk-pelita'},
  {id:28,name:'POUK Dian Kasih',slug:'pouk-dian-kasih'},
  {id:29,name:'POUK Pelni',slug:'pouk-pelni'},
  {id:30,name:'POUK Bumi Dirgantara Permai',slug:'pouk-bumi-dirgantara-permai'},
  {id:31,name:'POU PUKris Kota Wisata',slug:'pou-pukris-kota-wisata'},
  {id:32,name:'POUK Citra Gran',slug:'pouk-citra-gran'},
  {id:33,name:'POUK TNI AL Ciangsana',slug:'pouk-tni-al-ciangsana'},
  {id:34,name:'POUK Yon Pomad',slug:'pouk-yon-pomad'},
  {id:35,name:'POUK Graha Prima',slug:'pouk-graha-prima'},
  {id:36,name:'POUK Kemang Pratama',slug:'pouk-kemang-pratama'},
  {id:37,name:'POUK Anugerah Taman Galaxi Indah',slug:'pouk-taman-galaxi-indah'},
  {id:38,name:'POUK Lanud Atangsanjaya',slug:'pouk-lanud-atangsanjaya'},
  {id:39,name:'POUK Suryadharma',slug:'pouk-suryadharma'},
  {id:40,name:'POUK GPI IPDN',slug:'pouk-gpi-ipdn'},
  {id:41,name:'POUK GKPO Lanud Sulaiman',slug:'pouk-lanud-sulaiman'},
  {id:42,name:'POUK Husein Sastranegara',slug:'pouk-husein-sastranegara'},
  {id:43,name:'POUK Legenda Wisata',slug:'pouk-legenda-wisata'},
  {id:44,name:'POUK Ekklesia Batujajar',slug:'pouk-ekklesia-batujajar'},
  {id:45,name:'POUK Maranatha Yonkav 1',slug:'pouk-maranatha-yonkav-1'},
];

const topics = [
  ['Ibadah Minggu', 'ibadah-minggu', 'Ibadah Minggu', 'ibadah minggu bersama digelar oleh'],
  ['Persekutuan Doa', 'persekutuan-doa', 'Persekutuan Doa', 'persekutuan doa rutin dilaksanakan oleh'],
  ['Pelayanan Anak', 'pelayanan-anak', 'Pelayanan Anak', 'kegiatan pelayanan anak diselenggarakan oleh'],
  ['Katekisasi', 'katekisasi', 'Katekisasi', 'katekisasi jemaat baru dilaksanakan oleh'],
  ['Perjamuan Kasih', 'perjamuan-kasih', 'Perjamuan Kasih', 'perjamuan kasih digelar oleh'],
];

let sql = '';
poukData.forEach((p, i) => {
  const t1 = topics[i % topics.length];
  const t2 = topics[(i + 2) % topics.length];
  const ts1 = p.slug + '-' + t1[1];
  const ts2 = p.slug + '-' + t2[1];
  const t1Title = t1[2] + ' ' + p.name;
  const t2Title = t2[2] + ' ' + p.name;
  const t1Body = t1[3] + ' ' + p.name + '. Acara berlangsung penuh sukacita dan dihadiri jemaat serta pelayan gereja.';
  const t2Body = t2[3] + ' ' + p.name + '. Kegiatan berjalan lancar mendapat dukungan penuh dari jemaat dan pengurus.';

  sql += 'INSERT INTO posts (station_id, category_id, title, slug, excerpt, body, type, is_published, published_at, created_at, updated_at) VALUES\n';
  sql += "(2, " + p.id + ", '" + t1Title + "', '" + ts1 + "', '" + t1Body + "', '<p>" + t1Body + "</p><p>Kegiatan ini merupakan wujud komitmen " + p.name + " dalam membangun persekutuan dan pelayanan di lingkungan PGIW Jawa Barat.</p>', 'article', 1, '" + now + "', '" + now + "', '" + now + "'),\n";
  sql += "(2, " + p.id + ", '" + t2Title + "', '" + ts2 + "', '" + t2Body + "', '<p>" + t2Body + "</p><p>Semoga melalui kegiatan ini pelayanan " + p.name + " semakin bertumbuh dan menjadi berkat bagi masyarakat sekitar.</p>', 'article', 1, '" + now + "', '" + now + "', '" + now + "');\n\n";
});

require('fs').writeFileSync('D:/KbrBaik/pouk-posts.sql', sql);
console.log(poukData.length * 2 + ' POUK posts SQL generated');
