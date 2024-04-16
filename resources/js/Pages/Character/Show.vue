<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Character} from "@/types";
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import {calculateBubble} from "@/helpers/calculateBubble";
import {calculateLevel} from "@/helpers/calculateLevel";

const props = defineProps<{
    character: Character
}>()

console.log(props.adventures)

const form = useForm({
    hours: 0,
    minutes: 0
})

const modalAddAdventure = ref()

const clickOpenModalAddAdventure = () => {
    modalAddAdventure.value.showModal()
}

const clickAddAdventure = () => {
    form.transform(data => {
            return {
                duration: (data.hours * 60 * 60) + (data.minutes * 60),
                character_id: props.character.id
            }
        }
    ).put(route('adventure.store'))
}

const bubbles = calculateBubble(props.character.adventures)
console.log(bubbles)
const level = calculateLevel(bubbles)
console.log(level)
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-7xl p-9 mx-auto">
            <div class="card bg-base-100">
                <div class="card-body">
                    <h2 class="card-title">
                        {{ character.name }}
                    </h2>
                    {{ character.class }}
                </div>
            </div>

            <div v-for="a in 100">
                bubbles{{a}} - level{{ calculateLevel(a)}}
            </div>

            <div class="card bg-base-100">
                <div class="card-body">
                    <h2 class="card-title">
                        Adventures
                    </h2>
                    <div v-for="(adventure, key) of character.adventures" :key="key">
                        {{ Math.floor(adventure.duration / 3600) }}h {{ (adventure.duration / 60) % 60 }}min
                    </div>
                </div>
            </div>

            <button class="btn" @click="clickOpenModalAddAdventure()">open modal</button>
        </div>

        <dialog ref="modalAddAdventure" class="modal">
            <div class="modal-box">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <h3 class="font-bold text-lg">Hello!</h3>

                <label class="input input-bordered flex items-center gap-2">
                    Hours
                    <input v-model="form.hours" type="number" class="grow" placeholder="Daisy"/>
                </label>

                <label class="input input-bordered flex items-center gap-2">
                    Minutes
                    <input v-model="form.minutes" type="number" class="grow" placeholder="Daisy"/>
                </label>

                <button @click="clickAddAdventure()" class="btn">Add</button>
            </div>
        </dialog>
    </AuthenticatedLayout>
</template>
