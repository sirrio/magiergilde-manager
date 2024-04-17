<script setup lang="ts">
import {useForm} from "@inertiajs/vue3"
import {ref} from "vue"

const form = useForm({
  name: '',
  class: 0,
  external_link: '',
  start_tier: 'bt',
  avatar: ''
})

const modalCharacterCreate = ref()

const showModal = () => {
  modalCharacterCreate.value.showModal()
}

const clickCreateNewCharacter = () => {
  form.post(route('character.store'))
}

defineExpose({
  showModal
})
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
        Create new character
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
          @input="form.avatar = $event?.target?.files[0]"
        >
      </label>

      {{ form }}

      <button
        class="btn btn-neutral mt-6"
        @click="clickCreateNewCharacter()"
      >
        Create
      </button>
    </div>
  </dialog>
</template>
