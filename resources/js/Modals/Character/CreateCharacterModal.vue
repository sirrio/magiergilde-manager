<script setup lang="ts">
import CharacterForm from '@/Modals/Character/CharacterForm.vue'
import ModalContainer from '@/Modals/Character/ModalContainer.vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const form = useForm({
  name: '',
  class: [],
  faction: 'none',
  dm_bubbles: 0,
  dm_coins: 0,
  notes: '',
  version: '',
  bubble_shop_spend: 0,
  external_link: '',
  start_tier: '',
  is_filler: false,
  avatar: null,
})

const modalRef = ref()
defineExpose({ showModal: () => modalRef.value.showModal() })

const clickCreateNewCharacter = () => {
  form.post(route('characters.store'), {
    preserveState: false,
  })
}
</script>

<template>
  <ModalContainer ref="modalRef">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute top-2 right-2">✕</button>
    </form>

    <CharacterForm can-edit-filler can-edit-starting-tier heading="Create new character" :form="form"></CharacterForm>

    <button class="btn btn-neutral mt-6" @click="clickCreateNewCharacter()">Create</button>
  </ModalContainer>
</template>
