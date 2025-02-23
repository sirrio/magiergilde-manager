<script setup lang="ts">
import { defineProps, ref } from 'vue'
import { Item } from '@/types'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

defineProps<{
  title: string
  items: Item[]
}>()

const copied = ref(false)

const copyToClipboard = (text) => {
  navigator.clipboard.writeText(text).then(() => {
    copied.value = true
    setTimeout(() => {
      copied.value = false
    }, 1000)
  })
}
</script>

<template>
  <div
    v-if="copied"
    class="toast z-50 text-base-content text-base"
  >
    <div class="alert alert-info">
      <font-awesome-icon :icon="['fas', 'copy']" />
      <span>Copied to clipboard.</span>
    </div>
  </div>
  <div
    class="border rounded p-2 bg-base-100"
  >
    <h2
      class="col-span-8 hover:text-accent cursor-pointer"
      @click="copyToClipboard(`${title}`)"
    >
      <font-awesome-icon
        icon="copy"
        class="opacity-25 mr-1"
      />
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
        {{ item.rarity.replace('_',' ') }} {{ item.type }}
      </div>
      <div
        class="col-span-8 hover:text-accent cursor-pointer"
        @click="copyToClipboard(`[${item.name}](${item.url}): ${item.cost}`)"
      >
        <font-awesome-icon
          icon="copy"
          class="opacity-25 mr-1"
        />
        {{ `[${item.name}](${item.url}): ${item.cost}` }}
      </div>
    </div>
  </div>
</template>
