<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Character } from '@/types'

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
  <dialog
    ref="modalCharacterUpdate"
    class="modal"
  >
    <div class="modal-box">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">
          ✕
        </button>
      </form>
      <h3 class="font-bold text-lg mb-6">
        Update character
      </h3>
      <p>Your character <span class="font-bold">"{{ character.name }}"</span> will be restored. Are you sure?</p>

      <button
        class="btn mt-6"
        @click="clickUpdateCharacter()"
      >
        Restore
      </button>
    </div>
  </dialog>
</template>
