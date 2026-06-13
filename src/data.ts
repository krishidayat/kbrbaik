import { Pillar, FlowStep, InputTemplate } from "./types";

export const PILLARS: Pillar[] = [
  {
    id: "opencode",
    name: "OpenCode",
    role: "Sang Teknisi Sistem (AI Developer)",
    icon: "Code",
    description: "Bertugas membangun, mengotomatiskan, dan memelihara seluruh kode program di server tanpa lelah secara otonom.",
    fungsi: [
      "Mengotomatiskan pembuatan skrip cron-job untuk memantau RSS Feed Spotify secara melingkar.",
      "Menangkap video baru langsung dari API YouTube sesaat setelah dipublikasikan.",
      "Mengatur jalannya webhook Strapi CMS agar terhubung mulus tanpa hambatan menuju Hermes Agent."
    ],
    manfaat: "Komunitas anak muda tidak perlu mahir koding backend tingkat lanjut; cukup perintahkan OpenCode lewat terminal / bot untuk memperbaiki atau menambah fitur sistem.",
    color: "teal",
    badge: "System Engineer",
    detailedBlueprint: [
      "Cron Job: Runs every 15 minutes checking Spotify RSS feed XML parsing logs.",
      "YouTube API Poller: Listens on WebSub push notifications for immediate video captures.",
      "Vite Dev Engine: Bound to port 3000 running in a sandboxed Node.js container.",
      "Webhook Linker: Delivers secure HMAC-signed payloads immediately to Hermes endpoint."
    ]
  },
  {
    id: "strapi",
    name: "Strapi CMS v5",
    role: "Menara Pengawas & Gudang Data (Content Core)",
    icon: "Database",
    description: "Tempat penyimpanan utama (Single Source of Truth) berbasis PostgreSQL yang mengamankan seluruh aset digital organisasi.",
    fungsi: [
      "Menyediakan panel admin modern untuk pengurus PGIW Jabar memasukkan data kegiatan dan jadwal siaran.",
      "Mengatur jadwal penyiaran radio langsung secara otomatis agar tidak tumpang tindih.",
      "Mengunggah file .mp3 khotbah/podcast ke dalam Media Library dengan kompresi hemat ruang."
    ],
    manfaat: "Memiliki fitur Role-Based Access Control (RBAC) bawaan. Pengurus Bidang Pemuda hanya mengelola porsinya saja, sementara Bidang Wanita mengelola bidangnya sendiri, menjamin kebersihan multisite.",
    color: "indigo",
    badge: "Core Database",
    detailedBlueprint: [
      "Database Layer: Robust PostgreSQL cluster tracking PGIW sectors & tags.",
      "RBAC Shielding: Separates 'Pemuda' role scope from 'Wanita' to guarantee internal data health.",
      "Strapi Assets Manager: Dynamic media delivery CDN proxies for smooth streaming loads.",
      "Content Schema: Entity 'Articles' mapped directly with twin distribution targets (Wiki & Blog)."
    ]
  },
  {
    id: "hermes",
    name: "Hermes Agent",
    role: "Produser Konten & Humas Otonom (The AI Brain)",
    icon: "Brain",
    description: "Hub cerdas berbasis AI yang memproses informasi lisan/mentah menjadi karya teks berkualitas tinggi yang kredibel.",
    fungsi: [
      "Mendeteksi rilis podcast/YouTube baru dari pilar penyiaran.",
      "Mengonversi percakapan lisan menjadi teks naskah akurat dengan integrasi OpenAI Whisper.",
      "Menyaring candaan, jeda iklan, atau basa-basi siaran agar berfokus pada esensi pokok bahasan.",
      "Merangkum inti ajaran menjadi dua format: naskah formal teologis untuk WikiAI, dan blog seru untuk kbrbaik.live."
    ],
    manfaat: "Memiliki Persistent Memory. Hermes mengingat gaya penulisan rohani yang sesuai dengan nilai-nilai PGIW Jabar dan secara mandiri bisa menerima perintah dinamis lewat Telegram.",
    color: "cyan",
    badge: "AI Orchestrator",
    detailedBlueprint: [
      "Whisper Pipeline: Triggers chunked base64 audio transcription requests directly on hook detections.",
      "Persona Mapping: Uses custom temperature (0.3) for formal wiki rendering and (0.8) for popular youth media.",
      "Telegram Core SDK: Connects chat polling instances directly on VPS thread to respond to control flags.",
      "Persistent Knowledgebase: Updates a semantic Vector DB allowing immediate chatbot retrieval syncs."
    ]
  },
  {
    id: "penyiaran",
    name: "Media Broadcast",
    role: "Jembatan Suara Komunitas (Media Suite)",
    icon: "Radio",
    description: "Arsitektur penyiaran multi-format yang menyalurkan inspirasi hidup anak muda Kristen secara luas.",
    fungsi: [
      "Broadcaster (Radio Live): Menggunakan server Icecast/AzuraCast untuk memancarkan suara penyiar ke web kbrbaik.live.",
      "Podcaster: Menggunakan generator RSS Feed otomatis ke Spotify, Apple Podcast, dan Google Podcast.",
      "Video Streamer: Mengalirkan sinyal audio visual langsung atau rekaman ke platform YouTube secara sinkron."
    ],
    manfaat: "Menyediakan wadah bagi anak muda kreatif untuk mengekspresikan bakat komunikasi dan pelayanan spiritual mereka secara global.",
    color: "purple",
    badge: "Broadcasting Suite",
    detailedBlueprint: [
      "Icecast Stream: Emits high-quality 128kbps stereo OGG/MP3 mount points.",
      "Spotify Feeder: Multi-host metadata integration dynamically feeding off Strapi CMS audio assets.",
      "YouTube Encoder: Live RTMP streaming hooks with pre-scheduled youth worship playlists.",
      "Media Analytics: Monitors live stream listeners & podcast download metrics."
    ]
  }
];

export const FLOW_STEPS: FlowStep[] = [
  {
    step: 1,
    title: "Siaran Studio Komunitas",
    description: "Anak muda menyiarkan khotbah atau bincang podcast santai secara live di sela-sela aktivitas harian.",
    outcome: "Sinyal suara disalurkan secara langsung via Server Icecast menuju kbrbaik.live.",
    icon: "Mic"
  },
  {
    step: 2,
    title: "Deteksi Upload Otomatis",
    description: "Setelah rampung, file master audio diunggah ke Spotify (RSS) atau video diposting ke YouTube.",
    outcome: "Skrip otomasi bikinan OpenCode mendeteksi file baru melalui ping Webhook langsung.",
    icon: "UploadCloud"
  },
  {
    step: 3,
    title: "Transkripsi Audio Akurat",
    description: "Skrip OpenCode otomatis mengirimkan unduhan file audio berdurasi tadi ke API Whisper.",
    outcome: "Whisper mengubah suara lisan menjadi teks draf mentahan dengan akurasi ejaan sangat tinggi.",
    icon: "FileText"
  },
  {
    step: 4,
    title: "Penyaringan & Pengetikan Hermes",
    description: "Hermes Agent membaca draf teks mentah tersebut untuk mendeteksi pesan teologis utama.",
    outcome: "Hermes menyaring basa-basi obrolan, lalu memformat teks tersebut ke dalam 2 gaya bahasa terpisah.",
    icon: "Filter"
  },
  {
    step: 5,
    title: "Publikasi Otomatis via Strapi",
    description: "Hermes Agent menembak API Strapi untuk menerbitkan tulisan tersebut di dua situs web.",
    outcome: "Menjadi artikel berita populer di kbrbaik.live, dan materi teologi formal di wiki.pgiwjabar.org.",
    icon: "CheckCircle"
  }
];

export const INPUT_TEMPLATES: InputTemplate[] = [
  {
    id: "pod-1",
    title: "Gaya Hidup Pemuda Kristen di Era Digital",
    source: "Podcast Spotify - Pojok Pemuda Jabar (KbrBaik.live)",
    content: "Halo KbrBaikers! Balik lagi bareng Hendra dan Tasya di Pojok Pemuda Jabar. Kali ini kita kedatangan obrolan seru banget nih tentang gimana kita sebagai anak muda Kristen ngejalanin hidup di zaman digital yang serba medsos ini. Kadang kita kan sering nemu komentar negatif atau flexing di timeline kita ya. Gimana ya caranya biar kita ga keseret arus? Nah, di Matius 5:14 kan diajarkan bahwa kita adalah terang dunia. Berarti di medsos pun akun kita harus jadi pelita dong, bukan malah nambah toxic! Kita harus sebar komentar yang menguatkan, share quote yang informatif, dan bikin konten kreatif yang menginspirasi sesama. Jangan pelit buat sebar kebaikan! Pokoknya, gunakan jempolmu untuk membangun iman sesama, bukan meruntuhkannya. Itu dia obrolan singkat podcaster kita hari ini, sampai jumpa di episode selanjutnya, Tuhan Yesus memberkati!"
  },
  {
    id: "sermon-1",
    title: "Menghadapi Kecemasan Masa Depan",
    source: "Radio Live Streaming - Renungan Malam KbrBaik",
    content: "Syalom saudara-saudara yang dikasihi Tuhan Yesus Kristus, selamat malam para pendengar setia KbrBaik.live. Pada perenungan malam ini, kita diantarkan untuk merenungkan kitab Matius pasal 6 ayat 34, yang menyatakan 'Sebab itu janganlah kamu kuatir akan hari besok, karena hari besok mempunyai kesusahannya sendiri. Kesusahan sehari cukuplah untuk sehari.' Sering kali di tengah dinamika dunia modern di Jawa Barat, tantangan ekonomi, pencarian kerja bagi lulusan baru, dan problematika keluarga menimbulkan rasa cemas yang mendalam bagi batin kita. Namun, firman Tuhan malam ini mengingatkan kita untuk mengandalkan kedaulatan Tuhan secara penuh. Penyerahan diri yang tulus bukanlah sikap pasrah tanpa aksi, melainkan keyakinan aktif bahwa rencana Allah adalah rancangan damai sejahtera yang penuh harapan. Mari jemaat sekalian, kita melepaskan kekuatiran kita di bawah kaki salib Kristus dan melangkah dengan iman kokoh."
  },
  {
    id: "report-1",
    title: "Laporan Musyawarah Pelayanan Pemuda Sinode Jabar",
    source: "Laporan Sinode - Bidang Pemuda Jabar",
    content: "Laporan Musyawarah Pelayanan (Mupel) Pemuda Sinode Jabar tahun 2026. Pertemuan ini dihadiri oleh perwakilan pemuda gereja-gereja sewilayah Jawa Barat dalam rangka menetapkan arah program pelayanan ekumenis semester pertama. Berdasarkan hasil pemetaan, disepakati tiga pilar program utama: Pertama, penguatan literasi digital teologis melalui penyediaan artikel di sistem WikiAI PGIW Jabar. Kedua, pelatihan penyiaran konten kreatif untuk radio streaming kbrbaik.live guna membekali pemuda dalam penyiaran multimedia Kristen. Ketiga, aksi sosial kebencanaan yang berkolaborasi dengan gereja-gereja lokal. Kami bersyukur atas kehadiran 45 utusan jemaat yang bersepakat mendukung sinergitas program ini demi kemuliaan Kristus dan kemandirian gereja-gereja anggota di masa mendatang."
  }
];
