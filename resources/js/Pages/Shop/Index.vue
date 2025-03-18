<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { Item } from '../../Types'
import { ref } from 'vue'
import UniqueItemsTable from '@/Pages/Shop/UniqueItemsTable.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineProps<{
  items: Item[]
}>()

const splitmix32 = (a: number): number => {
  a |= 0
  a = a + 0x9e3779b9 | 0
  let t = a ^ a >>> 16
  t = Math.imul(t, 0x21f0aaad)
  t = t ^ t >>> 15
  t = Math.imul(t, 0x735a2d97)
  return ((t ^ t >>> 15) >>> 0) / 4294967296
}

const seed = ref(new Date().toJSON().slice(0, 10))

function seededRng(seed: string) {
  const hashes = cyrb128(seed)
  return splitmix32(hashes[0])
}

function shuffleArray<T>(array: T[], seed: string): T[] {
  const result = [...array]
  let tmpSeed = cyrb128(seed)[0]
  for (let i = result.length - 1; i > 0; i--) {
    const j = Math.floor(seededRng(tmpSeed.toString()) * (i + 1));
    [result[i], result[j]] = [result[j], result[i]]
    tmpSeed = cyrb128(tmpSeed.toString())[0]
  }
  return result
}

function cyrb128(str: string): [number, number, number, number] {
  let h1 = 1779033703, h2 = 3144134277,
    h3 = 1013904242, h4 = 2773480762
  for (let i = 0, k; i < str.length; i++) {
    k = str.charCodeAt(i)
    h1 = h2 ^ Math.imul(h1 ^ k, 597399067)
    h2 = h3 ^ Math.imul(h2 ^ k, 2869860233)
    h3 = h4 ^ Math.imul(h3 ^ k, 951274213)
    h4 = h1 ^ Math.imul(h4 ^ k, 2716044179)
  }
  h1 = Math.imul(h3 ^ (h1 >>> 18), 597399067)
  h2 = Math.imul(h4 ^ (h2 >>> 22), 2869860233)
  h3 = Math.imul(h1 ^ (h3 >>> 17), 951274213)
  h4 = Math.imul(h2 ^ (h4 >>> 19), 2716044179)
  h1 ^= (h2 ^ h3 ^ h4), h2 ^= h1, h3 ^= h1, h4 ^= h1
  return [h1 >>> 0, h2 >>> 0, h3 >>> 0, h4 >>> 0]
}
</script>

<template>
  <Head title="Shop" />

  <AuthenticatedLayout>
    <div class="py-6 px-6">
      <div class="max-w-7xl mx-auto flex flex-col gap-3">
        <label class="label">
          <span class="mr-3 uppercase font-bold tracking-wide label-text">Seed:</span>
          <input
            v-model="seed"
            class="input input-xs"
            type="text"
          >
        </label>
        <UniqueItemsTable
          title="⚔️ Common Magic Items (Ab Low Tier):"
          big
          :items="shuffleArray(items.filter(i => i.rarity === 'common' && i.type === 'item'), seed).splice(0, 5)"
        />
        <UniqueItemsTable
          title="Common Consumable"
          :items="shuffleArray(items.filter(i => i.rarity === 'common' && i.type === 'consumable'), seed).splice(0, 1)"
        />
        <UniqueItemsTable
          title="Common Spell Scroll"
          :items="shuffleArray(items.filter(i => i.rarity === 'common' && i.type === 'spellscroll'), seed).splice(0, 1)"
        />
        <UniqueItemsTable
          title="⚔️ Uncommon Magic Items (Ab Low Tier):"
          big
          :items="shuffleArray(items.filter(i => i.rarity === 'uncommon' && i.type === 'item'), seed).splice(0, 3)"
        />
        <UniqueItemsTable
          title="Uncommon Consumable"
          :items="shuffleArray(items.filter(i => i.rarity === 'uncommon' && i.type === 'consumable'), seed).splice(0, 1)"
        />
        <UniqueItemsTable
          title="Uncommon Spell Scroll"
          :items="shuffleArray(items.filter(i => i.rarity === 'uncommon' && i.type === 'spellscroll'), seed).splice(0, 1)"
        />
        <UniqueItemsTable
          title="⚔️ Rare Magic Items (Ab High Tier):"
          big
          :items="shuffleArray(items.filter(i => i.rarity === 'rare' && i.type === 'item'), seed).splice(0, 2)"
        />
        <UniqueItemsTable
          title="Rare Consumable/Spell Scroll"
          :items="shuffleArray(items.filter(i => i.rarity === 'rare' && (i.type === 'consumable' || i.type == 'spellscroll')), seed).splice(0, 1)"
        />
        <UniqueItemsTable
          title="⚔️ Very Rare Magic Item (Ab Epic Tier):"
          big
          :items="shuffleArray(items.filter(i => i.rarity === 'very_rare' && i.type === 'item'), seed).splice(0, 1)"
        />
        <UniqueItemsTable
          title="Very Rare Consumable/Spell Scroll"
          :items="shuffleArray(items.filter(i => i.rarity === 'very_rare' && (i.type === 'consumable' || i.type == 'spellscroll')), seed).splice(0, 1)"
        />
      </div>
    </div>
  </AuthenticatedLayout>
</template>
