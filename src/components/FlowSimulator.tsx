import React, { useState } from "react";
import { INPUT_TEMPLATES, FLOW_STEPS } from "../data";
import { Play, Sparkles, Send, FileText, Check, Volume2, Globe, Database, RefreshCw, Layers, Mic, Zap, ArrowRight } from "lucide-react";
import { motion, AnimatePresence } from "motion/react";

export default function FlowSimulator() {
  const [selectedTemplate, setSelectedTemplate] = useState(INPUT_TEMPLATES[0]);
  const [customTitle, setCustomTitle] = useState("");
  const [customSource, setCustomSource] = useState("");
  const [customContent, setCustomContent] = useState("");
  const [isCustomMode, setIsCustomMode] = useState(false);
  const [isRunning, setIsRunning] = useState(false);
  const [activeStep, setActiveStep] = useState<number | null>(null);
  const [progressMsg, setProgressMsg] = useState("");
  const [results, setResults] = useState<{ wiki: string; popular: string; isFallback: boolean } | null>(null);
  const [activeTab, setActiveTab] = useState<"wiki" | "popular">("popular");

  const currentTitle = isCustomMode ? customTitle : selectedTemplate.title;
  const currentSource = isCustomMode ? customSource : selectedTemplate.source;
  const currentContent = isCustomMode ? customContent : selectedTemplate.content;

  const handleRunSimulation = async () => {
    if (!currentContent.trim()) {
      alert("Maaf, teks konten mentah tidak boleh kosong.");
      return;
    }

    setIsRunning(true);
    setResults(null);
    setActiveStep(1);
    setProgressMsg("Menyiarkan audio mentah via Icecast server streaming...");

    await new Promise((r) => setTimeout(r, 1500));
    setActiveStep(2);
    setProgressMsg("OpenCode mendeteksi siaran baru. Mengarahkan audio ke API Whisper...");
    await new Promise((r) => setTimeout(r, 1500));
    setActiveStep(3);
    setProgressMsg("Whisper memicu transkrip lisan menjadi teks mentah utuh...");
    await new Promise((r) => setTimeout(r, 1500));
    setActiveStep(4);
    setProgressMsg("Hermes Agent menyaring obrolan dan merumuskan teologi...");

    try {
      const response = await fetch("/api/gemini/process", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ title: currentTitle, source: currentSource, content: currentContent }),
      });
      const data = await response.json();

      setActiveStep(5);
      setProgressMsg("Strapi CMS v5 berhasil menyimpan dan menerbitkan entitas baru.");
      await new Promise((r) => setTimeout(r, 1200));

      if (data.success) {
        setResults({ wiki: data.wikiArticle, popular: data.populerArticle, isFallback: !!data.fallback });
      } else {
        throw new Error(data.error || "Gagal memperoleh draf.");
      }
    } catch {
      setProgressMsg("Gagal memproses AI. Beralih ke mode luring...");
      setResults({
        wiki: `### [ARSIP WIKIAI] ${currentTitle}
**Kategori:** Teologi & Pembinaan Jemaat Jabar
**Sumber:** ${currentSource}
**Status:** Luring / Simulasi Offline

#### 1. Ringkasan Teologis Formal
Dokumen ini merekam penelaahan mendasar tentang pentingnya tema "${currentTitle}" yang berpusat pada penatalayanan pemuda di lingkungan PGIW Jawa Barat.

#### 2. Tuntunan Sinode Resmi
*   **Kolaborasi Pelayanan:** Mengembangkan sinergi antar gereja anggota.
*   **Kearifan Komunikasi:** Menggunakan setiap platform media sebagai sarana pewartaan.`,
        popular: `### [RENUNGAN KBRBAIK] ${currentTitle}
**Host/Podcaster:** ${currentSource}
**Vibe:** Inspiratif & Santai

Halo KbrBaikers! Senang sekali rasanya bisa berbagi insight asyik tentang topik harian kita kali ini: "${currentTitle}".

#### 💡 Refleksi Singkat
Yuk, jangan biarkan kebisingan digital mengaburkan damai sejahtera di hati kita. Tetaplah menjadi pembawa kabar baik yang aktif bersaksi!

**#KbrBaikLive #PemudaGereja #JabarEkumenis** 📡✨`,
        isFallback: true,
      });
    } finally {
      setIsRunning(false);
      setActiveStep(null);
    }
  };

  return (
    <div className="bg-white rounded-2xl border border-slate-200/80 p-6 md:p-8 shadow-sm">
      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-slate-100">
        <div>
          <h2 className="text-xl md:text-2xl font-display font-extrabold text-slate-900 flex items-center gap-2">
            <span className="px-2 py-1 rounded-lg gradient-teal text-white text-sm font-mono font-bold">01</span>
            Hermes AI Sandbox
          </h2>
          <p className="text-sm text-slate-500 mt-1">
            Uji aliran data secara langsung — saksikan bagaimana konten diolah menjadi teks terstruktur.
          </p>
        </div>
        <div className="flex bg-slate-100 p-1 rounded-lg border border-slate-200 text-xs font-medium">
          <button
            onClick={() => setIsCustomMode(false)}
            className={`px-3 py-1.5 rounded-lg transition-all ${!isCustomMode ? "bg-white text-slate-900 shadow-sm" : "text-slate-500 hover:text-slate-900"}`}
          >
            Preset
          </button>
          <button
            onClick={() => setIsCustomMode(true)}
            className={`px-3 py-1.5 rounded-lg transition-all ${isCustomMode ? "bg-white text-slate-900 shadow-sm" : "text-slate-500 hover:text-slate-900"}`}
          >
            Custom
          </button>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 mt-6">
        <div className="lg:col-span-5 space-y-4">
          <div className="bg-slate-50 p-5 rounded-xl border border-slate-200/50 space-y-4">
            <h3 className="font-display font-bold text-slate-900 text-sm flex items-center gap-2">
              <FileText className="w-4 h-4 text-teal-600" />
              Input Konten
            </h3>

            {!isCustomMode ? (
              <div className="space-y-2">
                <span className="text-[10px] font-mono font-bold text-slate-400 uppercase tracking-wider">PILIH PRESET:</span>
                <div className="grid grid-cols-1 gap-2">
                  {INPUT_TEMPLATES.map((tpl) => (
                    <button
                      key={tpl.id}
                      onClick={() => setSelectedTemplate(tpl)}
                      className={`p-3 rounded-lg border text-left transition-all text-xs ${
                        selectedTemplate.id === tpl.id
                          ? "bg-white border-teal-500 shadow-xs ring-1 ring-teal-500/10"
                          : "bg-white/50 border-slate-200 hover:border-slate-300 text-slate-600"
                      }`}
                    >
                      <span className="font-semibold text-slate-900 block truncate">{tpl.title}</span>
                      <span className="text-[10px] font-mono text-slate-400">{tpl.source}</span>
                    </button>
                  ))}
                </div>
              </div>
            ) : (
              <div className="space-y-3">
                <div>
                  <label className="text-[10px] font-mono font-bold text-slate-400 uppercase tracking-wider block mb-1">Judul</label>
                  <input
                    type="text"
                    value={customTitle}
                    onChange={(e) => setCustomTitle(e.target.value)}
                    placeholder="Contoh: Kasih Menembus Sekat Perbedaan"
                    className="w-full text-xs p-3 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500/20"
                  />
                </div>
                <div>
                  <label className="text-[10px] font-mono font-bold text-slate-400 uppercase tracking-wider block mb-1">Sumber</label>
                  <input
                    type="text"
                    value={customSource}
                    onChange={(e) => setCustomSource(e.target.value)}
                    placeholder="Contoh: Radio Pemuda Jabar live"
                    className="w-full text-xs p-3 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500/20"
                  />
                </div>
              </div>
            )}

            <div className="p-3 bg-white rounded-lg border border-slate-200/60">
              <span className="text-[10px] font-mono font-bold text-slate-400 uppercase tracking-widest block mb-1">INFO TRANSKRIP</span>
              <div className="flex items-center justify-between text-xs">
                <span className="font-semibold text-slate-800 truncate max-w-[200px]">{currentTitle}</span>
                <span className="text-[10px] font-mono bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded truncate max-w-[120px]">{currentSource}</span>
              </div>
            </div>

            <div>
              <label className="text-[10px] font-mono font-bold text-slate-400 uppercase tracking-wider block mb-1">Draf Transkrip</label>
              <textarea
                value={isCustomMode ? customContent : currentContent}
                onChange={(e) => {
                  if (isCustomMode) {
                    setCustomContent(e.target.value);
                  } else {
                    setIsCustomMode(true);
                    setCustomTitle(selectedTemplate.title);
                    setCustomSource(selectedTemplate.source);
                    setCustomContent(e.target.value);
                  }
                }}
                rows={6}
                placeholder="Tulis draf kasar teologis di sini..."
                className="w-full text-xs p-4 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500/20 leading-relaxed text-slate-700"
              />
            </div>

            <button
              onClick={handleRunSimulation}
              disabled={isRunning}
              className={`w-full py-3 px-4 rounded-lg font-display font-semibold text-sm transition-all shadow-sm flex items-center justify-center gap-2 ${
                isRunning
                  ? "bg-slate-200 text-slate-400 cursor-not-allowed"
                  : "bg-slate-900 hover:bg-slate-800 text-white"
              }`}
            >
              {isRunning ? (
                <><RefreshCw className="w-4 h-4 animate-spin text-teal-400" /> Memproses...</>
              ) : (
                <><Play className="w-4 h-4 text-teal-400 fill-teal-400" /> Jalankan Pipeline AI</>
              )}
            </button>
          </div>
        </div>

        <div className="lg:col-span-7 flex flex-col gap-6">
          <div className="bg-slate-50 p-5 rounded-xl border border-slate-200/50">
            <h3 className="font-display font-bold text-slate-900 text-sm flex items-center gap-2 mb-4">
              <Layers className="w-4 h-4 text-indigo-600" />
              Pipeline Otomatisasi
            </h3>

            <div className="space-y-3 relative">
              <span className="absolute left-[15px] top-6 bottom-6 w-0.5 bg-slate-200" />
              {FLOW_STEPS.map((step) => {
                const isActive = activeStep === step.step;
                const isDone = activeStep !== null && activeStep > step.step;
                const circle = isActive
                  ? "bg-teal-500 border-teal-500 text-white scale-110 shadow-lg shadow-teal-500/20"
                  : isDone
                  ? "bg-slate-900 border-slate-900 text-emerald-400"
                  : "border-slate-300 text-slate-400 bg-white";
                const item = isActive
                  ? "opacity-100 border-teal-200 bg-white shadow-sm"
                  : isDone
                  ? "opacity-80"
                  : "opacity-50";

                return (
                  <div key={step.step} className={`flex gap-4 p-3 rounded-lg border border-transparent transition-all ${item}`}>
                    <div className={`w-8 h-8 rounded-full border-2 flex items-center justify-center font-mono text-xs font-bold shrink-0 transition-all ${circle}`}>
                      {isDone ? <Check className="w-4 h-4 stroke-[3px]" /> : step.step}
                    </div>
                    <div className="space-y-0.5">
                      <h4 className="text-xs font-display font-bold text-slate-900">{step.title}</h4>
                      <p className="text-[11px] text-slate-500 leading-normal">
                        {isActive ? step.outcome : step.description}
                      </p>
                    </div>
                  </div>
                );
              })}
            </div>

            {activeStep !== null && (
              <div className="mt-4 p-3 bg-slate-900 rounded-lg text-slate-300 font-mono text-[11px] flex items-center gap-2.5 animate-pulse">
                <RefreshCw className="w-3 h-3 animate-spin text-teal-400 shrink-0" />
                <span>{progressMsg}</span>
              </div>
            )}
          </div>

          <AnimatePresence>
            {results && (
              <motion.div
                initial={{ opacity: 0, y: 10 }}
                animate={{ opacity: 1, y: 0 }}
                exit={{ opacity: 0 }}
                className="bg-slate-900 rounded-xl overflow-hidden border border-slate-800"
              >
                <div className="bg-slate-950 p-1 flex border-b border-slate-800">
                  <button
                    onClick={() => setActiveTab("popular")}
                    className={`flex-1 py-2.5 text-xs font-display font-bold rounded-lg transition-all flex items-center justify-center gap-2 ${
                      activeTab === "popular" ? "bg-slate-900 text-teal-400 border border-slate-800" : "text-slate-400 hover:text-slate-200"
                    }`}
                  >
                    <Volume2 className="w-3.5 h-3.5" />
                    kbrbaik.live
                  </button>
                  <button
                    onClick={() => setActiveTab("wiki")}
                    className={`flex-1 py-2.5 text-xs font-display font-bold rounded-lg transition-all flex items-center justify-center gap-2 ${
                      activeTab === "wiki" ? "bg-slate-900 text-indigo-400 border border-slate-800" : "text-slate-400 hover:text-slate-200"
                    }`}
                  >
                    <Globe className="w-3.5 h-3.5" />
                    wiki.pgiwjabar.org
                  </button>
                </div>
                <div className="p-5 overflow-y-auto max-h-[320px] text-slate-300 text-xs leading-relaxed">
                  {results.isFallback && (
                    <div className="mb-3 p-3 bg-amber-950/40 text-amber-300 border border-amber-900/50 rounded-lg flex items-start gap-2 text-[10px] font-mono">
                      <span className="w-1.5 h-1.5 rounded-full bg-amber-400 mt-1 animate-ping shrink-0" />
                      <span>Mode simulasi offline. Tambahkan GEMINI_API_KEY untuk AI asli.</span>
                    </div>
                  )}
                  <div className="whitespace-pre-line font-sans">
                    {activeTab === "popular" ? results.popular : results.wiki}
                  </div>
                </div>
                <div className="p-3 bg-slate-950 border-t border-slate-800 text-[10px] font-mono text-slate-500 flex justify-between items-center px-4">
                  <span className="flex items-center gap-1">
                    <Database className="w-3 h-3 text-indigo-400" />
                    {results.isFallback ? "SIM-DRAFT" : "STRAPI-V5-DOC"}
                  </span>
                  <span className="text-emerald-400 font-semibold uppercase text-[10px]">
                    ✓ TERBIT DI {activeTab === "popular" ? "kbrbaik.live" : "wiki.pgiwjabar.org"}
                  </span>
                </div>
              </motion.div>
            )}
          </AnimatePresence>
        </div>
      </div>
    </div>
  );
}
