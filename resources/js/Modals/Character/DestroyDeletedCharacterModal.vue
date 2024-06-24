<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Character } from '@/types'

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
      <p>
        Your character <span class="font-bold">"{{ character.name }}"</span> will be permanently deleted and cannot be
        restored.
      </p>
      <p class="italic text-error my-3">
        Character and Filler with DM Bubbles/ Coins should not be deleted because of calculation.
      </p>

      <label class="form-control w-full mb-2">
        <div class="label">
          <span class="label-text">If you still which to delete the character, type "DELETE" below.</span>
        </div>
        <input
          v-model="deleteConfirm"
          type="text"
          placeholder="DELETE"
          class="input input-bordered w-full"
        >
      </label>

      <button
        :disabled="deleteConfirm != 'DELETE'"
        class="btn btn-error mt-6"
        @click="clickDestroyCharacter()"
      >
        Destroy
      </button>
    </div>
  </dialog>
</template>
