<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { Character, Game, User } from '@/types'
import GamesPartial from '@/Pages/GamesPartial.vue'
import CharactersPartial from '@/Pages/CharactersPartial.vue'
import { computed, ComputedRef } from 'vue'

defineProps<{
  user: User
  characters: Character[]
  games: Game[]
}>()

const tabName: ComputedRef<string | null> = computed(() => localStorage.getItem('tab') ?? 'char')

const clickTab = (tabName: string) => {
  localStorage.setItem('tab', tabName)
}
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <div class="py-6 px-6">
      <div class="max-w-7xl mx-auto">
        <div
          role="tablist"
          class="tabs tabs-bordered"
        >
          <input
            type="radio"
            name="tab_panel"
            role="tab"
            class="tab"
            aria-label="Character"
            :checked="tabName === 'char'"
            @click="clickTab('char')"
          >
          <div
            role="tabpanel"
            class="tab-content pt-8"
          >
            <CharactersPartial :characters="characters" />
          </div>

          <input
            type="radio"
            name="tab_panel"
            role="tab"
            class="tab"
            aria-label="GameMaster"
            :checked="tabName === 'gm'"
            @click="clickTab('gm')"
          >
          <div
            role="tabpanel"
            class="tab-content pt-8"
          >
            <GamesPartial
              :user="user"
              :games="games"
              :characters="characters"
            />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
