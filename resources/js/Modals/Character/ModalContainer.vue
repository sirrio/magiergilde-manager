<script setup lang="ts">
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { ref } from 'vue'

const modalRef = ref()

const closeModal = () => {
  modalRef.value.close()
}

defineExpose({ showModal: () => modalRef.value.showModal() })
</script>

<template>
  <dialog ref="modalRef" class="modal">
    <div class="modal-box">
      <button type="button" class="btn btn-sm btn-circle btn-ghost absolute top-2 right-2" @click="closeModal">
        <font-awesome-icon icon="x"></font-awesome-icon>
      </button>
      <slot></slot>
    </div>
  </dialog>
</template>
