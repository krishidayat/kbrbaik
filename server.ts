import express from "express";
import path from "path";
import dotenv from "dotenv";
import { GoogleGenAI, Type } from "@google/genai";
import { createServer as createViteServer } from "vite";

dotenv.config();

const app = express();
const PORT = 3000;

app.use(express.json());

// Initialize Gemini SDK with custom telemetry header
let ai: GoogleGenAI | null = null;
const initGemini = () => {
  const apiKey = process.env.GEMINI_API_KEY;
  if (!apiKey || apiKey === "MY_GEMINI_API_KEY") {
    console.warn("WARNING: GEMINI_API_KEY is not configured or still generic placeholder in secrets.");
    return null;
  }
  if (!ai) {
    ai = new GoogleGenAI({
      apiKey: apiKey,
      httpOptions: {
        headers: {
          'User-Agent': "aistudio-build",
        },
      },
    });
  }
  return ai;
};

// API: Process text script using Hermes Agent logic
app.post("/api/gemini/process", async (req, res) => {
  try {
    const { content, title, source } = req.body;
    if (!content) {
      return res.status(400).json({ error: "Konten teks mentah harus diisi." });
    }

    const client = initGemini();
    if (!client) {
      // Return beautiful mock response if API Key is not configured yet
      return res.json({
        success: true,
        fallback: true,
        message: "Menggunakan mode simulasi offline (GEMINI_API_KEY belum disiapkan). Daftarkan API Key Anda di panel Secrets untuk mengaktifkan AI asli!",
        wikiArticle: `### [ARSIP WIKIAI] ${title || "Khotbah/Laporan Pelayanan"}
**Kategori:** Teologi & Pembinaan Jemaat Jabar
**Sumber:** ${source || "Siaran Radio KbrBaik / Rekaman Spotify"}
**Arsip ID:** PGIW-JABAR-${Math.floor(1000 + Math.random() * 9000)}

#### 1. Ringkasan Teologis Formal
Dokumen ini merangkum pembahasan teologis mendalam tentang "${title || "Pelayanan Jemaat"}". Pembahasan difokuskan pada penguatan spiritualitas komunitas Kristen di Jawa Barat dengan menekankan pentingnya kolaborasi generasi muda dalam bersaksi dan melayani di tengah tantangan zaman digital.

#### 2. Poin Ajaran & Tuntunan Sinode Resmi
*   **Spirit Ekumenis:** Menegaskan komitmen kemitraan gereja-gereja anggota PGIW Jabar dalam menebar kebaikan secara otonom.
*   **Transformasi Karakter:** Mendorong regenerasi kepemimpinan muda Kristen yang kokoh iman dan santun berkarya.
*   **Penerapan Teologis:** Pelayanan tidak dinilai dari megahnya program, melainkan jangkauan kasih yang inklusif kepada mereka yang terpinggirkan.
`,
        populerArticle: `### [RENUNGAN KBRBAIK] ${title || "Hari Ini Kita Belajar Kasih"}
**Host/Podcaster:** ${source || "Suara Anak Muda Jabar"}
**Mood:** Edukatif, Santai, Historis

Hey KbrBaikers! Pernah kepikiran gak sih gimana caranya tetap relevan di tengah gempuran dunia yang serba cepet ini? Di podcast kali ini kita ngebongkar habis topik hangat seputar "${title || "Gaya Hidup Anak Tuhan"}".

#### ✨ Takeaways Buat Hari Ini:
*   **Gak Perlu Sempurna untuk Mulai:** Mulailah dari apa yang ada di tangan kita. Suara kecil kita kalau disalurkan lewat radio/podcast bisa jadi berkat luar biasa bagi sesama yang butuh kekuatan di luar sana.
*   **Pilar Kasih Kreatif:** Di tengah ekosistem KbrBaik, kita gak cuma sekedar ngoceh, tapi memancarkan terang. Hermes Agent ngebantuin transkrip, tapi hati dan jiwa tetep dari kita anak muda!
*   **Action Plan:** Coba deh kirim pesan singkat penguatan ke satu orang temenmu hari ini. Let's impact others dynamically! ✨📻
`
      });
    }

    const prompt = `
Anda adalah "Hermes Agent", otak AI utama untuk ekosistem KbrBaik & PGIW Jabar.
Tugas Anda adalah memproses konten lisan mentah (hasil transkripsi obrolan podcast, radio bincang-bincang, atau rekaman khotbah) menjadi dua output tulisan terpisah yang berkualitas tinggi.

Judul Konten Asli: "${title || "Konten KbrBaik"}"
Sumber/Asal: "${source || "Komunitas Anak Muda"}"
Konten Mentah: 
"""
${content}
"""

Tolong hasilkan dua artikel terpisah di dalam respons berformat JSON dengan skema struktur yang tepat berikut:
{
  "wikiArticle": "Tulis naskah literatur Wiki yang sangat formal, teologis, analitis, terstruktur dengan Markdown. Sesuai dengan bahasa dokumentasi resmi PGIW Jabar. Harus mencakup: 1. Kajian Teologi/Isu Formal, 2. Panduan/Tuntunan Sinode Resmi, 3. Relevansi bagi Gereja di Jawa Barat. Tanpa bahasa gaul.",
  "populerArticle": "Tulis artikel blog populer yang ramah pemuda, hangat, komunikatif dengan Markdown, gaya khas KbrBaik.live. Gunakan sapaan hangat kepada pendengar (KbrBaikers/Anak Muda), bagikan aplikasi praktis dengan emoticon menarik, dan buat sub-judul yang kreatif dan membangkitkan semangat."
}

Harap berikan respons dalam struktur JSON murni, tanpa kata pengantar atau penutup di luar JSON.
`;

    const response = await client.models.generateContent({
      model: "gemini-3.5-flash",
      contents: prompt,
      config: {
        responseMimeType: "application/json",
        responseSchema: {
          type: Type.OBJECT,
          properties: {
            wikiArticle: { type: Type.STRING, description: "Artikel Wiki formal terstruktur" },
            populerArticle: { type: Type.STRING, description: "Artikel renungan populer santai anak muda" }
          },
          required: ["wikiArticle", "populerArticle"]
        }
      }
    });

    const resultText = response.text || "{}";
    const parsed = JSON.parse(resultText);
    res.json({
      success: true,
      wikiArticle: parsed.wikiArticle,
      populerArticle: parsed.populerArticle
    });
  } catch (error: any) {
    console.error("Error in process API:", error);
    res.status(500).json({ error: error.message || "Terdapat kegagalan saat memproses konten dengan Hermes Agent API." });
  }
});

// API: WikiAI Chatbot Consultation
app.post("/api/gemini/chat", async (req, res) => {
  try {
    const { messages, category } = req.body;
    if (!messages || !Array.isArray(messages)) {
      return res.status(400).json({ error: "Daftar pesan chat (messages) harus dikirimkan." });
    }

    const client = initGemini();
    if (!client) {
      // Simulation mode
      const userMsg = messages[messages.length - 1]?.content || "";
      let reply = "";
      if (userMsg.toLowerCase().includes("radio") || userMsg.toLowerCase().includes("live")) {
        reply = "KbrBaik.live didukung dengan server Icecast streaming untuk penyiaran radio secara langsung. Anak muda dapat menyiarkan khotbah atau pujian secara real-time, yang rekamannya kemudian otomatis ditangkap oleh OpenCode Automation menuju pusat data Strapi CMS.";
      } else if (userMsg.toLowerCase().includes("hermes")) {
        reply = "Hermes Agent adalah otak AI kami yang berfungsi mengubah audio rekaman podcast/siaran menjadi teks transkrip menggunakan OpenAI Whisper, merangkumnya, dan mendistribusikannya secara mandiri ke wiki.pgiwjabar.org dan kbrbaik.live.";
      } else if (userMsg.toLowerCase().includes("strapi") || userMsg.toLowerCase().includes("database")) {
        reply = "Strapi CMS v5 bertindak sebagai 'Menara Pengawas & Gudang Data' (Single Source of Truth). Dengan integrasi PostgreSQL, Strapi mengamankan semua aset data serta menyediakan panel yang mendukung Role-Based Access Control (RBAC) agar pengurus sinode dapat mengelola data bidang masing-masing secara aman.";
      } else {
        reply = "Syalom! Saya adalah chatbot asisten WikiAI PGIW Jabar. Di mode simulasi offline ini, saya bisa menjelaskan pilar KbrBaik: Radio Icecast, Strapi CMS v5, Hermes Agent AI, atau pemeliharaan sistem dengan OpenCode. Hubungkan API Key Anda di panel Secrets untuk berkonsultasi secara interaktif penuh!";
      }
      return res.json({
        success: true,
        fallback: true,
        reply
      });
    }

    const categoryContext = category 
      ? `Kategori konsultasi saat ini: ${category}. Fokuskan jawaban Anda pada ranah pelayanan tersebut di lingkungan PGIW Jabar.` 
      : "";

    // Convert messages for Google GenAI SDK Chat
    const chatInstance = client.chats.create({
      model: "gemini-3.5-flash",
      config: {
        systemInstruction: `Anda adalah chatbot konsultasi teologi & administrasi gereja Kristen untuk platform WikiAI PGIW Jabar (Persekutuan Gereja-gereja di Indonesia Wilayah Jawa Barat), bagian dari ekosistem otonom KbrBaik.
Gaya bicara Anda: Mengayomi, ramah, berwawasan teologis ekumenis, santun, dan sarat solusi teologi Kristen yang sejalan dengan persatuan gereja di Jawa Barat.

Pedoman konten Anda:
- Anda mengetahui bahwa KbrBaik memiliki 4 pilar otonom: OpenCode (teknisi skrip untuk otomatisasi API), Strapi CMS v5 (Gudang data konten PGIW Jabar), Hermes Agent (AI transkripsi dan rangkuman), dan Infrastruktur Penyiaran (Icecast streaming di kbrbaik.live & Podcast Spotify RSS).
- Anda melayani konseling, bantuan naskah khotbah Kristen, perumusan visi pelayan kepemudaan Kristen Jabar, dan panduan organisasi sinode.
- ${categoryContext}

Berikan jawaban yang ramah, ringkas dan berstruktur Markdown agar mudah dibaca oleh para pendeta, penatua, dan pelayan pemuda Kristen.`
      }
    });

    // We can loop and send previous messages to rebuild history or send them in order
    // Since Gemini SDK chats.create can maintain the session, but here we do simple conversational replay:
    let lastResponseText = "";
    for (let i = 0; i < messages.length; i++) {
      const msg = messages[i];
      if (i === messages.length - 1) {
        const response = await chatInstance.sendMessage({ message: msg.content });
        lastResponseText = response.text || "";
      } else {
        await chatInstance.sendMessage({ message: msg.content });
      }
    }

    res.json({
      success: true,
      reply: lastResponseText
    });
  } catch (error: any) {
    console.error("Error in chat API:", error);
    res.status(500).json({ error: error.message || "Terdapat kegagalan saat berkonsultasi dengan WikiAI Chatbot API." });
  }
});

// Serve frontend
const startServer = async () => {
  if (process.env.NODE_ENV !== "production") {
    const vite = await createViteServer({
      server: { middlewareMode: true },
      appType: "spa",
    });
    app.use(vite.middlewares);
  } else {
    const distPath = path.join(process.cwd(), "dist");
    app.use(express.static(distPath));
    app.get("*", (req, res) => {
      res.sendFile(path.join(distPath, "index.html"));
    });
  }

  app.listen(PORT, "0.0.0.0", () => {
    console.log(`[KBRBAIK] Server berjalan mulus di http://localhost:${PORT}`);
  });
};

startServer().catch((err) => {
  console.error("Gagal menjalankan server KbrBaik:", err);
});
