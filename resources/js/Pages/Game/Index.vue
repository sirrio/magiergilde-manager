<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import GamesPartial from '@/Pages/Game/GamesPartial.vue'
import { Character, Game, User } from '@/Types'
import { Head } from '@inertiajs/vue3'

defineProps<{
  user: User
  characters: Character[]
  games: Game[]
}>()
</script>

<template>
  <Head title="Games" />

  <AuthenticatedLayout>
    <div class="px-6 py-6">
      <div class="mx-auto max-w-7xl">
        <GamesPartial :user="user" :games="games" :characters="characters" />
      </div>
    </div>
  </AuthenticatedLayout>
</template>
