<script setup lang="ts">
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";

const props = defineProps<{ characterId: number }>()

const form = useForm({
  hours: 3,
  minutes: 0,
  start_date: new Date().toISOString().slice(0, 10),
  has_additional_bubble: false,
  notes: ''
})

const modalAdventureCreate = ref()

const showModal = () => {
  modalAdventureCreate.value.showModal()
}

const clickCreateNewAdventure = () => {
  form.transform(data => {
      return {
        duration: (data.hours * 60 * 60) + (data.minutes * 60),
        start_date: data.start_date,
        has_additional_bubble: data.has_additional_bubble,
        notes: data.notes,
        character_id: props.characterId,
      }
    }
  ).put(route('adventure.store'), {onSuccess: params => modalAdventureCreate.value.close()})
}

defineExpose({
  showModal
})
</script>

<template>
  <dialog ref="modalAdventureCreate" class="modal">
    <div class="modal-box">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
      </form>
      <form @submit.prevent="clickCreateNewAdventure()" class="flex flex-col gap-3">
        <h3 class="font-bold text-lg">Add new adventure</h3>

        <div class="flex gap-3"><label class="form-control w-1/2">
          <div class="label">
            <span class="label-text">How many hours did you play?</span>
          </div>
          <input type="number" min="0" max="24" v-model="form.hours" placeholder="Peter"
                 class="input input-bordered w-full"/>
        </label>

          <label class="form-control w-1/2">
            <div class="label">
              <span class="label-text">How many minutes did you play?</span>
            </div>
            <input type="number" :min="0" max="59" v-model="form.minutes" placeholder="Peter"
                   class="input input-bordered w-full"/>
          </label>
        </div>

        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">What date did you play?</span>
          </div>
          <input type="date" v-model="form.start_date"
                 class="input input-bordered w-full"/>
        </label>

        <div class="form-control w-full">
          <label class="label cursor-pointer">
            <span class="label-text">Has an additional bubble?</span>
            <input type="checkbox" v-model="form.has_additional_bubble" class="checkbox"/>
          </label>
        </div>

        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Your notes</span>
          </div>
          <textarea class="textarea textarea-bordered h-24" v-model="form.notes" placeholder="Notes"></textarea>
        </label>

        <button class="btn btn-neutral">Create</button>
      </form>
    </div>
  </dialog>
</template>
