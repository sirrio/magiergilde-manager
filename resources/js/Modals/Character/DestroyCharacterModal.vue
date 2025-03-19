<script setup lang="ts">
import { Character } from '@/Types'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps<{ character: Character }>()

const modalCharacterDestroy = ref()

const showModal = () => {
  modalCharacterDestroy.value.showModal()
}

const clickDestroyCharacter = () => {
  router.delete(route('characters.destroy', { character: props.character.id }), { preserveState: false })
}

defineExpose({
  showModal,
})
</script>

<template>
  <dialog ref="modalCharacterDestroy" class="modal">
    <div class="modal-box">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute top-2 right-2">✕</button>
      </form>
      <h3 class="mb-6 text-lg font-bold">Destroy character</h3>
      <p>
        Your character <span class="font-bold">"{{ character.name }}"</span> will be deleted. Are you sure?
      </p>

      <button class="btn btn-error mt-6" @click="clickDestroyCharacter()">Destroy</button>
    </div>
  </dialog>
</template>
