import { calculateBubble } from '@/Helper/calculateBubble'
import { Character, Downtime } from '@/Types'

const calculateRemainingDowntime = (character: Character): number => {
  const bubbles = calculateBubble(character)

  const usedDuration = character.downtimes.reduce((duration: number, downtime: Downtime): number => {
    return duration + downtime.duration
  }, 0)

  const totalDuration = bubbles * 8 * 60 * 60
  return totalDuration - usedDuration
}

export { calculateRemainingDowntime }
