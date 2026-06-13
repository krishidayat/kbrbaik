import React, { useState, useRef, useEffect } from "react";
import { ChatMessage } from "../types";
import { MessageSquare, Send, Sparkles, BookOpen, User, Brain, Trash2, ArrowUpRight, Bot } from "lucide-react";
import { motion } from "motion/react";

const CATEGORIES = [
  { id: "all", label: "Konsultasi Umum", color: "slate" },
  { id: "theology", label: "Teologi & Khotbah", color: "teal" },
  { id: "youth", label: "Pelayanan Pemuda", color: "indigo" },
  { id: "organization", label: "Administrasi Sinode", color: "cyan" },
  { id: "multimedia", label: "Multimedia & Penyiaran", color: "purple" }
];

const SUGGESTED_QUESTIONS = [
  {
    category: "theology",
    text: "Bagaimana cara menyusun khotbah kepemudaan yang relevan di era digital menurut konsep ekumenis?"
  },
  {
    category: "youth",
    text: "Berikan rancangan program kerja kreatif pemuda gereja agar mereka tertarik aktif melayani."
  },
  {
    category: "organization",
    text: "Bagaimana pilar kearsipan data multi-bidang memfasilitasi administrasi antargereja PGIW Jabar?"
  },
  {
    category: "multimedia",
    text: "Apa saja langkah teknis mengintegrasikan siaran radio komunitas Icecast dengan otomatisasi AI?"
  }
];

const CAT_COLORS: Record<string, { active: string; hover: string }> = {
  teal: { active: "bg-teal-500 text-white border-teal-500", hover: "hover:bg-teal-50 hover:text-teal-700 hover:border-teal-300" },
  indigo: { active: "bg-indigo-600 text-white border-indigo-600", hover: "hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-300" },
  cyan: { active: "bg-cyan-500 text-white border-cyan-500", hover: "hover:bg-cyan-50 hover:text-cyan-700 hover:border-cyan-300" },
  purple: { active: "bg-purple-600 text-white border-purple-600", hover: "hover:bg-purple-50 hover:text-purple-700 hover:border-purple-300" },
  slate: { active: "bg-slate-900 text-white border-slate-900", hover: "hover:bg-slate-50 hover:text-slate-800 hover:border-slate-300" },
};

export default function WikiAIChat() {
  const [category, setCategory] = useState("all");
  const [messages, setMessages] = useState<ChatMessage[]>([
    {
      id: "welcome",
      role: "assistant",
      content: "Syalom! Selamat datang di **WikiAI Jabar**. Saya siap melayani Anda terkait pemeliharaan administrasi gereja, penyusunan draf khotbah, penatalayanan kepemudaan, serta integrasi teknologi KbrBaik.\n\nAda hal yang bisa kita diskusikan hari ini?",
      timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
    }
  ]);
  const [input, setInput] = useState("");
  const [loading, setLoading] = useState(false);
  const [isFallback, setIsFallback] = useState(false);

  const messagesEndRef = useRef<HTMLDivElement>(null);

  const scrollToBottom = () => {
    messagesEndRef.current?.scrollIntoView({ behavior: "smooth" });
  };

  useEffect(() => {
    scrollToBottom();
  }, [messages, loading]);

  const handleSend = async (textToSend: string) => {
    const userText = textToSend.trim();
    if (!userText || loading) return;

    const userMsg: ChatMessage = {
      id: `usr-${Date.now()}`,
      role: "user",
      content: userText,
      timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
    };

    setMessages(prev => [...prev, userMsg]);
    setInput("");
    setLoading(true);

    try {
      const payloadMessages = [...messages, userMsg].map(({ role, content }) => ({ role, content }));
      const response = await fetch("/api/gemini/chat", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          messages: payloadMessages,
          category: category !== "all" ? category : undefined
        })
      });
      const data = await response.json();
      if (data.success) {
        setIsFallback(!!data.fallback);
        setMessages(prev => [...prev, {
          id: `assistant-${Date.now()}`,
          role: "assistant",
          content: data.reply,
          timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
        }]);
      } else {
        throw new Error(data.error || "Gagal memperoleh respons.");
      }
    } catch {
      setIsFallback(true);
      setMessages(prev => [...prev, {
        id: `assistant-${Date.now()}`,
        role: "assistant",
        content: `Maaf jemaat, terdapat hambatan koneksi. Mode simulasi luring aktif.\n\nTentang pertanyaan Anda: *"${userText}"*, pilar otonom KbrBaik dan WikiAI PGIW Jabar menjamin pemrosesan informasi secara aman melalui VPS, Strapi CMS v5, dan Postgres.\n\n*Silakan masukkan GEMINI_API_KEY di Settings > Secrets untuk mengaktifkan AI asli!*`,
        timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
      }]);
    } finally {
      setLoading(false);
    }
  };

  const clearChat = () => {
    setMessages([{
      id: "welcome",
      role: "assistant",
      content: "Percakapan telah diatur ulang. Ada hal yang ingin Anda diskusikan?",
      timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
    }]);
    setIsFallback(false);
  };

  return (
    <div className="bg-white rounded-2xl border border-slate-200/80 p-6 md:p-8 shadow-sm">
      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-slate-100">
        <div>
          <h2 className="text-xl md:text-2xl font-display font-extrabold text-slate-900 flex items-center gap-2">
            <span className="px-2 py-1 rounded-lg bg-indigo-600 text-white text-sm font-mono font-bold">02</span>
            WikiAI PGIW Jabar
          </h2>
          <p className="text-sm text-slate-500 mt-1">
            Konsultasikan isu teologi, administrasi jemaat, dan panduan organisasi sinode.
          </p>
        </div>
        <button
          onClick={clearChat}
          className="text-xs font-mono font-semibold text-slate-400 hover:text-rose-500 flex items-center gap-1.5 px-3 py-1.5 border border-slate-200 rounded-lg hover:border-rose-200 hover:bg-rose-50/50 transition-all self-start md:self-auto"
        >
          <Trash2 className="w-3.5 h-3.5" />
          Hapus Riwayat
        </button>
      </div>

      <div className="mt-6">
        <span className="text-[10px] font-mono font-bold text-slate-400 uppercase tracking-wider block mb-2">KONTEKS KONSULTASI</span>
        <div className="flex flex-wrap gap-2">
          {CATEGORIES.map((cat) => {
            const isSelected = category === cat.id;
            const color = CAT_COLORS[cat.color] || CAT_COLORS.slate;
            return (
              <button
                key={cat.id}
                onClick={() => setCategory(cat.id)}
                className={`py-1.5 px-3.5 rounded-full border text-xs font-display font-semibold transition-all ${
                  isSelected ? `${color.active} shadow-sm` : `bg-white border-slate-200 text-slate-600 ${color.hover}`
                }`}
              >
                {cat.label}
              </button>
            );
          })}
        </div>
      </div>

      <div className="mt-6 border border-slate-200/80 rounded-xl bg-slate-50/50 flex flex-col overflow-hidden">
        <div className="p-4 md:p-5 space-y-4 overflow-y-auto max-h-[380px] min-h-[300px]">
          {messages.map((msg) => {
            const isUser = msg.role === "user";
            return (
              <div key={msg.id} className={`flex gap-3 max-w-[88%] ${isUser ? "ml-auto flex-row-reverse" : "mr-auto"}`}>
                <div className={`w-8 h-8 rounded-full shrink-0 flex items-center justify-center shadow-sm ${
                  isUser ? "bg-slate-900 text-teal-400" : "bg-indigo-100 text-indigo-600"
                }`}>
                  {isUser ? <User className="w-4 h-4" /> : <Bot className="w-4 h-4" />}
                </div>
                <div className="space-y-1">
                  <div className={`p-3.5 rounded-xl text-xs leading-relaxed font-sans border ${
                    isUser
                      ? "bg-slate-900 text-slate-50 border-slate-800 rounded-tr-none"
                      : "bg-white text-slate-800 border-slate-200/60 rounded-tl-none whitespace-pre-line"
                  }`}>
                    {msg.content}
                  </div>
                  <div className={`text-[9px] font-mono font-medium text-slate-400 px-1 flex items-center gap-1.5 ${isUser ? "justify-end" : "justify-start"}`}>
                    <span>{msg.timestamp}</span>
                    <span>•</span>
                    <span className="capitalize">{msg.role}</span>
                  </div>
                </div>
              </div>
            );
          })}

          {loading && (
            <div className="flex gap-3 max-w-[80%] mr-auto">
              <div className="w-8 h-8 rounded-full bg-slate-100 shrink-0 flex items-center justify-center">
                <Brain className="w-4 h-4 text-slate-400 animate-spin" />
              </div>
              <div className="bg-white border border-slate-200/60 p-3.5 rounded-xl rounded-tl-none pr-8">
                <div className="flex gap-1.5 items-center">
                  <span className="w-1.5 h-1.5 rounded-full bg-slate-400 animate-bounce" style={{ animationDelay: "0ms" }} />
                  <span className="w-1.5 h-1.5 rounded-full bg-slate-400 animate-bounce" style={{ animationDelay: "150ms" }} />
                  <span className="w-1.5 h-1.5 rounded-full bg-slate-400 animate-bounce" style={{ animationDelay: "300ms" }} />
                </div>
              </div>
            </div>
          )}
          <div ref={messagesEndRef} />
        </div>

        <div className="p-3 bg-slate-100/80 border-t border-slate-200 flex gap-2">
          <input
            type="text"
            value={input}
            onChange={(e) => setInput(e.target.value)}
            onKeyDown={(e) => { if (e.key === "Enter") handleSend(input); }}
            placeholder={
              category === "all"
                ? "Tanyakan seputar teologi, radio streaming, atau database..."
                : `Konsultasi: ${CATEGORIES.find(c => c.id === category)?.label}...`
            }
            className="flex-1 p-3 text-xs bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500/20"
          />
          <button
            onClick={() => handleSend(input)}
            disabled={!input.trim() || loading}
            className={`p-3 rounded-lg shadow-sm flex items-center justify-center transition-all ${
              !input.trim() || loading ? "bg-slate-200 text-slate-400 cursor-not-allowed" : "bg-slate-950 text-white hover:bg-slate-800"
            }`}
          >
            <Send className="w-4 h-4 text-teal-400" />
          </button>
        </div>
      </div>

      <div className="mt-6 space-y-3">
        <span className="text-[10px] font-mono font-bold text-slate-400 uppercase tracking-widest block">REKOMENDASI PERTANYAAN</span>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-2.5">
          {SUGGESTED_QUESTIONS.map((q, idx) => (
            <button
              key={idx}
              onClick={() => { setCategory(q.category); handleSend(q.text); }}
              className="p-3.5 bg-slate-50 rounded-lg text-left text-xs border border-slate-200/50 hover:border-teal-300 hover:bg-teal-50/20 text-slate-700 transition-all flex justify-between items-start gap-3 group"
            >
              <div className="space-y-1">
                <span className="text-[9px] font-mono bg-slate-200 text-slate-600 font-bold px-1.5 py-0.5 rounded-md uppercase">
                  {CATEGORIES.find(c => c.id === q.category)?.label}
                </span>
                <p className="leading-snug text-slate-600 font-medium line-clamp-2">"{q.text}"</p>
              </div>
              <ArrowUpRight className="w-3.5 h-3.5 text-slate-400 group-hover:text-teal-600 shrink-0 transition-all" />
            </button>
          ))}
        </div>
      </div>

      {isFallback && (
        <div className="mt-4 p-3.5 bg-amber-50 text-amber-800 border border-amber-200 rounded-lg text-xs flex gap-2.5">
          <Sparkles className="w-4 h-4 text-amber-600 shrink-0 mt-0.5 animate-pulse" />
          <div>
            <p className="font-semibold font-display">Mode Simulasi Offline</p>
            <p className="text-[11px] text-amber-700 mt-0.5">
              Tambahkan <code className="bg-amber-100 px-1 rounded font-mono font-semibold">GEMINI_API_KEY</code> di Secrets Panel untuk konsultasi dinamis penuh.
            </p>
          </div>
        </div>
      )}
    </div>
  );
}
