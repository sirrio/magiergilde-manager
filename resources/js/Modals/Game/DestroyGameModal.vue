<script setup lang="ts">
import { Game } from '@/Types'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps<{ game: Game }>()

const modalGameDestroy = ref()

const showModal = () => {
  modalGameDestroy.value.showModal()
}

const clickDestroyGame = () => {
  router.delete(route('game.destroy', { game: props.game.id }), { preserveState: false })
}

defineExpose({
  showModal,
})
</script>

<template>
  <dialog ref="modalGameDestroy" class="modal">
    <div class="modal-box">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute top-2 right-2">✕</button>
      </form>
      <h3 class="mb-6 text-lg font-bold">Destroy game</h3>
      <p>
        Your game <span class="font-bold">"{{ game.start_date }}"</span> will be deleted. Are you sure?
      </p>

      <button class="btn btn-error mt-6" @click="clickDestroyGame()">Destroy</button>
    </div>
  </dialog>
</template>
