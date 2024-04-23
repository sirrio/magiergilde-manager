import { Game } from '@/types'

const calculateCoins = (game: Game[]): number => {

  return game.reduce(
    (coin: number, game: Game): number => {
      return coin + 1 + (game.has_additional_bubble ? -1 : 0)
    },
    0,
  )
}


export { calculateCoins }
