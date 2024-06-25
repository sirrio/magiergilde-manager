<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps<{ characterId: number }>()

const form = useForm({
  hours: 0,
  minutes: 0,
  start_date: new Date().toISOString().slice(0, 10),
  type: 'other',
  notes: '',
})

const modalDowntimeCreate = ref()

const showModal = () => {
  modalDowntimeCreate.value.showModal()
}

const clickCreateNewDowntime = () => {
  form.transform(data => {
      return {
        duration: (data.hours * 60 * 60) + (data.minutes * 60),
        start_date: data.start_date,
        type: data.type,
        notes: data.notes,
        character_id: props.characterId,
      }
    },
  ).put(route('downtime.store'), {
    preserveState: false,
  })
}

defineExpose({
  showModal,
})
</script>

<template>
  <dialog
    ref="modalDowntimeCreate"
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
        @submit.prevent="clickCreateNewDowntime()"
      >
        <h3 class="font-bold text-lg">
          Add new downtime
        </h3>

        <div class="flex gap-3">
          <label class="form-control w-1/2">
            <div class="label">
              <span class="label-text">How many hours?</span>
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
              <span class="label-text">How many minutes?</span>
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
            <span class="label-text">What date did you spend your downtime?</span>
          </div>
          <input
            v-model="form.start_date"
            type="date"
            class="input input-bordered w-full"
          >
        </label>

        <label class="form-control w-full mb-2">
          <div class="label">
            <span class="label-text">Is this downtime spend on a faction or other activities?</span>
          </div>
          <select
            v-model="form.type"
            class="select select-bordered w-full capitalize"
          >
            <option value="other">Other</option>
            <option value="faction">Faction</option>
          </select>
        </label>

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
          Create
        </button>
      </form>
    </div>
  </dialog>
</template>
