<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const form = useForm({
  hours: 3,
  minutes: 0,
  title: '',
  tier: '',
  start_date: new Date().toISOString().slice(0, 10),
  has_additional_bubble: false,
  sessions: 1,
  notes: '',
})

const tiers = [
  { id: 'bt', name: 'Beginner Tier' },
  { id: 'lt', name: 'Low Tier' },
  { id: 'ht', name: 'High Tier' },
  { id: 'et', name: 'Epic Tier' },
]

const modalGameCreate = ref()

const showModal = () => {
  modalGameCreate.value.showModal()
}

const clickCreateNewGame = () => {
  form.transform(data => {
      return {
        duration: (data.hours * 60 * 60) + (data.minutes * 60),
        title: data.title,
        tier: data.tier,
        start_date: data.start_date,
        has_additional_bubble: data.has_additional_bubble,
        sessions: data.sessions,
        notes: data.notes,
      }
    },
  ).post(route('games.store'), {
    preserveState: false,
  })
}

defineExpose({
  showModal,
})
</script>

<template>
  <dialog
    ref="modalGameCreate"
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
        @submit.prevent="clickCreateNewGame()"
      >
        <h3 class="font-bold text-lg mb-6">
          Add new game
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
              class="input"
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
              class="input"
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
            class="input"
          >
        </label>

        <label class="form-control w-full mb-2">
          <div class="label">
            <span class="label-text">What tier was the game played at?</span>
          </div>
          <select
            v-model="form.tier"
            class="select"
          >
            <option
              :value="''"
              disabled
              selected
            >Pick one
            </option>
            <option
              v-for="(tier, key) in tiers"
              :key="key"
              :value="tier.id"
            >
              {{ tier.name }}
            </option>
          </select>
        </label>

        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">What date did you play?</span>
          </div>
          <input
            v-model="form.start_date"
            type="date"
            class="input"
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

        <label class="form-control">
          <div class="label">
            <span class="label-text">How many sessions did you play? <span class="italic text-xs">(Series)</span></span>
          </div>
          <input
            v-model="form.sessions"
            type="number"
            min="0"
            placeholder="1"
            class="input"
          >
        </label>

        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Your notes</span>
          </div>
          <textarea
            v-model="form.notes"
            class="textarea h-24"
            placeholder="Notes"
          />
        </label>

        <button class="btn btn-neutral">
          Create
        </button>
      </form>
    </div>
  </dialog>
</template>
