<script setup lang="ts">
import CharacterForm from '@/Modals/Character/CharacterForm.vue'
import ModalContainer from '@/Modals/Character/ModalContainer.vue'
import { Character } from '@/Types'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps<{ character: Character }>()

const form = useForm({
  name: props.character.name,
  class: props.character.character_classes.map((cc) => cc.id),
  faction: props.character.faction,
  version: props.character.version,
  dm_bubbles: props.character.dm_bubbles,
  dm_coins: props.character.dm_coins,
  notes: props.character.notes,
  bubble_shop_spend: props.character.bubble_shop_spend,
  external_link: props.character.external_link,
  is_filler: props.character.is_filler,
  avatar: null,
})

const modalRef = ref()
defineExpose({ showModal: () => modalRef.value.showModal() })

const clickUpdateCharacter = () => {
  form.post(route('characters.update', { character: props.character.id, _method: 'put' }), { preserveState: false })
}
</script>

<template>
  <ModalContainer ref="modalRef">
    <form @submit.prevent="clickUpdateCharacter">
      <CharacterForm heading="Update character" :form="form" />

      <button type="submit" class="btn btn-neutral mt-2">Update</button>
    </form>
  </ModalContainer>
</template>
