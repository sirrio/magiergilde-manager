import {Adventure} from "@/types"

enum Bubble {
    MIN_DURATION = 10800
}

const calculateBubble = (adventures: Adventure[]): number => {

    let bubbles: number = 0
    return adventures.reduce(
        (bubble: number, adventure: Adventure): number => {
            return bubble + Math.floor(adventure.duration / Bubble.MIN_DURATION)
        },
        bubbles
    )
}

export {calculateBubble}
