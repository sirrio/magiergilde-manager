<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Character } from '@/types'

const props = defineProps<{ character: Character }>()

const modalCharacterDestroy = ref()

const showModal = () => {
  modalCharacterDestroy.value.showModal()
}

const clickDestroyCharacter = () => {
  router.delete(route('character.destroy', { character: props.character.id }), { preserveState: false })
}

defineExpose({
  showModal,
})
</script>

<template>
  <dialog
    ref="modalCharacterDestroy"
    class="modal"
  >
    <div class="modal-box">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">
          ✕
        </button>
      </form>
      <h3 class="font-bold text-lg mb-6">
        Destroy character
      </h3>
      <p>Your character <span class="font-bold">"{{ character.name }}"</span> will be deleted. Are you sure?</p>

      <button
        class="btn btn-error mt-6"
        @click="clickDestroyCharacter()"
      >
        Destroy
      </button>
    </div>
  </dialog>
</template>
