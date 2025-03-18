<script setup lang="ts">
import { InertiaForm, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Character } from '@/Types';

const props = defineProps<{
  character: Character
}>();

const page = usePage();

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
  avatar: null
});

const modalCharacterCreate = ref();

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
  'flora & fauna'
];

const versions = [
  { id: '2024', name: '2024 Rules' },
  { id: '2014', name: '2014 Rules' }
];

const showModal = () => {
  modalCharacterCreate.value.showModal();
};

const clickUpdateCharacter = () => {
  form.post(route('characters.update', {
    character: props.character.id,
    _method: 'put'
  }), {
    preserveState: false
  });
};

defineExpose({
  showModal
});

function inputFile(event: Event) {
  const target = event.target as HTMLInputElement;
  if (target?.files)
    form.avatar = target.files[0] ?? null;
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

      <form>
        <fieldset class="fieldset ">
          <legend class="fieldset-legend">Update your character</legend>

          <label class="fieldset-label">Name</label>
          <input
            v-model="form.name"
            type="text"
            placeholder="Peter"
            class="input w-full"
          >

          <label class="fieldset-label">Class(es)</label>
          <div class="grid grid-cols-4 gap-1 rounded-box p-2 border border-base-content/20">
            <template v-for="(characterClass, key) in page.props.classes" :key="key">
              <fieldset class="fieldset flex">
                <input
                  :id="`$cc-${characterClass.id}`"
                  :checked="form.class.some(cc => cc === characterClass.id)"
                  type="checkbox"
                  class="checkbox checkbox-sm"
                  @change="form.class.includes(characterClass.id) ? form.class.splice(form.class.indexOf(characterClass.id), 1) : form.class.push(characterClass.id)"
                >
                <label :for="`$cc-${characterClass.id}`" class="fieldset-label truncate">
                  {{ characterClass.name }}
                </label>
              </fieldset>
            </template>
          </div>

          <label class="fieldset-label">Faction</label>
          <select
            v-model="form.faction"
            :disabled="form.is_filler"
            class="select capitalize w-full"
          >
            <option
              v-for="(faction, key) in factions"
              :key="key"
              :value="faction"
            >
              {{ faction }}
            </option>
          </select>

          <label class="fieldset-label">Rules version</label>
          <select
            v-model="form.version"
            class="select w-full"
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

          <div class="grid grid-cols-2 gap-2">
            <fieldset class="fieldset">
              <label class="fieldset-label">Spend Game Master bubbles</label>
              <input
                v-model="form.dm_bubbles"
                :disabled="form.is_filler"
                type="number"
                min="0"
                placeholder="0"
                class="input w-full"
              >
            </fieldset>

            <fieldset class="fieldset">
              <label class="fieldset-label">Spend Game Master coins</label>
              <input
                v-model="form.dm_coins"
                :disabled="form.is_filler"
                type="number"
                min="0"
                placeholder="0"
                class="input w-full"
              >
            </fieldset>
          </div>

          <label class="fieldset-label">Bubbles spend at bubble shop</label>
          <input
            v-model="form.bubble_shop_spend"
            :disabled="form.is_filler"
            type="number"
            min="0"
            placeholder="0"
            class="input w-full"
          >

          <label class="fieldset-label">DnDBeyond link</label>
          <input
            v-model="form.external_link"
            type="text"
            placeholder="https://..."
            class="input w-full"
          >

          <label class="fieldset-label">Avatar</label>
          <input
            type="file"
            class="file-input w-full"
            accept=".jpeg,.png,.jpg,.gif,.webp"
            @input="inputFile($event)"
          >

          <label class="fieldset-label">Backstories and notes</label>
          <textarea
            v-model="form.notes"
            class="textarea h-24 w-full"
            placeholder="Notes"
          />

          <button
            class="btn btn-neutral mt-2"
            @click.prevent="clickUpdateCharacter()"
          >
            Update
          </button>
        </fieldset>
      </form>
    </div>
  </dialog>
</template>
