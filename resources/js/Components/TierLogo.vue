<script setup lang="ts">
defineProps<{
  tier: string
  size: number
}>()
</script>

<template>
  <img
    v-if="tier === 'bt'"
    class="inline"
    src="/images/MG_BT.png"
    :height="size"
    :width="size"
    alt="BT"
  >
  <img
    v-if="tier === 'lt'"
    class="inline"
    src="/images/MG_LT.png"
    :height="size"
    :width="size"
    alt="BT"
  >
  <img
    v-if="tier === 'ht'"
    class="inline"
    src="/images/MG_HT.png"
    :height="size"
    :width="size"
    alt="BT"
  >
  <img
    v-if="tier === 'et'"
    class="inline"
    src="/images/MG_ET.png"
    :height="size"
    :width="size"
    alt="BT"
  >
</template>
