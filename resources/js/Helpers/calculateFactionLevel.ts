import { Character } from '../Types'
import { calculateTier } from '@/Helpers/calculateTier'
import { calculateLevel } from '@/Helpers/calculateLevel'
import { calculateFactionDowntime } from '@/Helpers/calculateDowntime'

const calculateFactionLevel = (character: Character): number => {
  const tier = calculateTier(character)
  const level = calculateLevel(character)
  const downtime = calculateFactionDowntime(character)
  const adventures = character.adventures.length

  if (tier === 'bt' || character.faction === 'none') return 0

  if (level >= 18 && downtime >= 1800000) return 5

  if (adventures >= 10 && downtime >= 360000 && level >= 14) return 4

  if (adventures >= 10 && downtime >= 360000) return 3

  if (adventures >= 10) return 2

  return 1
}

export { calculateFactionLevel }
