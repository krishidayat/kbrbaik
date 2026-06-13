export interface Pillar {
  id: string;
  name: string;
  role: string;
  icon: string; // Used to match lucide component
  description: string;
  fungsi: string[];
  manfaat: string;
  color: string;
  badge: string;
  detailedBlueprint: string[];
}

export interface FlowStep {
  step: number;
  title: string;
  description: string;
  outcome: string;
  icon: string;
}

export interface ChatMessage {
  id: string;
  role: "user" | "assistant";
  content: string;
  timestamp: string;
}

export interface InputTemplate {
  id: string;
  title: string;
  source: string;
  content: string;
}
