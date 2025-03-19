<script setup lang="ts">
import { calculateClassString } from '@/Helper/calculateClassString'
import { calculateLevel } from '@/Helper/calculateLevel'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import AdventuresPartial from '@/Pages/Character/AdventuresPartial.vue'
import DowntimePartial from '@/Pages/Character/DowntimePartial.vue'
import { Character } from '@/Types'
import { Head } from '@inertiajs/vue3'

defineProps<{
  character: Character
}>()

function onImgError(event: Event) {
  const target = event.target as HTMLImageElement
  target.src = '/images/placeholder.jpg'
}
</script>

<template>
  <Head title="Details" />

  <AuthenticatedLayout>
    <div class="px-6 py-12">
      <div class="mx-auto max-w-7xl">
        <div class="flex flex-col items-center">
          <div class="prose mb-12 text-center">
            <h2>{{ character.name }}</h2>
            <div class="avatar my-0">
              <div class="aspect-square h-24 rounded-full">
                <img class="my-0" :src="'/storage/' + character.avatar" alt="" @error="onImgError($event)" />
              </div>
            </div>
            <p v-if="!character.is_filler" class="text-xs">
              Level {{ calculateLevel(character) }}
              {{ calculateClassString(character) }}
            </p>
            <p v-else class="text-xs">
              Level 3
              {{ calculateClassString(character) }}
            </p>
          </div>
        </div>

        <div class="mt-3 grid gap-12 sm:grid-cols-2">
          <AdventuresPartial :character="character" />
          <DowntimePartial :character="character" />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
