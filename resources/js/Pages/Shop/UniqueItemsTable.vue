<script setup lang="ts">
import { Item } from '@/Types'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { defineProps, ref } from 'vue'

defineProps<{
  title: string
  items: Item[]
  big?: boolean
}>()

const copied = ref(false)

const copyToClipboard = (text: string) => {
  navigator.clipboard.writeText(text).then(() => {
    copied.value = true
    setTimeout(() => {
      copied.value = false
    }, 1000)
  })
}
</script>

<template>
  <div v-if="copied" class="toast text-base-content z-50 text-base">
    <div class="alert alert-info">
      <font-awesome-icon :icon="['fas', 'copy']" />
      <span>Copied to clipboard.</span>
    </div>
  </div>
  <div class="bg-base-100 rounded-sm border p-2">
    <h2 class="hover:text-accent col-span-8 cursor-pointer" @click="copyToClipboard(big ? `## ***${title}***` : `### ${title}`)">
      <font-awesome-icon icon="copy" class="mr-1 opacity-25" />
      {{ title }}
    </h2>
    <div v-for="(item, index) in items" :key="index" class="grid grid-cols-12 text-xs">
      <div class="col-span-2 truncate font-semibold">
        <a v-if="item.url" :href="item.url" target="_blank" class="link link-primary">
          {{ item.name }}
        </a>
        <template v-else>
          {{ item.name }}
        </template>
      </div>
      <div class="truncate">
        {{ item.cost }}
      </div>
      <div class="truncate capitalize">{{ item.rarity.replace('_', ' ') }} {{ item.type }}</div>
      <div class="hover:text-accent col-span-8 cursor-pointer" @click="copyToClipboard(`[${item.name}](<${item.url}>): ${item.cost}`)">
        <font-awesome-icon icon="copy" class="mr-1 opacity-25" />
        {{ `[${item.name}](<${item.url}>): ${item.cost}` }}
      </div>
    </div>
  </div>
</template>
