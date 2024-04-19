<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Adventure } from '@/types'

const props = defineProps<{ adventure: Adventure }>()

const modalAdventureDestroy = ref()

const showModal = () => {
  modalAdventureDestroy.value.showModal()
}

const clickDestroyAdventure = () => {
  router.delete(route('adventure.destroy', { adventure: props.adventure.id }), { onSuccess: () => modalAdventureDestroy.value.close() })
}

defineExpose({
  showModal,
})
</script>

<template>
  <dialog
    ref="modalAdventureDestroy"
    class="modal"
  >
    <div class="modal-box">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">
          ✕
        </button>
      </form>
      <h3 class="font-bold text-lg mb-6">
        Destroy adventure
      </h3>
      <p>Your adventure <span class="font-bold">"{{ adventure.start_date }}"</span> will be deleted. Are you sure?</p>

      <button
        class="btn btn-error mt-6"
        @click="clickDestroyAdventure()"
      >
        Destroy
      </button>
    </div>
  </dialog>
</template>
