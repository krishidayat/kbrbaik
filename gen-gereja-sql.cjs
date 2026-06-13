const now = new Date().toISOString().replace('T', ' ').substring(0, 19);

const gerejaData = [
  {id:57,name:'Banua Niha Kristen Protestan (BNKP)',slug:'bnkp'},
  {id:86,name:'Gereja Allah Peduli Indonesia (GAPI)',slug:'gapi'},
  {id:70,name:'Gereja Anglikan (GA)',slug:'ga'},
  {id:50,name:'Gereja Batak Karo Protestan (GBKP)',slug:'gbkp'},
  {id:64,name:'Gereja Bethel Indonesia (GBI)',slug:'gbi'},
  {id:76,name:'Gereja Bethel Injil Sepenuh (GBIS)',slug:'gbis'},
  {id:61,name:'Gereja Gerakan Pentakosta (GGP)',slug:'ggp'},
  {id:60,name:'Gereja Isa Almasih (GIA)',slug:'gia'},
  {id:84,name:'Gereja Kasih Setia Indonesia (GKSI 64)',slug:'gksi-64'},
  {id:80,name:'Gereja Kemah Injil Indonesia (GKII)',slug:'gkii-kemah'},
  {id:47,name:'Gereja Kristen Indonesia (GKI)',slug:'gki'},
  {id:65,name:'Gereja Kristen Injili Indonesia (GKII)',slug:'gkii'},
  {id:53,name:'Gereja Kristen Jawa (GKJ)',slug:'gkj'},
  {id:59,name:'Gereja Kristen Kalam Kudus (GKKK)',slug:'gkkk'},
  {id:62,name:'Gereja Kristen Muria Indonesia (GKMI)',slug:'gkmi'},
  {id:75,name:'Gereja Kristen Oikoumene Indonesia (GKOI)',slug:'gkoi'},
  {id:69,name:'Gereja Kristen Oikumene (GKO)',slug:'gko'},
  {id:46,name:'Gereja Kristen Pasundan (GKP)',slug:'gkp'},
  {id:71,name:'Gereja Kristen Pengabar Injil (GKPI) Citereup',slug:'gkpi-citereup'},
  {id:66,name:'Gereja Kristen Perjanjian Baru (GKPB)',slug:'gkpb'},
  {id:63,name:'Gereja Kristen Protestan Angkola (GKPA)',slug:'gkpa'},
  {id:51,name:'Gereja Kristen Protestan Indonesia (GKPI)',slug:'gkpi'},
  {id:77,name:'Gereja Kristen Protestan Jawa Barat (GKP Jabar)',slug:'gkp-jabar'},
  {id:54,name:'Gereja Kristen Protestan Simalungun (GKPS)',slug:'gkps'},
  {id:85,name:'Gereja Kristen Setia Indonesia (GKSI Sabas) 105',slug:'gksi-sabas'},
  {id:68,name:'Gereja Kristus (GK)',slug:'gk-gereja'},
  {id:72,name:'Gereja Kristus Rahmani Indonesia (GKRI)',slug:'gkri'},
  {id:58,name:'Gereja Masehi Injili Sangihe Talaud (GMIST)',slug:'gmist'},
  {id:56,name:'Gereja Methodist Indonesia (GMI)',slug:'gmi'},
  {id:83,name:'Gereja Methodist Injili (GMI) INJILI',slug:'gmi-injili'},
  {id:82,name:'Gereja Misi Injili Indonesia (GMII)',slug:'gmii'},
  {id:81,name:'Gereja Niha Keriso Protestan Indonesia (GNKPI)',slug:'gnkpi'},
  {id:79,name:'Gereja Protestan Nusantara (GPN)',slug:'gpn'},
  {id:49,name:'Gereja Protestan di Indonesia bagian Barat (GPIB)',slug:'gpib'},
  {id:67,name:'Gereja Rehoboth (GR)',slug:'gr'},
  {id:74,name:'Gereja Sidang Jemaat Allah (GSJA)',slug:'gsja'},
  {id:55,name:'Gereja Toraja (GETOR)',slug:'getor'},
  {id:87,name:'HKPI (Calon Anggota)',slug:'hkpi'},
  {id:48,name:'Huria Kristen Batak Protestan (HKBP)',slug:'hkbp'},
  {id:52,name:'Huria Kristen Indonesia (HKI)',slug:'hki'},
  {id:78,name:'Kerapatan Gereja Protestan Minahasa (KGPM)',slug:'kgpm'},
  {id:73,name:'Orahua Niha Keriso Protestan (ONKP)',slug:'onkp'},
];

const topics = [
  ['Ibadah Syukur', 'ibadah-syukur', 'Ibadah Syukur', 'ibadah syukur bersama digelar oleh'],
  ['Rapat Koordinasi', 'rapat-koordinasi', 'Rapat Koordinasi', 'rapat koordinasi rutin telah dilaksanakan oleh'],
  ['Pelayanan Kasih', 'pelayanan-kasih', 'Pelayanan Kasih', 'pelayanan kasih telah dilaksanakan oleh'],
  ['Retreat Pemuda', 'retreat-pemuda', 'Retreat Pemuda', 'kegiatan retreat pemuda diikuti oleh'],
  ['Bakti Sosial', 'bakti-sosial', 'Bakti Sosial', 'bakti sosial digelar oleh'],
  ['Seminar Keluarga', 'seminar-keluarga', 'Seminar Keluarga', 'seminar tentang keluarga Kristen diselenggarakan oleh'],
  ['Paskah Bersama', 'paskah-bersama', 'Paskah Bersama', 'perayaan Paskah bersama digelar oleh'],
  ['Natal Bersama', 'natal-bersama', 'Natal Bersama', 'perayaan Natal bersama diadakan oleh'],
];

let sql = '';
let insertCount = 0;

gerejaData.forEach((p, i) => {
  const t1 = topics[i % topics.length];
  const t2 = topics[(i + 4) % topics.length];
  const ts1 = p.slug + '-' + t1[1];
  const ts2 = p.slug + '-' + t2[1];
  const t1Title = t1[2] + ' ' + p.name;
  const t2Title = t2[2] + ' ' + p.name;
  const t1Body = t1[3] + ' ' + p.name + '. Acara berlangsung penuh sukacita dan dihadiri jemaat serta pelayan gereja.';
  const t2Body = t2[3] + ' ' + p.name + '. Kegiatan berjalan lancar mendapat dukungan penuh dari jemaat dan pengurus.';

  sql += "INSERT INTO posts (station_id, category_id, title, slug, excerpt, body, type, is_published, published_at, created_at, updated_at) VALUES\n";
  sql += "(2, " + p.id + ", '" + t1Title + "', '" + ts1 + "', '" + t1Body + "', '<p>" + t1Body + "</p><p>Kegiatan ini merupakan wujud komitmen " + p.name + " dalam membangun persekutuan dan pelayanan di lingkungan PGIW Jawa Barat.</p>', 'article', 1, '" + now + "', '" + now + "', '" + now + "'),\n";
  sql += "(2, " + p.id + ", '" + t2Title + "', '" + ts2 + "', '" + t2Body + "', '<p>" + t2Body + "</p><p>Semoga melalui kegiatan ini pelayanan " + p.name + " semakin bertumbuh dan menjadi berkat bagi masyarakat sekitar.</p>', 'article', 1, '" + now + "', '" + now + "', '" + now + "');\n\n";
  insertCount += 2;
});

require('fs').writeFileSync('D:/KbrBaik/gereja-posts.sql', sql);
console.log(insertCount + ' Gereja posts SQL generated');