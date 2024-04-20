<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Downtime } from '@/types'

const props = defineProps<{ downtime: Downtime }>()

const form = useForm({
  hours: Math.floor(props.downtime.duration / 3600),
  minutes: (props.downtime.duration / 60) % 60,
  start_date: props.downtime.start_date,
  notes: props.downtime.notes,
})

const modalDowntimeUpdate = ref()

const showModal = () => {
  modalDowntimeUpdate.value.showModal()
}

const clickUpdateNewDowntime = () => {
  form.transform(data => {
      return {
        duration: (data.hours * 60 * 60) + (data.minutes * 60),
        start_date: data.start_date,
        notes: data.notes,
      }
    },
  ).patch(route('downtime.update', { downtime: props.downtime.id }), {
    onSuccess: () => {
      modalDowntimeUpdate.value.close()
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
    ref="modalDowntimeUpdate"
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
        @submit.prevent="clickUpdateNewDowntime()"
      >
        <h3 class="font-bold text-lg">
          Update your downtime
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
