import { Character } from '../Types'

const calculateBubbleSpend = (characters: Character[]): number => {

  return characters.reduce(
    (bubble: number, character: Character): number => {
      return bubble + character.dm_bubbles
    },
    0,
  )
}


export { calculateBubbleSpend }
