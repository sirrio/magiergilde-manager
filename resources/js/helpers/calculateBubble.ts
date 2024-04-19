import { Adventure, Character } from '@/types'

enum Bubble {
  MIN_DURATION = 10800
}

const calculateBubble = (character: Character): number => {

  return calculateBubbleByAdventure(character.adventures) + character.dm_bubbles
}

const calculateBubbleByAdventure = (adventures: Adventure[]): number => {

  return adventures.reduce(
    (bubble: number, adventure: Adventure): number => {
      return bubble + Math.floor(adventure.duration / Bubble.MIN_DURATION) + (adventure.has_additional_bubble ? 1 : 0)
    },
    0,
  )
}

export { calculateBubble, calculateBubbleByAdventure }
