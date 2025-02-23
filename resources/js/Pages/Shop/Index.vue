<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { Item } from '@/types'
import { computed } from 'vue'
import UniqueItemsTable from '@/Pages/Shop/UniqueItemsTable.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps<{
  items: Item[]
}>()

function pickUniqueItems(
  items: Item[],
  count: number = 2,
  rarity: string = 'common',
  type: string = 'item',
): Item[] {
  const filteredItems = items.filter(
    (item) => item.rarity === rarity && item.type === type,
  )

  const shuffledItems = shuffleArray(filteredItems)
  return shuffledItems.slice(0, count)
}

function shuffleArray<T>(array: T[]): T[] {
  const result = [...array]
  for (let i = result.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [result[i], result[j]] = [result[j], result[i]]
  }
  return result
}

const commonItems = computed(() => pickUniqueItems(props.items, 5, 'common', 'item'))
const commonConsumables = computed(() => pickUniqueItems(props.items, 1, 'common', 'consumable'))
const commonSpellscrolls = computed(() => pickUniqueItems(props.items, 1, 'common', 'spellscroll'))
const uncommonItems = computed(() => pickUniqueItems(props.items, 3, 'uncommon', 'item'))
const uncommonConsumables = computed(() => pickUniqueItems(props.items, 1, 'uncommon', 'consumable'))
const uncommonSpellscrolls = computed(() => pickUniqueItems(props.items, 1, 'uncommon', 'spellscroll'))
const rareItems = computed(() => pickUniqueItems(props.items, 2, 'rare', 'item'))
const rareConsumables = computed(() => pickUniqueItems(props.items, 1, 'rare', 'consumable'))
const rareSpellscrolls = computed(() => pickUniqueItems(props.items, 1, 'rare', 'spellscroll'))
const veryRareItems = computed(() => pickUniqueItems(props.items, 1, 'very_rare', 'item'))
const veryRareConsumables = computed(() => pickUniqueItems(props.items, 1, 'very_rare', 'consumable'))
const veryRareSpellscrolls = computed(() => pickUniqueItems(props.items, 1, 'very_rare', 'spellscroll'))
</script>

<template>
  <Head title="Shop" />

  <AuthenticatedLayout>
    <div class="py-6 px-6">
      <div class="max-w-7xl mx-auto flex flex-col gap-3">
        <UniqueItemsTable
          title="⚔️ Common Magic Items (Ab Low Tier):"
          :items="commonItems"
        />
        <UniqueItemsTable
          title="Common Consumable"
          :items="commonConsumables"
        />
        <UniqueItemsTable
          title="Common Spell Scroll"
          :items="commonSpellscrolls"
        />
        <UniqueItemsTable
          title="⚔️ Uncommon Magic Items (Ab Low Tier):"
          :items="uncommonItems"
        />
        <UniqueItemsTable
          title="Uncommon Consumable"
          :items="uncommonConsumables"
        />
        <UniqueItemsTable
          title="Uncommon Spell Scroll"
          :items="uncommonSpellscrolls"
        />
        <UniqueItemsTable
          title="⚔️ Rare Magic Items (Ab High Tier):"
          :items="rareItems"
        />
        <UniqueItemsTable
          title="Rare Consumable/Spell Scroll"
          :items="[...rareConsumables, ...rareSpellscrolls]"
        />
        <UniqueItemsTable
          title="⚔️ Very Rare Magic Item (Ab Epic Tier):"
          :items="veryRareItems"
        />
        <UniqueItemsTable
          title="Very Rare Consumable/Spell Scroll"
          :items="[...veryRareConsumables, ...veryRareSpellscrolls]"
        />
      </div>
    </div>
  </AuthenticatedLayout>
</template>
