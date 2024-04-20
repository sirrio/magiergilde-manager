<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import AdventuresPartial from '@/Pages/Character/AdventuresPartial.vue'
import DowntimePartial from '@/Pages/Character/DowntimePartial.vue'
import { Character } from '@/types'
import { calculateLevel } from '@/helpers/calculateLevel'
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
    <div class="py-12 px-6">
      <div class="max-w-7xl mx-auto">
        <div class="flex flex-col items-center">
          <div class="prose mb-12 text-center">
            <h2>{{ character.name }}</h2>
            <div class="avatar my-0">
              <div class="aspect-square rounded-full h-24">
                <img
                  class="my-0"
                  :src="'/storage/' + character.avatar"
                  alt=""
                  @error="onImgError($event)"
                >
              </div>
            </div>
            <p class="text-xs">
              Level {{ calculateLevel(character) }}
              {{ character.character_classes[0].name }}
            </p>
          </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-12 mt-3">
          <AdventuresPartial :character="character" />
          <DowntimePartial :character="character" />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
