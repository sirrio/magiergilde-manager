export interface User {
  id: number;
  name: string;
  email: string;
  email_verified_at: string;
  event_bubbles: number
  event_coins: number
  bt_bubbles: number
  bt_coins: number
  lt_bubbles: number
  lt_coins: number
  ht_bubbles: number
  ht_coins: number
  et_bubbles: number
  et_coins: number
  other_bubbles: number
  other_coins: number
  is_admin: boolean
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
  auth: {
    user: User;
  };
};

export interface Item {
  id: number;
  name: string;
  url: string;
  cost: string;
  type: string;
  rarity: string;
}

export interface Spell {
  id: number;
  name: string;
  url: string;
  legacy_url: string;
  spell_school: string;
  spell_level: number;
}

export interface CharacterClass {
  id: number;
  name: string;
  src: string;
}

export interface Character {
  character_classes: CharacterClass[];
  adventures: Adventure[];
  downtimes: Downtime[];
  allies: Ally[];
  deleted_at: string;
  faction: string;
  notes: string;
  id: number;
  name: string;
  class: Array<CharacterClass>;
  start_tier: string;
  version: string;
  dm_bubbles: number;
  dm_coins: number;
  is_filler: boolean;
  bubble_shop_spend: number;
  external_link: string;
  avatar: string;
  user_id: number;
}

export interface Ally {
  id: number;
  name: string;
  standing: string;
  character_id: number;
}

export interface Adventure {
  id: number;
  title: string;
  duration: number;
  start_date: string;
  has_additional_bubble: boolean;
  notes: string;
  game_master: string;
  character_id: number;
}

export interface Downtime {
  id: number;
  duration: number;
  start_date: string;
  type: string;
  notes: string;
  character_id: number;
}

export interface Game {
  id: number;
  title: string;
  tier: string;
  duration: number;
  start_date: string;
  has_additional_bubble: boolean;
  sessions: number;
  notes: string;
  user_id: number;
}
