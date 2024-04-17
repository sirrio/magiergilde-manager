const calculateLevel = (bubbles: number, start_tier: string): number => {
  let additional_bubbles: number = 0

  switch (start_tier) {
    case 'bt':
      additional_bubbles = 0
      break
    case 'lt':
      additional_bubbles = 10
      break
    case 'ht':
      additional_bubbles = 55
      break
    default:
      additional_bubbles = 0
  }

  return Math.floor(1 + (Math.sqrt(((8 * (bubbles + additional_bubbles)) + 1)) - 1) / 2)
}

export {calculateLevel}
