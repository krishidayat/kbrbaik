import React, { useEffect, useState } from "react";
import { Activity, Radio, Cpu, Sparkles, Key, Signal, Wifi } from "lucide-react";

export default function Header() {
  const [apiKeyStatus, setApiKeyStatus] = useState<"checking" | "active" | "simulated">("checking");
  const [vpsUptime, setVpsUptime] = useState("0h 0m 0s");
  const [scrollBlur, setScrollBlur] = useState(false);

  useEffect(() => {
    const handleScroll = () => setScrollBlur(window.scrollY > 20);
    window.addEventListener("scroll", handleScroll, { passive: true });
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  useEffect(() => {
    const checkApiKey = async () => {
      try {
        const response = await fetch("/api/gemini/chat", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ messages: [{ role: "user", content: "ping" }] })
        });
        const data = await response.json();
        setApiKeyStatus(data.fallback ? "simulated" : "active");
      } catch {
        setApiKeyStatus("simulated");
      }
    };
    checkApiKey();

    const start = Date.now();
    const timer = setInterval(() => {
      const diff = Date.now() - start;
      const secs = Math.floor((diff / 1000) % 60);
      const mins = Math.floor((diff / (1000 * 60)) % 60);
      const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
      setVpsUptime(`${hours}h ${mins}m ${secs}s`);
    }, 1000);
    return () => clearInterval(timer);
  }, []);

  return (
    <header
      className={`fixed top-0 left-0 right-0 z-50 transition-all duration-300 ${
        scrollBlur ? "glass-dark shadow-lg" : "bg-slate-900"
      }`}
    >
      <div className="max-w-7xl mx-auto px-4 md:px-6">
        <div className="flex items-center justify-between h-16 md:h-20">
          <div className="flex items-center gap-3">
            <div className="relative">
              <div className="w-10 h-10 rounded-xl gradient-teal flex items-center justify-center shadow-lg shadow-teal-500/20">
                <Radio className="w-5 h-5 text-white" />
              </div>
              <span className="absolute -top-1 -right-1 w-3 h-3 rounded-full bg-emerald-400 border-2 border-slate-900 animate-pulse" />
            </div>
            <div>
              <div className="flex items-center gap-2.5">
                <h1 className="font-display font-extrabold text-xl tracking-tight text-white">
                  Kbr<span className="text-gradient-teal">Baik</span>
                </h1>
                <span className="hidden sm:inline-flex text-[10px] font-mono uppercase tracking-widest px-2 py-0.5 rounded-md border border-slate-700 text-teal-300 bg-slate-800/50">
                  Live
                </span>
              </div>
              <p className="text-[11px] text-slate-400 font-sans hidden sm:block">
                Radio Komunitas & AI Otonom — PGIW Jabar
              </p>
            </div>
          </div>

          <div className="flex items-center gap-2 md:gap-3">
            <div className="hidden md:flex items-center gap-2 bg-slate-800/50 px-3 py-1.5 rounded-lg border border-slate-700/50">
              <Cpu className="w-3 h-3 text-teal-400" />
              <span className="text-[11px] font-mono text-slate-400">
                Uptime: <span className="text-slate-200 font-medium">{vpsUptime}</span>
              </span>
            </div>

            <div className="hidden md:flex items-center gap-2 bg-slate-800/50 px-3 py-1.5 rounded-lg border border-slate-700/50">
              <Signal className="w-3 h-3 text-indigo-400" />
              <span className="text-[11px] font-mono text-indigo-300 font-medium">Live</span>
            </div>

            {apiKeyStatus === "checking" ? (
              <div className="flex items-center gap-1.5 bg-slate-800/50 px-3 py-1.5 rounded-lg border border-slate-700/50">
                <span className="w-1.5 h-1.5 rounded-full bg-amber-400 animate-bounce" />
                <span className="text-[11px] font-mono text-slate-400">AI...</span>
              </div>
            ) : apiKeyStatus === "active" ? (
              <div className="flex items-center gap-1.5 bg-emerald-950/30 px-3 py-1.5 rounded-lg border border-emerald-800/30">
                <Sparkles className="w-3 h-3 text-emerald-400" />
                <span className="text-[11px] font-mono text-emerald-300 font-medium">Gemini Active</span>
              </div>
            ) : (
              <div className="flex items-center gap-1.5 bg-amber-950/30 px-3 py-1.5 rounded-lg border border-amber-800/30">
                <Key className="w-3 h-3 text-amber-400" />
                <span className="text-[11px] font-mono text-amber-300 font-medium">Simulasi</span>
              </div>
            )}
          </div>
        </div>
      </div>
    </header>
  );
}
