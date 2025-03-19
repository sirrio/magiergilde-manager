<script setup lang="ts">
import { Character } from '@/Types'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps<{ character: Character }>()

const modalCharacterDestroy = ref()

const showModal = () => {
  modalCharacterDestroy.value.showModal()
}

const deleteConfirm = ref('')

const clickDestroyCharacter = () => {
  router.delete(route('deletedCharacter.destroy', { character: props.character.id }), { preserveState: false })
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
        Your character <span class="font-bold">"{{ character.name }}"</span> will be permanently deleted and cannot be restored.
      </p>
      <p class="text-error my-3 italic">Character and Filler with DM Bubbles/ Coins should not be deleted because of calculation.</p>

      <label class="form-control mb-2 w-full">
        <div class="label">
          <span class="label-text">If you still which to delete the character, type "DELETE" below.</span>
        </div>
        <input v-model="deleteConfirm" type="text" placeholder="DELETE" class="input" />
      </label>

      <button :disabled="deleteConfirm != 'DELETE'" class="btn btn-error mt-6" @click="clickDestroyCharacter()">Destroy</button>
    </div>
  </dialog>
</template>
