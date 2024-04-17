const calculateLevel = (bubbles: number): number => {
    return Math.floor(1 + (Math.sqrt(((8 * bubbles) + 1)) - 1) / 2)
}

export {calculateLevel}
