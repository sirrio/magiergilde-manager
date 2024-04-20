import { Character } from '@/types'
import { calculateLevel } from '@/helpers/calculateLevel'

const calculateTier = (character: Character): string => {
  switch (calculateLevel(character)) {
    case 1:
    case 2:
    case 3:
    case 4:
      return 'bt'
    case 5:
    case 6:
    case 7:
    case 9:
    case 10:
      return 'lt'
    case 11:
    case 12:
    case 13:
    case 14:
    case 15:
    case 16:
      return 'ht'
    case 17:
    case 18:
    case 19:
    case 20:
      return 'et'
    default:
      return 'error'
  }
}

export { calculateTier }
