<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Game } from '@/types'

const props = defineProps<{ game: Game }>()

const form = useForm({
  hours: Math.floor(props.game.duration / 3600),
  minutes: (props.game.duration / 60) % 60,
  title: props.game.title,
  start_date: props.game.start_date,
  has_additional_bubble: props.game.has_additional_bubble,
  notes: props.game.notes,
})

console.log(props)

const modalGameUpdate = ref()

const showModal = () => {
  modalGameUpdate.value.showModal()
}

const clickUpdateNewGame = () => {
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
  ).patch(route('game.update', { game: props.game.id }), {
    onSuccess: () => {
      modalGameUpdate.value.close()
      form.reset()
    },
  })
}

defineExpose({
  showModal,
})
</script>

<template>
  <dialog
    ref="modalGameUpdate"
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
        @submit.prevent="clickUpdateNewGame()"
      >
        <h3 class="font-bold text-lg">
          Update your game
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
            placeholder="Peters greatest game"
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
            <span class="label-text">Has an additional bubble?</span>
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
