<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import CharactersPartial from '@/Pages/Character/CharactersPartial.vue'
import { Character, Game, User } from '@/Types'
import { Head } from '@inertiajs/vue3'

defineProps<{
  user: User
  characters: Character[]
  games: Game[]
}>()
</script>

<template>
  <Head title="Characters" />

  <AuthenticatedLayout>
    <div class="px-6 py-6">
      <div class="mx-auto max-w-7xl">
        <CharactersPartial :characters="characters" />
      </div>
    </div>
  </AuthenticatedLayout>
</template>
