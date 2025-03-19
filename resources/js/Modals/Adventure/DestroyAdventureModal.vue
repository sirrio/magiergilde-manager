<script setup lang="ts">
import { Adventure } from '@/Types'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps<{ adventure: Adventure }>()

const modalAdventureDestroy = ref()

const showModal = () => {
  modalAdventureDestroy.value.showModal()
}

const clickDestroyAdventure = () => {
  router.delete(route('adventure.destroy', { adventure: props.adventure.id }), { preserveState: false })
}

defineExpose({
  showModal,
})
</script>

<template>
  <dialog ref="modalAdventureDestroy" class="modal">
    <div class="modal-box">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute top-2 right-2">✕</button>
      </form>
      <h3 class="mb-6 text-lg font-bold">Destroy adventure</h3>
      <p>
        Your adventure <span class="font-bold">"{{ adventure.start_date }}"</span> will be deleted. Are you sure?
      </p>

      <button class="btn btn-error mt-6" @click="clickDestroyAdventure()">Destroy</button>
    </div>
  </dialog>
</template>
