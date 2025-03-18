<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { Character, Game, User } from '../../Types'
import GamesPartial from '@/Pages/Game/GamesPartial.vue'

defineProps<{
  user: User
  characters: Character[]
  games: Game[]
}>()
</script>

<template>
  <Head title="Games" />

  <AuthenticatedLayout>
    <div class="py-6 px-6">
      <div class="max-w-7xl mx-auto">
        <GamesPartial
          :user="user"
          :games="games"
          :characters="characters"
        />
      </div>
    </div>
  </AuthenticatedLayout>
</template>
