<script setup lang="ts">
import { Downtime } from '@/Types'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps<{ downtime: Downtime }>()

const modalDowntimeDestroy = ref()

const showModal = () => {
  modalDowntimeDestroy.value.showModal()
}

const clickDestroyDowntime = () => {
  router.delete(route('downtime.destroy', { downtime: props.downtime.id }), { preserveState: false })
}

defineExpose({
  showModal,
})
</script>

<template>
  <dialog ref="modalDowntimeDestroy" class="modal">
    <div class="modal-box">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute top-2 right-2">✕</button>
      </form>
      <h3 class="mb-6 text-lg font-bold">Destroy downtime</h3>
      <p>
        Your downtime <span class="font-bold">"{{ downtime.start_date }}"</span> will be deleted. Are you sure?
      </p>

      <button class="btn btn-error mt-6" @click="clickDestroyDowntime()">Destroy</button>
    </div>
  </dialog>
</template>
