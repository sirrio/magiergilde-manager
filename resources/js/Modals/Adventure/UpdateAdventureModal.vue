<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Adventure } from '@/types'

const props = defineProps<{ adventure: Adventure }>()

const form = useForm({
  hours: Math.floor(props.adventure.duration / 3600),
  minutes: (props.adventure.duration / 60) % 60,
  title: props.adventure.title,
  game_master: props.adventure.game_master,
  start_date: props.adventure.start_date,
  has_additional_bubble: props.adventure.has_additional_bubble,
  notes: props.adventure.notes,
})

const modalAdventureUpdate = ref()

const showModal = () => {
  modalAdventureUpdate.value.showModal()
}

const clickUpdateNewAdventure = () => {
  form.transform(data => {
      return {
        duration: (data.hours * 60 * 60) + (data.minutes * 60),
        start_date: data.start_date,
        title: data.title,
        game_master: data.game_master,
        has_additional_bubble: data.has_additional_bubble,
        notes: data.notes,
      }
    },
  ).patch(route('adventure.update', { adventure: props.adventure.id }), {
    preserveState: false,
  })
}

defineExpose({
  showModal,
})
</script>

<template>
  <dialog
    ref="modalAdventureUpdate"
    class="modal"
  >
    <div class="modal-box">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">
          ✕
        </button>
      </form>
      <form
        class="flex flex-col gap-3"
        @submit.prevent="clickUpdateNewAdventure()"
      >
        <h3 class="font-bold text-lg">
          Update your adventure
        </h3>

        <div class="flex gap-3">
          <label class="form-control w-1/2">
            <div class="label">
              <span class="label-text">How many hours did you play?</span>
            </div>
            <input
              v-model="form.hours"
              type="number"
              min="0"
              placeholder="0"
              class="input input-bordered w-full"
            >
          </label>

          <label class="form-control w-1/2">
            <div class="label">
              <span class="label-text">How many minutes did you play?</span>
            </div>
            <input
              v-model="form.minutes"
              type="number"
              min="0"
              max="59"
              placeholder="0"
              class="input input-bordered w-full"
            >
          </label>
        </div>

        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Do you want to give your game a title?</span>
          </div>
          <input
            v-model="form.title"
            placeholder="Peters greatest adventure"
            type="text"
            class="input input-bordered w-full"
          >
        </label>

        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Who game mastered your game?</span>
          </div>
          <input
            v-model="form.game_master"
            type="text"
            placeholder="Patt Percer"
            class="input input-bordered w-full"
          >
        </label>

        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">What date did you play?</span>
          </div>
          <input
            v-model="form.start_date"
            type="date"
            class="input input-bordered w-full"
          >
        </label>

        <div class="form-control w-full">
          <label class="label cursor-pointer">
            <span class="label-text">Has an additional bubble? <span class="italic text-xs">(Character Quest)</span></span>
            <input
              v-model="form.has_additional_bubble"
              type="checkbox"
              class="checkbox"
            >
          </label>
        </div>

        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Your notes</span>
          </div>
          <textarea
            v-model="form.notes"
            class="textarea textarea-bordered h-24"
            placeholder="Notes"
          />
        </label>

        <button class="btn btn-neutral">
          Update
        </button>
      </form>
    </div>
  </dialog>
</template>
