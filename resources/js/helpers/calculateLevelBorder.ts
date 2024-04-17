const calculateLevelBorder = (level: number): number => {
    return level * (level + 1) / 2
}

export {calculateLevelBorder}
