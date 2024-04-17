<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import {Character} from "@/types";
import CreateCharacterModal from "@/Modals/CreateCharacterModal.vue";
import {ref} from "vue";
import {calculateBubble} from "@/helpers/calculateBubble";
import {calculateLevel} from "@/helpers/calculateLevel";
import {calculateLevelBorder} from "@/helpers/calculateLevelBorder";
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
    <div class="py-12">
      <div class="max-w-7xl mx-auto">
        <div class="prose mb-12">
          <h2>Your characters</h2>
          <p>You can manager your characters here</p>
        </div>

        <div class="card bg-neutral text-neutral-content" v-if="characters.length === 0">
          <div class="card-body text-center">
            <font-awesome-icon :icon="['fas', 'circle-exclamation']" size="7x"/>
            <h3 class="font-semibold text-xl">No character yet</h3>
          </div>
        </div>

        <div v-else class="grid grid-cols-4 gap-2">
          <div class="card bg-neutral text-neutral-content" v-for="(character, key) of characters"
               :key="key">
            {{ (bubbles = calculateBubble(character.adventures), null) }}
            {{ (level = calculateLevel(bubbles), null) }}

            <div class="card-body">
              <h3 class="card-title capitalize">{{ character.name }}</h3>
              <div class="flex justify-between">
                <p class="text-xs">Level {{ level }}
                  {{ character.character_classes[0].name }}</p>
                <div>
                  <img :src="character.character_classes[0].src" height="16" width="16" alt=""/>
                </div>
              </div>
              <div class="avatar">
                <div class="aspect-square rounded-full w-full">
                  <img :src="'storage/' + character.avatar" alt=""
                       @error="$event.target.src = '/images/placeholder.jpg'">
                </div>
              </div>
              <div>
                <progress class="progress w-full"
                          :value="bubbles - calculateLevelBorder(level - 1)"
                          :max="calculateLevelBorder(level) - calculateLevelBorder(level - 1)">
                </progress>
                <div class="text-xs text-right -mt-1.5">Bubbles to next level {{ bubbles - calculateLevelBorder(level - 1) }} /
                  {{ calculateLevelBorder(level) - calculateLevelBorder(level - 1) }}
                </div>
              </div>
              <div class="mt-3 flex justify-end">
                <p class="grow-0 tooltip tooltip-accent" data-tip="Adventures played">
                  <font-awesome-icon :icon="['fas', 'person-hiking']"/>
                  {{ character.adventures.length }}
                </p>
              </div>
              <div class="mt-3 flex justify-between gap-3">
                <button class="btn btn-sm" @click="clickShowCharacter(character.id)">
                  <font-awesome-icon :icon="['fas', 'id-card']"/>
                  Details
                </button>
                <button class="btn btn-sm" @click="clickCreateAdventureModal(character.id)">
                  <font-awesome-icon :icon="['fas', 'person-hiking']"/>
                  Add adventure
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-12">
          <button @click="createCharacterModal.showModal()" class="btn btn-neutral">Create new character
          </button>
        </div>
      </div>
    </div>
    <create-character-modal ref="createCharacterModal"></create-character-modal>
    <create-adventure-modal :character-id="currentCharacterId" ref="createAdventureModal"></create-adventure-modal>
  </AuthenticatedLayout>
</template>
