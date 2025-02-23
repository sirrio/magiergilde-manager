<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { Character, Game, User } from '@/types'
import CharactersPartial from '@/Pages/Character/CharactersPartial.vue'

defineProps<{
  user: User
  characters: Character[]
  games: Game[]
}>()
</script>

<template>
  <Head title="Characters" />

  <AuthenticatedLayout>
    <div class="py-6 px-6">
      <div class="max-w-7xl mx-auto">
        <CharactersPartial :characters="characters" />
      </div>
    </div>
  </AuthenticatedLayout>
</template>
