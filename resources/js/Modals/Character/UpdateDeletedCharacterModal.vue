<script setup lang="ts">
import { Character } from '@/Types'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps<{ character: Character }>()

const modalCharacterUpdate = ref()

const showModal = () => {
  modalCharacterUpdate.value.showModal()
}

const clickUpdateCharacter = () => {
  router.patch(route('deletedCharacter.restore', { character: props.character.id }), {}, { preserveState: false })
}

defineExpose({
  showModal,
})
</script>

<template>
  <dialog ref="modalCharacterUpdate" class="modal">
    <div class="modal-box">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute top-2 right-2">✕</button>
      </form>
      <h3 class="mb-6 text-lg font-bold">Update character</h3>
      <p>
        Your character <span class="font-bold">"{{ character.name }}"</span> will be restored. Are you sure?
      </p>

      <button class="btn mt-6" @click="clickUpdateCharacter()">Restore</button>
    </div>
  </dialog>
</template>
