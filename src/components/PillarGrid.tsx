import React, { useState } from "react";
import { PILLARS } from "../data";
import { Pillar } from "../types";
import { Code, Database, Brain, Radio, ShieldCheck, Terminal, Layers, ChevronRight } from "lucide-react";
import { motion, AnimatePresence } from "motion/react";

const renderIcon = (iconName: string, className: string) => {
  switch (iconName) {
    case "Code": return <Code className={className} />;
    case "Database": return <Database className={className} />;
    case "Brain": return <Brain className={className} />;
    case "Radio": return <Radio className={className} />;
    default: return <Layers className={className} />;
  }
};

const COLORS: Record<string, { border: string; bg: string; text: string; iconBg: string; ring: string; badge: string }> = {
  teal: {
    border: "border-teal-500", bg: "bg-teal-50/80", text: "text-teal-900",
    iconBg: "gradient-teal text-white", ring: "ring-teal-500/20",
    badge: "bg-teal-100 text-teal-700 border-teal-200"
  },
  indigo: {
    border: "border-indigo-500", bg: "bg-indigo-50/80", text: "text-indigo-900",
    iconBg: "bg-indigo-600 text-white", ring: "ring-indigo-500/20",
    badge: "bg-indigo-100 text-indigo-700 border-indigo-200"
  },
  cyan: {
    border: "border-cyan-500", bg: "bg-cyan-50/80", text: "text-cyan-900",
    iconBg: "gradient-teal-cyan text-white", ring: "ring-cyan-500/20",
    badge: "bg-cyan-100 text-cyan-700 border-cyan-200"
  },
  purple: {
    border: "border-purple-500", bg: "bg-purple-50/80", text: "text-purple-900",
    iconBg: "gradient-indigo-purple text-white", ring: "ring-purple-500/20",
    badge: "bg-purple-100 text-purple-700 border-purple-200"
  }
};

export default function PillarGrid() {
  const [selectedPillar, setSelectedPillar] = useState<Pillar | null>(PILLARS[0]);

  return (
    <div className="space-y-6">
      <div>
        <h2 className="text-xl md:text-2xl font-display font-bold text-slate-900 flex items-center gap-2">
          <Layers className="w-5 h-5 text-teal-600" />
          4 Pilar Infrastruktur
        </h2>
        <p className="text-sm text-slate-500 mt-1">
          Sistem digerakkan oleh pilar kolaboratif otonom dalam satu VPS. Pilih pilar untuk melihat cetak biru konfigurasi.
        </p>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
        {PILLARS.map((pillar) => {
          const c = COLORS[pillar.color] || COLORS.teal;
          const isSelected = selectedPillar?.id === pillar.id;

          return (
            <div
              key={pillar.id}
              onClick={() => setSelectedPillar(pillar)}
              className={`relative p-5 rounded-xl border bg-white transition-all duration-200 cursor-pointer card-hover ${
                isSelected
                  ? `${c.border} ${c.bg} ring-2 ${c.ring}`
                  : "border-slate-200 hover:border-slate-300 hover:shadow-md"
              }`}
            >
              <div className="flex justify-between items-start mb-4">
                <div className={`w-10 h-10 rounded-xl ${c.iconBg} flex items-center justify-center shadow-md`}>
                  {renderIcon(pillar.icon, "w-5 h-5")}
                </div>
                <span className={`text-[9px] font-mono tracking-wider uppercase font-bold px-2 py-1 rounded-full border ${c.badge}`}>
                  {pillar.badge}
                </span>
              </div>
              <h3 className="font-display font-bold text-slate-900 text-base mb-1">{pillar.name}</h3>
              <p className="text-[11px] font-medium text-slate-500 mb-2">{pillar.role}</p>
              <p className="text-xs text-slate-600 line-clamp-2 leading-relaxed">{pillar.description}</p>
              {isSelected && (
                <span className="absolute bottom-3 right-3 w-1.5 h-1.5 rounded-full bg-slate-900 animate-ping" />
              )}
            </div>
          );
        })}
      </div>

      <AnimatePresence mode="wait">
        {selectedPillar && (
          <motion.div
            key={selectedPillar.id}
            initial={{ opacity: 0, y: 12 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -12 }}
            transition={{ duration: 0.25 }}
            className="grid grid-cols-1 lg:grid-cols-12 gap-6 bg-slate-50 p-6 md:p-8 rounded-xl border border-slate-200/60"
          >
            <div className="lg:col-span-7 space-y-5">
              <div>
                <span className="text-[10px] font-mono font-bold uppercase px-2 py-0.5 rounded bg-slate-200 text-slate-600">
                  {selectedPillar.role}
                </span>
                <h3 className="text-xl font-display font-extrabold text-slate-900 mt-2">
                  {selectedPillar.name}
                </h3>
                <p className="text-sm text-slate-600 mt-2 leading-relaxed">{selectedPillar.description}</p>
              </div>

              <div className="space-y-2.5">
                <h4 className="text-[10px] font-mono font-bold text-slate-500 uppercase tracking-widest">FUNGSI UTAMA DI SERVER</h4>
                <div className="grid grid-cols-1 gap-2">
                  {selectedPillar.fungsi.map((item, idx) => (
                    <div key={idx} className="flex gap-2.5 bg-white p-3 rounded-lg border border-slate-200/40 text-xs text-slate-700">
                      <span className="w-5 h-5 rounded-full bg-slate-100 flex items-center justify-center shrink-0 mt-0.5 text-[10px] font-mono font-bold text-slate-600">
                        {idx + 1}
                      </span>
                      <span className="leading-normal">{item}</span>
                    </div>
                  ))}
                </div>
              </div>

              <div className="p-4 bg-white rounded-lg border border-slate-200/60 flex items-start gap-3">
                <div className="p-1.5 rounded-lg bg-teal-50 text-teal-600 mt-0.5">
                  <ShieldCheck className="w-4 h-4" />
                </div>
                <div>
                  <h4 className="text-[11px] font-bold text-slate-900 font-display uppercase tracking-wider mb-0.5">Dampak bagi Komunitas</h4>
                  <p className="text-xs text-slate-600 leading-normal">{selectedPillar.manfaat}</p>
                </div>
              </div>
            </div>

            <div className="lg:col-span-5 flex flex-col gap-4">
              <div className="bg-slate-900 rounded-xl overflow-hidden border border-slate-800 flex-1">
                <div className="bg-slate-950 px-4 py-2.5 border-b border-slate-800 flex items-center gap-2 text-slate-400">
                  <Terminal className="w-3.5 h-3.5" />
                  <span className="font-mono text-[10px]">vps-kbrbaik:/etc/{selectedPillar.id}/</span>
                  <div className="ml-auto flex gap-1">
                    <span className="w-2 h-2 rounded-full bg-rose-500/60" />
                    <span className="w-2 h-2 rounded-full bg-amber-500/60" />
                    <span className="w-2 h-2 rounded-full bg-emerald-500/60" />
                  </div>
                </div>
                <div className="p-4 font-mono text-[11px] text-slate-300 space-y-2 leading-relaxed">
                  <span className="text-slate-500"># Memuat cetak biru operasi...</span>
                  {selectedPillar.detailedBlueprint.map((log, idx) => (
                    <div key={idx} className="flex gap-1.5">
                      <span className="text-teal-400 font-bold">&gt;</span>
                      <span>{log}</span>
                    </div>
                  ))}
                  <div className="pt-2 mt-2 border-t border-slate-800 flex justify-between items-center text-slate-500">
                    <span>Status:</span>
                    <span className="text-emerald-400 flex items-center gap-1">
                      <span className="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping" />
                      RUNNING
                    </span>
                  </div>
                </div>
              </div>

              <p className="text-[11px] text-slate-400 leading-relaxed italic bg-slate-100 p-3 rounded-lg border border-slate-200/50">
                💡 Seluruh pilar bekerja modular dalam VPS. Dengan OpenCode, semua API terjalin aman dan bisa diuji instan.
              </p>
            </div>
          </motion.div>
        )}
      </AnimatePresence>
    </div>
  );
}
