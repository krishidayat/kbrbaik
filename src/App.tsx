import React, { useState } from "react";
import Header from "./components/Header";
import PillarGrid from "./components/PillarGrid";
import FlowSimulator from "./components/FlowSimulator";
import WikiAIChat from "./components/WikiAIChat";
import {
  Network, ArrowRight, Settings, Download, Copy, Database,
  Plus, Check, HelpCircle, FileCode, Info, Layers,
  Sparkles, Radio, BookOpen, Zap, ChevronRight,
  Globe, Volume2, Menu, X
} from "lucide-react";

interface SchemaField {
  name: string;
  type: string;
  description: string;
  required: boolean;
  selected: boolean;
}

const INITIAL_FIELDS: SchemaField[] = [
  { name: "id", type: "Integer (UID Auto-Increment)", description: "Pengenal unik dokumen", required: true, selected: true },
  { name: "title", type: "String", description: "Judul khotbah / berita jemaat Jabar", required: true, selected: true },
  { name: "original_source", type: "Enumeration (Radio | Spotify | YouTube)", description: "Sumber asal siaran", required: true, selected: true },
  { name: "raw_transcript", type: "Text (Long)", description: "Naskah mentah hasil transkrip audio Whisper", required: true, selected: true },
  { name: "wiki_content_formal", type: "Rich Text (Markdown)", description: "Artikel formal dengan standarisasi bahasa PGIW", required: false, selected: true },
  { name: "youth_content_populer", type: "Rich Text (Markdown)", description: "Artikel santai bergaya pemuda kbrbaik.live", required: false, selected: true },
  { name: "bidang_PGIW", type: "Enumeration (Pemuda | Wanita | Umum)", description: "Kategori bidang gereja terkait", required: true, selected: true },
  { name: "published_at", type: "DateTime", description: "Waktu penerbitan otomatis terotomasi", required: false, selected: true },
  { name: "meta_seo_keywords", type: "String", description: "Kata kunci untuk pencarian search engine", required: false, selected: false },
  { name: "audio_assets_url", type: "String", description: "Tautan URL penyimpanan format .mp3", required: false, selected: false },
];

type TabId = "arch" | "sandbox" | "chat" | "database";

const TABS: { id: TabId; label: string; icon: React.ReactNode; desc: string }[] = [
  { id: "arch", label: "Arsitektur", icon: <Network className="w-4 h-4" />, desc: "Peta sistem & 4 pilar" },
  { id: "sandbox", label: "Hermes AI", icon: <Sparkles className="w-4 h-4" />, desc: "Uji coba pipeline" },
  { id: "chat", label: "WikiAI Chat", icon: <BookOpen className="w-4 h-4" />, desc: "Konsultasi AI" },
  { id: "database", label: "Strapi Planner", icon: <Database className="w-4 h-4" />, desc: "Skema database" },
];

export default function App() {
  const [fields, setFields] = useState<SchemaField[]>(INITIAL_FIELDS);
  const [newFieldName, setNewFieldName] = useState("");
  const [newFieldType, setNewFieldType] = useState("String");
  const [copied, setCopied] = useState(false);
  const [activeTab, setActiveTab] = useState<TabId>("arch");
  const [hoveredNode, setHoveredNode] = useState<string | null>(null);

  const toggleFieldSelection = (index: number) => {
    const updated = [...fields];
    if (updated[index].required && updated[index].name === "id") return;
    updated[index].selected = !updated[index].selected;
    setFields(updated);
  };

  const addCustomField = () => {
    if (!newFieldName.trim()) return;
    const item: SchemaField = {
      name: newFieldName.toLowerCase().replace(/\s+/g, "_"),
      type: newFieldType,
      description: "Custom field ditambahkan oleh tim pengembang jemaat",
      required: false,
      selected: true
    };
    setFields([...fields, item]);
    setNewFieldName("");
  };

  const getStrapiSchemaJSON = () => {
    const active = fields.filter((f) => f.selected);
    const attributes: Record<string, any> = {};
    active.forEach((f) => {
      if (f.name === "id") return;
      attributes[f.name] = {
        type: f.type.toLowerCase().split(" ")[0],
        required: f.required,
        configurable: true
      };
    });
    return JSON.stringify({
      collectionName: "kbrbaik_contents",
      info: {
        singularName: "kbrbaik-content",
        pluralName: "kbrbaik-contents",
        displayName: "PGIW Jabar Contents Hub",
        description: "Postgres structured storage generated dynamically for Hermes & WikiAI Jabar"
      },
      options: { draftAndPublish: true },
      attributes
    }, null, 2);
  };

  const copyToClipboard = () => {
    navigator.clipboard.writeText(getStrapiSchemaJSON());
    setCopied(true);
    setTimeout(() => setCopied(false), 2000);
  };

  const downloadJSONfile = () => {
    const dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(getStrapiSchemaJSON());
    const downloadAnchor = document.createElement("a");
    downloadAnchor.setAttribute("href", dataStr);
    downloadAnchor.setAttribute("download", "strapi-schema-kbrbaik.json");
    document.body.appendChild(downloadAnchor);
    downloadAnchor.click();
    downloadAnchor.remove();
  };

  return (
    <div className="min-h-screen bg-slate-50 flex flex-col font-sans antialiased">
      <Header />

      <main className="flex-1 pt-20 md:pt-24">
        {/* ===== HERO SECTION ===== */}
        <section className="relative overflow-hidden bg-slate-900">
          <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(20,184,166,0.12),transparent_60%)]" />
          <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,rgba(99,102,241,0.08),transparent_60%)]" />
          <div className="absolute top-1/4 -right-20 w-72 h-72 bg-teal-500/10 rounded-full blur-3xl" />
          <div className="absolute -bottom-20 -left-20 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl" />

          <div className="relative max-w-7xl mx-auto px-4 md:px-6 py-12 md:py-20">
            <div className="max-w-4xl space-y-6">
              <div className="flex items-center gap-3">
                <span className="text-[10px] font-mono font-bold tracking-widest uppercase px-3 py-1 rounded-full bg-teal-500/10 border border-teal-500/20 text-teal-300">
                  Platform AI Otonom v1.2
                </span>
                <span className="text-[10px] font-mono px-3 py-1 rounded-full bg-slate-800 border border-slate-700 text-slate-400">
                  #SinodeJabar
                </span>
              </div>

              <h1 className="text-3xl md:text-5xl lg:text-6xl font-display font-extrabold tracking-tight leading-[1.1] text-white">
                Ekosistem AI Otonom{" "}
                <span className="text-gradient-teal">KbrBaik</span>
                <br />
                <span className="text-slate-300 text-2xl md:text-3xl lg:text-4xl font-medium">
                  Radio Komunitas & Otomatisasi Konten
                </span>
              </h1>

              <p className="text-sm md:text-base text-slate-300 leading-relaxed max-w-2xl">
                Sistem inovatif yang menyatukan infrastruktur penyiaran berbasis komunitas anak muda
                Kristen Jawa Barat, otomatisasi server OpenCode, Strapi CMS v5, dan pemrosesan
                transkrip Hermes AI secara selaras.
              </p>

              <div className="flex flex-wrap gap-3 pt-2">
                <div className="flex items-center gap-2 text-xs text-slate-400 bg-slate-800/50 px-3 py-2 rounded-lg border border-slate-700/50">
                  <Radio className="w-3.5 h-3.5 text-teal-400" />
                  <span>kbrbaik.live</span>
                </div>
                <div className="flex items-center gap-2 text-xs text-slate-400 bg-slate-800/50 px-3 py-2 rounded-lg border border-slate-700/50">
                  <Globe className="w-3.5 h-3.5 text-indigo-400" />
                  <span>wiki.pgiwjabar.org</span>
                </div>
                <div className="flex items-center gap-2 text-xs text-slate-400 bg-slate-800/50 px-3 py-2 rounded-lg border border-slate-700/50">
                  <Zap className="w-3.5 h-3.5 text-cyan-400" />
                  <span>Hermes AI Engine</span>
                </div>
              </div>
            </div>

            {/* Tab Navigation */}
            <nav className="mt-10 md:mt-14 flex flex-wrap gap-2">
              {TABS.map((tab) => (
                <button
                  key={tab.id}
                  onClick={() => setActiveTab(tab.id)}
                  className={`group relative px-4 py-3 rounded-xl text-xs font-display font-bold transition-all duration-200 flex items-center gap-2.5 ${
                    activeTab === tab.id
                      ? "bg-teal-500 text-slate-950 shadow-lg shadow-teal-500/20"
                      : "bg-slate-800/50 text-slate-300 border border-slate-700/50 hover:bg-slate-700/50 hover:text-white"
                  }`}
                >
                  {tab.icon}
                  <div className="text-left">
                    <div>{tab.label}</div>
                    <div className={`text-[9px] font-mono font-normal ${activeTab === tab.id ? "text-slate-800" : "text-slate-500"}`}>
                      {tab.desc}
                    </div>
                  </div>
                </button>
              ))}
            </nav>
          </div>
        </section>

        {/* ===== CONTENT AREA ===== */}
        <section className="max-w-7xl mx-auto px-4 md:px-6 py-8 md:py-12">
          {activeTab === "arch" && (
            <div className="space-y-10">
              {/* Architecture Flow Diagram */}
              <div className="bg-white rounded-2xl border border-slate-200/80 p-6 md:p-8 shadow-sm">
                <div className="mb-6">
                  <h2 className="text-xl md:text-2xl font-display font-bold text-slate-900 flex items-center gap-2">
                    <Network className="w-5 h-5 text-indigo-600" />
                    Alir Data Kolaboratif
                  </h2>
                  <p className="text-sm text-slate-500 mt-1">
                    Bagan arsitektur sistem otonom — hover modul untuk menelaah status kerjanya.
                  </p>
                </div>

                <div className="bg-slate-900 rounded-xl p-5 md:p-8 border border-slate-800 overflow-x-auto">
                  <div className="flex flex-col lg:flex-row items-center justify-between gap-5 lg:gap-2 min-w-[320px] mx-auto">
                    {[
                      { id: "komunitas", label: "Komunitas Anak Muda", sub: "Sumber Input Mentah", desc: "Menyiarkan khotbah, podcaster, rekaman suara.", color: "teal" },
                      { id: "opencode", label: "OpenCode Server", sub: "Automation Engine", desc: "Mendeteksi RSS, fetch YouTube API, trigger webhook.", color: "teal" },
                      { id: "strapi", label: "Strapi CMS v5", sub: "Single Source of Truth", desc: "Penyimpanan pusat aset digital & RBAC.", color: "indigo" },
                      { id: "hermes", label: "Hermes Agent", sub: "The AI Brain", desc: "Mengolah transkrip, memilah teologi, menyusun draf.", color: "cyan" },
                    ].map((node, i) => (
                      <React.Fragment key={node.id}>
                        <div
                          onMouseEnter={() => setHoveredNode(node.id)}
                          onMouseLeave={() => setHoveredNode(null)}
                          className={`p-4 rounded-xl border transition-all duration-300 w-52 text-center cursor-help ${
                            hoveredNode === node.id
                              ? `border-${node.color}-400 bg-slate-800/80 scale-105 shadow-lg`
                              : "border-slate-800 bg-slate-900/60"
                          }`}
                        >
                          <span className={`text-[9px] font-mono uppercase font-bold tracking-widest text-${node.color}-400`}>
                            {node.sub}
                          </span>
                          <h3 className="font-display font-extrabold text-sm text-white mt-1.5">{node.label}</h3>
                          <p className="text-[11px] text-slate-400 mt-1.5 leading-normal">{node.desc}</p>
                        </div>
                        {i < 3 && (
                          <div className="lg:rotate-0 rotate-90 text-slate-600 shrink-0">
                            <ArrowRight className="w-4 h-4 text-teal-400/60" />
                          </div>
                        )}
                      </React.Fragment>
                    ))}
                  </div>

                  {/* Goal Outputs */}
                  <div className="mt-6 pt-6 border-t border-slate-800">
                    <span className="text-[9px] font-mono text-slate-500 uppercase font-bold tracking-widest block text-center mb-4">
                      STRATEGI LUARAN GANDA
                    </span>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <div
                        onMouseEnter={() => setHoveredNode("wiki-target")}
                        onMouseLeave={() => setHoveredNode(null)}
                        className={`p-4 rounded-xl border transition-all bg-indigo-950/20 ${
                          hoveredNode === "wiki-target" ? "border-indigo-500" : "border-indigo-950/80"
                        }`}
                      >
                        <span className="text-[9px] font-mono uppercase font-bold bg-indigo-900/60 text-indigo-300 px-2 py-0.5 rounded-full">
                          GOAL 1: WIKIAI PGIW JABAR
                        </span>
                        <h4 className="font-display font-bold text-sm text-indigo-200 mt-2">wiki.pgiwjabar.org</h4>
                        <p className="text-[11px] text-slate-400 mt-1 leading-relaxed">
                          Arsip dokumen resmi sinode, panduan liturgi, dan basis pengetahuan Chatbot AI.
                        </p>
                      </div>
                      <div
                        onMouseEnter={() => setHoveredNode("podcast-target")}
                        onMouseLeave={() => setHoveredNode(null)}
                        className={`p-4 rounded-xl border transition-all bg-teal-950/20 ${
                          hoveredNode === "podcast-target" ? "border-teal-500" : "border-slate-900"
                        }`}
                      >
                        <span className="text-[9px] font-mono uppercase font-bold bg-teal-900/60 text-teal-300 px-2 py-0.5 rounded-full">
                          GOAL 2: JEJARING PODCAST
                        </span>
                        <h4 className="font-display font-bold text-sm text-teal-200 mt-2">kbrbaik.live</h4>
                        <p className="text-[11px] text-slate-400 mt-1 leading-relaxed">
                          Radio streaming Icecast, feed podcast Spotify/YouTube, renungan anak muda.
                        </p>
                      </div>
                    </div>
                  </div>

                  {/* Hover Info Bar */}
                  <div className="mt-4 p-3 bg-slate-950 text-[11px] text-slate-400 text-center rounded-lg border border-slate-800 font-sans italic">
                    {hoveredNode === "komunitas" && "💡 Langkah 1: Anak muda melayani, membuat konten audio."}
                    {hoveredNode === "opencode" && "💡 Langkah 2: Skrip automasi memantau RSS Feed & API."}
                    {hoveredNode === "strapi" && "💡 Langkah 3: CMS Strapi v5 & PostgreSQL menjaga integritas data."}
                    {hoveredNode === "hermes" && "💡 Langkah 4: AI mengonversi audio via Whisper & memproses gaya ganda."}
                    {hoveredNode === "wiki-target" && "💡 Luaran Formal: Teologi Kristen sesuai standar PGIW."}
                    {hoveredNode === "podcast-target" && "💡 Luaran Populer: Gaya hangat 'KbrBaikers' penuh semangat."}
                    {!hoveredNode && "Arahkan cursor ke modul untuk melacak fungsional kerja sistem."}
                  </div>
                </div>
              </div>

              <PillarGrid />
            </div>
          )}

          {activeTab === "sandbox" && <FlowSimulator />}
          {activeTab === "chat" && <WikiAIChat />}

          {activeTab === "database" && (
            <div className="bg-white rounded-2xl border border-slate-200/80 p-6 md:p-8 shadow-sm">
              <div className="flex items-center gap-2 mb-1.5">
                <span className="text-[10px] font-mono font-bold uppercase px-2 py-0.5 rounded bg-indigo-50 text-indigo-700 border border-indigo-200">
                  Tim IT Komunitas Jabar
                </span>
                <span className="text-[10px] font-mono font-bold uppercase px-2 py-0.5 rounded bg-teal-50 text-teal-700 border border-teal-200">
                  PostgreSQL Native
                </span>
              </div>
              <h2 className="text-xl md:text-2xl font-display font-bold text-slate-900 flex items-center gap-2 mb-1">
                <Database className="w-5 h-5 text-indigo-600" />
                Strapi CMS v5 Schema Planner
              </h2>
              <p className="text-sm text-slate-500 max-w-3xl leading-relaxed mb-8">
                Perancang skema otonom untuk entitas PGIW Jabar. Pilih bidang, lalu ekspor sebagai JSON konfigurasi Strapi.
              </p>

              <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div className="space-y-4">
                  <div className="flex justify-between items-center pb-2 border-b border-slate-100">
                    <h3 className="font-display font-semibold text-sm text-slate-800">Atribut Model Data</h3>
                    <span className="text-xs text-slate-400">{fields.filter(f => f.selected).length} Aktif</span>
                  </div>

                  <div className="grid grid-cols-1 gap-2 max-h-[380px] overflow-y-auto pr-2">
                    {fields.map((field, idx) => (
                      <div
                        key={field.name}
                        onClick={() => toggleFieldSelection(idx)}
                        className={`p-3 rounded-xl border text-left transition-all cursor-pointer flex justify-between items-center card-hover ${
                          field.selected
                            ? "bg-indigo-50/50 border-indigo-200"
                            : "bg-white border-slate-200 text-slate-500 hover:bg-slate-50"
                        }`}
                      >
                        <div className="space-y-0.5">
                          <div className="flex items-center gap-2">
                            <code className="text-xs font-mono font-bold text-slate-900">{field.name}</code>
                            <span className="text-[10px] font-mono bg-indigo-100 text-indigo-700 px-1.5 py-0.5 rounded">
                              {field.type}
                            </span>
                          </div>
                          <p className="text-[11px] text-slate-500">{field.description}</p>
                        </div>
                        {field.selected ? (
                          <div className="w-5 h-5 rounded-full bg-indigo-600 text-white flex items-center justify-center shrink-0">
                            <Check className="w-3 h-3 stroke-[3px]" />
                          </div>
                        ) : (
                          <div className="w-5 h-5 rounded-full border-2 border-slate-300 shrink-0" />
                        )}
                      </div>
                    ))}
                  </div>

                  <div className="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-3">
                    <span className="text-[10px] font-mono font-bold text-slate-500 uppercase tracking-wider">
                      TAMBAH ATRIBUT CUSTOM
                    </span>
                    <div className="flex flex-col sm:flex-row gap-2">
                      <input
                        type="text"
                        placeholder="Nama atribut"
                        value={newFieldName}
                        onChange={(e) => setNewFieldName(e.target.value)}
                        className="flex-1 text-xs p-2.5 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500/20"
                      />
                      <select
                        value={newFieldType}
                        onChange={(e) => setNewFieldType(e.target.value)}
                        className="text-xs p-2.5 bg-white border border-slate-200 rounded-lg focus:outline-none"
                      >
                        <option value="String">String</option>
                        <option value="Rich Text (Markdown)">Markdown</option>
                        <option value="Enumeration">Enumeration</option>
                        <option value="DateTime">DateTime</option>
                        <option value="Boolean">Boolean</option>
                      </select>
                      <button
                        onClick={addCustomField}
                        className="px-4 py-2 bg-slate-900 text-white hover:bg-slate-800 rounded-lg text-xs font-semibold flex items-center justify-center gap-1 shrink-0 transition-all"
                      >
                        <Plus className="w-3.5 h-3.5" />
                        Tambah
                      </button>
                    </div>
                  </div>
                </div>

                <div className="flex flex-col gap-4">
                  <div className="bg-slate-900 rounded-xl border border-slate-800 overflow-hidden flex-1 flex flex-col">
                    <div className="bg-slate-950 px-4 py-3 border-b border-slate-800 flex justify-between items-center">
                      <div className="flex items-center gap-2">
                        <FileCode className="w-4 h-4 text-emerald-400" />
                        <span className="font-mono text-[11px] text-slate-300">content-types/schema.json</span>
                      </div>
                      <div className="flex gap-2">
                        <button onClick={copyToClipboard} className="p-1.5 hover:bg-slate-800 rounded text-slate-400 hover:text-white transition-all">
                          {copied ? <Check className="w-4 h-4 text-emerald-400" /> : <Copy className="w-4 h-4" />}
                        </button>
                        <button onClick={downloadJSONfile} className="p-1.5 hover:bg-slate-800 rounded text-slate-400 hover:text-white transition-all">
                          <Download className="w-4 h-4" />
                        </button>
                      </div>
                    </div>
                    <div className="p-4 overflow-y-auto max-h-[320px]">
                      <pre className="font-mono text-[11px] text-emerald-300/90 whitespace-pre leading-relaxed">
                        {getStrapiSchemaJSON()}
                      </pre>
                    </div>
                  </div>

                  <div className="p-4 bg-indigo-50/50 border border-indigo-100 rounded-xl flex items-start gap-3">
                    <Info className="w-5 h-5 text-indigo-600 shrink-0 mt-0.5" />
                    <div>
                      <h4 className="text-xs font-bold text-indigo-900 font-display">Rekomendasi Eksekusi</h4>
                      <p className="text-[11px] text-indigo-700 leading-relaxed mt-0.5">
                        Buat struktur model tabel ini langsung di Strapi CMS v5 panel admin. Format ini memisahkan konten teologis dari gaya populer secara otonom dalam PostgreSQL.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          )}
        </section>
      </main>

      <footer className="bg-slate-900 border-t border-slate-800 mt-12">
        <div className="max-w-7xl mx-auto px-4 md:px-6 py-10">
          <div className="flex flex-col md:flex-row items-center justify-between gap-6">
            <div className="flex items-center gap-3">
              <div className="w-9 h-9 rounded-lg gradient-teal flex items-center justify-center">
                <Radio className="w-4 h-4 text-white" />
              </div>
              <div>
                <p className="font-display font-bold text-sm text-white">KbrBaik System Hub</p>
                <p className="text-[11px] text-slate-400">Sinergitas Anak Muda, AI Otonom, & Transmisi Injil Ekumenis</p>
              </div>
            </div>
            <div className="flex items-center gap-4 text-[11px] font-mono text-slate-500">
              <span className="text-slate-300">PGIW JABAR</span>
              <span className="hidden sm:inline">•</span>
              <span className="hidden sm:inline text-slate-300">WIKIAI ENGINE</span>
              <span className="hidden sm:inline">•</span>
              <span className="hidden sm:inline text-slate-300">HERMES</span>
              <span>•</span>
              <span>2026</span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  );
}
