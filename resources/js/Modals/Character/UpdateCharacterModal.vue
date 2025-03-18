<script setup lang="ts">
import { InertiaForm, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Character } from '../../Types'

const props = defineProps<{
  character: Character
}>()

const form: InertiaForm<{
  name: string
  class: Array<number>
  faction: string
  version: string
  dm_bubbles: number
  dm_coins: number
  notes: string
  bubble_shop_spend: number
  external_link: string
  is_filler: boolean
  avatar: File | null
}> = useForm({
  name: props.character.name,
  class: props.character.character_classes.map(cc => cc.id),
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

const modalCharacterCreate = ref()

const factions = [
  'none',
  'heiler',
  'handwerker',
  'feldforscher',
  'bibliothekare',
  'diplomaten',
  'gardisten',
  'unterhalter',
  'logistiker',
  'flora & fauna',
]

const versions = [
  { id: '2024', name: '2024 Rules' },
  { id: '2014', name: '2014 Rules' },
]

const showModal = () => {
  modalCharacterCreate.value.showModal()
}

const clickUpdateCharacter = () => {
  form.post(route('character.update', { character: props.character.id }), {
    preserveState: false,
  })
}

defineExpose({
  showModal,
})

function inputFile(event: Event) {
  const target = event.target as HTMLInputElement
  if (target?.files)
    form.avatar = target?.files[0]
}
</script>

<template>
  <dialog
    ref="modalCharacterCreate"
    class="modal"
  >
    <div class="modal-box">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">
          ✕
        </button>
      </form>
      <h3 class="font-bold text-lg mb-6">
        Update your character
      </h3>

      <label class="form-control w-full mb-2">
        <div class="label">
          <span class="label-text">What is your characters name?</span>
        </div>
        <input
          v-model="form.name"
          type="text"
          placeholder="Peter"
          class="input"
        >
      </label>

      <div class="form-control w-full mb-2">
        <span class="px-1 py-2 text-sm">What is your characters class?</span>
        <div class="grid grid-cols-4">
          <label
            v-for="(characterClass, key) in $page.props.classes"
            :key="key"
            class="form-control flex-row gap-1"
          >
            <input
              :checked="form.class.some(cc => cc === characterClass.id)"
              type="checkbox"
              class="checkbox checkbox-xs"
              @change="form.class.includes(characterClass.id) ? form.class.splice(form.class.indexOf(characterClass.id), 1) : form.class.push(characterClass.id)"
            >
            <span class="label-text text-sm">{{ characterClass.name }}</span>
          </label>
        </div>
      </div>

      <label class="form-control w-full mb-2">
        <div class="label">
          <span class="label-text">Does your character belong to a faction?</span>
        </div>
        <select
          v-model="form.faction"
          :disabled="form.is_filler"
          class="select capitalize"
        >
          <option
            v-for="(faction, key) in factions"
            :key="key"
            :value="faction"
          >
            {{ faction }}
          </option>
        </select>
      </label>

      <label class="form-control w-full mb-2">
        <div class="label">
          <span class="label-text">What version is you character?</span>
        </div>
        <select
          v-model="form.version"
          class="select"
        >
          <option
            :value="''"
            disabled
            selected
          >Pick one
          </option>
          <option
            v-for="(version, key) in versions"
            :key="key"
            :value="version.id"
          >
            {{ version.name }}
          </option>
        </select>
      </label>

      <div class="flex gap-2">
        <label class="form-control w-full mb-2">
          <div class="label">
            <span class="label-text">How many DM bubbles you assign this character?</span>
          </div>
          <input
            v-model="form.dm_bubbles"
            :disabled="form.is_filler"
            type="number"
            min="0"
            placeholder="0"
            class="input"
          >
        </label>

        <label class="form-control w-full mb-2">
          <div class="label">
            <span class="label-text">How many DM coins did you assign this character?</span>
          </div>
          <input
            v-model="form.dm_coins"
            :disabled="form.is_filler"
            type="number"
            min="0"
            placeholder="0"
            class="input"
          >
        </label>
      </div>

      <label class="form-control w-full mb-2">
        <div class="label">
          <span class="label-text">How many bubbles did you spend on the Bubble Shop?</span>
        </div>
        <input
          v-model="form.bubble_shop_spend"
          :disabled="form.is_filler"
          type="number"
          min="0"
          placeholder="0"
          class="input"
        >
      </label>

      <label class="form-control w-full mb-2">
        <div class="label">
          <span class="label-text">What is your DnDBeyond Link?</span>
        </div>
        <input
          v-model="form.external_link"
          type="text"
          placeholder="https://..."
          class="input"
        >
      </label>

      <label class="form-control w-full mb-2">
        <div class="label">
          <span class="label-text">Choose an avatar</span>
        </div>
        <input
          type="file"
          class="file-input"
          accept=".jpeg,.png,.jpg,.gif,.webp"
          @input="inputFile($event)"
        >
      </label>

      <label class="form-control w-full">
        <div class="label">
          <span class="label-text">Your backstories and notes</span>
        </div>
        <textarea
          v-model="form.notes"
          class="textarea h-24"
          placeholder="Notes"
        />
      </label>

      <button
        class="btn btn-neutral mt-6"
        @click="clickUpdateCharacter()"
      >
        Update
      </button>
    </div>
  </dialog>
</template>
