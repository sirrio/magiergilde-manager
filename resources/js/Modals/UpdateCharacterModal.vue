<script setup lang="ts">
import { InertiaForm, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Character } from '@/types'

const props = defineProps<{
  character: Character
}>()

const form: InertiaForm<{
  name: string
  class: number
  dm_bubbles: number
  dm_coins: number
  bubble_shop_spend: number
  external_link: string
  avatar: File | null
}> = useForm({
  name: props.character.name,
  class: props.character.character_classes[0].id,
  dm_bubbles: props.character.dm_bubbles,
  dm_coins: props.character.dm_coins,
  bubble_shop_spend: props.character.bubble_shop_spend,
  external_link: props.character.external_link,
  avatar: null,
})

const modalCharacterCreate = ref()

const showModal = () => {
  modalCharacterCreate.value.showModal()
}

const clickUpdateCharacter = () => {
  form.post(route('character.update', { character: props.character.id }), {
    onSuccess: () => {
      modalCharacterCreate.value.close()
      form.reset()
    },
  })
}

defineExpose({
  showModal,
})

function inputFile(event: Event) {
  const target = event.target as HTMLInputElement
  if (target?.files)
    form.avatar = target?.files[0]
}
</script>

<template>
  <dialog
    ref="modalCharacterCreate"
    class="modal"
  >
    <div class="modal-box">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">
          ✕
        </button>
      </form>
      <h3 class="font-bold text-lg mb-6">
        Update your character
      </h3>

      <label class="form-control w-full mb-2">
        <div class="label">
          <span class="label-text">What is your name?</span>
        </div>
        <input
          v-model="form.name"
          type="text"
          placeholder="Peter"
          class="input input-bordered w-full"
        >
      </label>

      <label class="form-control w-full mb-2">
        <div class="label">
          <span class="label-text">What is your class?</span>
        </div>
        <select
          v-model="form.class"
          class="select select-bordered w-full"
        >
          <option
            value="0"
            disabled
            selected
          >Pick one
          </option>
          <option
            v-for="(characterClass, key) in $page.props.classes"
            :key="key"
            :value="characterClass.id"
          >
            {{ characterClass.name }}
          </option>
        </select>
      </label>

      <div class="flex gap-2">
        <label class="form-control w-full mb-2">
          <div class="label">
            <span class="label-text">How many DM bubbles you assign this character?</span>
          </div>
          <input
            v-model="form.dm_bubbles"
            type="number"
            placeholder="0"
            class="input input-bordered w-full"
          >
        </label>

        <label class="form-control w-full mb-2">
          <div class="label">
            <span class="label-text">How many DM coins did you assign this character?</span>
          </div>
          <input
            v-model="form.dm_coins"
            type="number"
            placeholder="0"
            class="input input-bordered w-full"
          >
        </label>
      </div>

      <label class="form-control w-full mb-2">
        <div class="label">
          <span class="label-text">How many bubbles did you spend on the Bubble Shop?</span>
        </div>
        <input
          v-model="form.bubble_shop_spend"
          type="number"
          placeholder="0"
          class="input input-bordered w-full"
        >
      </label>

      <label class="form-control w-full mb-2">
        <div class="label">
          <span class="label-text">What is your DnDBeyond Link?</span>
        </div>
        <input
          v-model="form.external_link"
          type="text"
          placeholder="https://..."
          class="input input-bordered w-full"
        >
      </label>

      <label class="form-control w-full mb-2">
        <div class="label">
          <span class="label-text">Pick a file</span>
        </div>
        <input
          type="file"
          class="file-input file-input-bordered w-full"
          accept=".jpeg,.png,.jpg,.gif,.webp"
          @input="inputFile($event)"
        >
      </label>

      <button
        class="btn btn-neutral mt-6"
        @click="clickUpdateCharacter()"
      >
        Update
      </button>
    </div>
  </dialog>
</template>
