<script setup lang="ts">
import { defineProps } from 'vue'
import { Item } from '@/types'

defineProps<{
  title: string
  items: Item[]
}>()
</script>

<template>
  <div
    class="border rounded p-2 bg-base-100"
  >
    <h2>
      {{ title }}
    </h2>
    <div
      v-for="(item, index) in items"
      :key="index"
      class="grid grid-cols-12 text-xs"
    >
      <div class="truncate font-semibold col-span-2">
        <a
          v-if="item.url"
          :href="item.url"
          target="_blank"
          class="link link-primary"
        >
          {{ item.name }}
        </a>
        <template v-else>
          {{ item.name }}
        </template>
      </div>
      <div class="truncate">
        {{ item.cost }}
      </div>
      <div class="capitalize truncate">
        {{ item.rarity }} {{ item.type }}
      </div>
      <div class="col-span-8">
        {{ `[${item.name}](${item.url})` }}
      </div>
    </div>
  </div>
</template>
