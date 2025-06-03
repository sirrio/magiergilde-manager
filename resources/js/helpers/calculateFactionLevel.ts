import { Character } from '@/types'
import { calculateTier } from '@/helpers/calculateTier'
import { calculateLevel } from '@/helpers/calculateLevel'
import { calculateFactionDowntime } from '@/helpers/calculateDowntime'

const calculateFactionLevel = (character: Character): number => {
  const tier = calculateTier(character)
  const level = calculateLevel(character)
  const downtime = calculateFactionDowntime(character)
  const adventures = character.adventures.length

  if (tier === 'bt' || character.faction === 'none') return 0

  if (adventures >= 10 && downtime >= 1800000 && level >= 18) return 5

  if (adventures >= 10 && downtime >= 360000 && level >= 14) return 4

  if (adventures >= 10 && downtime >= 360000 && level >= 9) return 3

  if (adventures >= 10) return 2

  return 1
}

export { calculateFactionLevel }
