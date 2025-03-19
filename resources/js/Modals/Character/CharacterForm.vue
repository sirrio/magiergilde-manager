<script setup lang="ts">
import { InertiaForm, usePage } from '@inertiajs/vue3'
import { defineProps, ref } from 'vue'

const props = defineProps<{
  form: InertiaForm<any>
  heading: string
  canEditFiller?: boolean
  canEditStartingTier?: boolean
}>()

const page = usePage()

const localForm = ref(props.form)

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

function inputFile(event: Event) {
  const target = event.target as HTMLInputElement
  if (target?.files) localForm.value.avatar = target.files[0] ?? null
}

function toggleClass(classId: number) {
  const index = props.form.class.indexOf(classId)
  if (index !== -1) {
    localForm.value.class.splice(index, 1)
  } else {
    localForm.value.class.push(classId)
  }
}

const tiers = [
  { id: 'bt', name: 'Beginner Tier' },
  { id: 'lt', name: 'Low Tier' },
  { id: 'ht', name: 'High Tier' },
]

const changeFiller = () => {
  if (localForm.value.is_filler) {
    localForm.value.is_filler = false
  } else {
    localForm.value.is_filler = true
    localForm.value.dm_bubbles = 0
    localForm.value.dm_coins = 0
    localForm.value.bubble_shop_spend = 0
    localForm.value.start_tier = 'bt'
    localForm.value.faction = 'none'
  }
}
</script>

<template>
  <fieldset class="fieldset">
    <legend class="fieldset-legend">{{ heading }}</legend>

    <label class="fieldset-label">Name</label>
    <input v-model="localForm.name" type="text" placeholder="Peter" class="input w-full" />

    <label class="fieldset-label">Class(es)</label>
    <div class="rounded-box border-base-content/20 grid grid-cols-4 gap-1 border p-2">
      <template v-for="(characterClass, key) in page.props.classes" :key="key">
        <fieldset class="fieldset flex">
          <input
            :id="`$cc-${characterClass.id}`"
            :checked="localForm.class.some((cc) => cc === characterClass.id)"
            type="checkbox"
            class="checkbox checkbox-sm"
            @change="toggleClass(characterClass.id)"
          />
          <label :for="`$cc-${characterClass.id}`" class="fieldset-label truncate">
            {{ characterClass.name }}
          </label>
        </fieldset>
      </template>
    </div>

    <template v-if="canEditFiller">
      <div class="my-2 flex justify-between">
        <label class="fieldset-label">Filler character<span class="italic">(cannot be changed later)</span></label>
        <input :checked="form.is_filler" type="checkbox" class="toggle" @change="changeFiller()" />
      </div>
    </template>

    <template v-if="canEditStartingTier">
      <label class="fieldset-label">Starting tier<span class="italic">(cannot be changed later)</span></label>
      <select v-model="localForm.start_tier" :disabled="localForm.is_filler" class="select w-full">
        <option :value="''" disabled selected>Pick one</option>
        <option v-for="(tier, key) in tiers" :key="key" :value="tier.id">
          {{ tier.name }}
        </option>
      </select>
    </template>

    <label class="fieldset-label">Faction</label>
    <select v-model="localForm.faction" :disabled="localForm.is_filler" class="select w-full capitalize">
      <option v-for="(faction, key) in factions" :key="key" :value="faction">
        {{ faction }}
      </option>
    </select>

    <label class="fieldset-label">Rules version</label>
    <select v-model="localForm.version" class="select w-full">
      <option :value="''" disabled selected>Pick one</option>
      <option v-for="(version, key) in versions" :key="key" :value="version.id">
        {{ version.name }}
      </option>
    </select>

    <div class="grid grid-cols-2 gap-2">
      <fieldset class="fieldset">
        <label class="fieldset-label">Spend Game Master bubbles</label>
        <input v-model="localForm.dm_bubbles" :disabled="localForm.is_filler" type="number" min="0" placeholder="0" class="input w-full" />
      </fieldset>

      <fieldset class="fieldset">
        <label class="fieldset-label">Spend Game Master coins</label>
        <input v-model="localForm.dm_coins" :disabled="localForm.is_filler" type="number" min="0" placeholder="0" class="input w-full" />
      </fieldset>
    </div>

    <label class="fieldset-label">Bubbles spend at bubble shop</label>
    <input v-model="localForm.bubble_shop_spend" :disabled="localForm.is_filler" type="number" min="0" placeholder="0" class="input w-full" />

    <label class="fieldset-label">DnDBeyond link</label>
    <input v-model="localForm.external_link" type="text" placeholder="https://..." class="input w-full" />

    <label class="fieldset-label">Avatar</label>
    <input type="file" class="file-input w-full" accept=".jpeg,.png,.jpg,.gif,.webp" @input="inputFile($event)" />

    <label class="fieldset-label">Backstories and notes</label>
    <textarea v-model="localForm.notes" class="textarea h-24 w-full" placeholder="Notes" />
  </fieldset>
</template>
