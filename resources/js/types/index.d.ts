export interface User {
  id: number;
  name: string;
  email: string;
  email_verified_at: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
  auth: {
    user: User;
  };
};

export interface CharacterClass {
  id: number;
  name: string;
  src: string;
}

export interface Character {
  character_classes: CharacterClass[];
  adventures: Adventure[];
  downtimes: Downtime[];
  id: number;
  name: string;
  class: Array<CharacterClass>;
  start_tier: string;
  dm_bubbles: number;
  dm_coins: number;
  bubble_shop_spend: number;
  external_link: string;
  avatar: string;
  user_id: number;
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
  notes: string;
  character_id: number;
}
