<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import {Character} from "@/types";
import CreateCharacterModal from "@/Modals/CreateCharacterModal.vue";
import {ref} from "vue";
import {calculateBubble} from "@/helpers/calculateBubble";
import {calculateLevel} from "@/helpers/calculateLevel";
import {calculateLevelBubbles} from "@/helpers/calculateLevelBubbles";
import CreateAdventureModal from "@/Modals/CreateAdventureModal.vue";

const props = defineProps<{
  characters: Character
}>()

const createCharacterModal = ref()
const createAdventureModal = ref()
const currentCharacterId = ref(0)

const clickShowCharacter = (id: Number) => {
  router.visit(route('character.show', {character: id}))
}

const clickCreateAdventureModal = (id) => {
  currentCharacterId.value = id
  createAdventureModal.value.showModal()
}
</script>

<template>
  <Head title="Dashboard"/>

  <AuthenticatedLayout>
    <div class="py-12 px-6">
      <div class="max-w-7xl mx-auto">
        <div class="flex justify-between">
          <div class="prose mb-12">
            <h2>Your characters</h2>
            <p>You can manager your characters here</p>
          </div>
          <div>
            <button @click="createCharacterModal.showModal()" class="btn btn-neutral">
              <font-awesome-icon :icon="['fas', 'plus']"/>
              Create new character
            </button>
          </div>
        </div>


        <div class="card bg-neutral text-neutral-content" v-if="characters.length === 0">
          <div class="card-body text-center">
            <font-awesome-icon :icon="['fas', 'circle-exclamation']" size="7x"/>
            <h3 class="font-semibold text-xl">No character yet</h3>
          </div>
        </div>

        <div v-else class="grid sm:grid-cols-2 md:grid-cols-4 gap-2">
          <div class="card max-w-sm bg-neutral text-neutral-content" v-for="(character, key) of characters"
               :key="key">
            {{ (bubbles = calculateBubble(character.adventures), null) }}
            {{ (level = calculateLevel(bubbles, character.start_tier), null) }}

            <div class="card-body group">
              <div class="group-hover:absolute group-hover:block hidden top-2 right-2">
                <button class="btn btn-sm btn-ghost btn-square" @click="clickShowCharacter(character.id)">
                  <font-awesome-icon :icon="['fas', 'gear']"/>
                </button>
              </div>
              <h3 class="card-title capitalize">{{ character.name }}</h3>
              <div class="flex justify-between">
                <p class="text-xs">Level {{ level }}
                  {{ character.character_classes[0].name }}</p>
                <!--                <div>-->
                <!--                  <img :src="character.character_classes[0].src" height="16" width="16" alt=""/>-->
                <!--                </div>-->
              </div>
              <div class="avatar">
                <div class="aspect-square rounded-full w-full">
                  <img :src="'storage/' + character.avatar" alt=""
                       @error="$event.target.src = '/images/placeholder.jpg'">
                </div>
              </div>
              <div>
                <progress class="progress w-full"
                          :value="bubbles - calculateLevelBubbles(level - 1, character.start_tier)"
                          :max="calculateLevelBubbles(level, character.start_tier) - calculateLevelBubbles(level - 1, character.start_tier)">
                </progress>
                <div class="text-xs text-right -mt-1.5">Bubbles to next level
                  {{ bubbles - calculateLevelBubbles(level - 1, character.start_tier) }} /
                  {{ calculateLevelBubbles(level, character.start_tier) - calculateLevelBubbles(level - 1, character.start_tier) }}
                </div>
              </div>
              <div class="mt-3 flex justify-end gap-3">
                <p class="grow-0 uppercase tooltip tooltip-accent" data-tip="Started his adventure here">
                  <font-awesome-icon :icon="['fas', 'flag-checkered']" />
                  {{ character.start_tier }}
                </p>
                <p class="grow-0 uppercase tooltip tooltip-accent" data-tip="Adventures played">
                  <font-awesome-icon :icon="['fas', 'person-hiking']"/>
                  {{ character.adventures.length }}
                </p>
                <p class="grow-0">
                  <a class="underline" :href="character.external_link" target="_blank">
                    Beyond
                    <font-awesome-icon :icon="['fas', 'arrow-up-right-from-square']" size="xs"/>
                  </a>
                </p>
              </div>
              <div class="mt-3 flex gap-1">
                <button class="btn btn-sm" @click="clickShowCharacter(character.id)">
                  <font-awesome-icon :icon="['fas', 'person-hiking']"/>
                  View adventures
                </button>
                <button class="btn btn-sm" @click="clickCreateAdventureModal(character.id)">
                  <font-awesome-icon :icon="['fas', 'plus']"/>
                </button>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <create-character-modal ref="createCharacterModal"></create-character-modal>
    <create-adventure-modal :character-id="currentCharacterId" ref="createAdventureModal"></create-adventure-modal>
  </AuthenticatedLayout>
</template>
