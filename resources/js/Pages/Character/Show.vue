<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Character} from "@/types";
import {ref} from "vue";
import {calculateBubble} from "@/helpers/calculateBubble";
import {calculateLevel} from "@/helpers/calculateLevel";
import CreateAdventureModal from "@/Modals/CreateAdventureModal.vue";

const props = defineProps<{
  character: Character
}>()

const createAdventureModal = ref()
</script>

<template>
  <AuthenticatedLayout>
    <div class="py-12 px-6">
      <div class="max-w-7xl mx-auto">

        <div class="flex flex-col items-center">
          <div class="prose mb-12 text-center">
            <h2>{{ character.name }}</h2>
            <div class="avatar my-0">
              <div class="aspect-square rounded-full h-24">
                <img class="my-0" :src="'/storage/' + character.avatar" alt=""
                     @error="$event.target.src = '/images/placeholder.jpg'">
              </div>
            </div>
            <p class="text-xs">Level {{ calculateLevel(calculateBubble(character.adventures), character.start_tier) }}
              {{ character.character_classes[0].name }}</p>
          </div>

        </div>

        <div class="flex justify-between">
          <h2 class="card-title">
            Adventures
          </h2>
          <button @click="createAdventureModal.showModal()" class="btn btn-neutral">
            <font-awesome-icon :icon="['fas', 'plus']"/>
            Add adventure
          </button>
        </div>
        <div class="grid grid-cols-2 gap-3 mt-3">
          <div class="card card-compact bg-neutral text-neutral-content"
               v-for="(adventure, key) of character.adventures" :key="key">
            <div class="card-body">
              <div class="card-title">
                <h3>Adventure {{ key + 1 }}</h3>
              </div>
              <div class="flex justify-between text-xs">
                <p>
                  You gained {{ calculateBubble([adventure]) }}
                  <span v-if="adventure.has_additional_bubble">+ {{ adventure.has_additional_bubble }}</span>
                  bubbles
                </p>
                <p class="italic text-right">
                  {{ new Date(adventure.start_date).toLocaleDateString() }}
                  {{ Math.floor(adventure.duration / 3600) }}h {{ (adventure.duration / 60) % 60 }}min
                </p>
              </div>
              <p v-if="adventure.notes" class="whitespace-pre-wrap">
                {{ adventure.notes }}
              </p>
              <p v-else>There are no notes for this adventure</p>
            </div>
          </div>
        </div>
      </div>

    </div>

    <create-adventure-modal :character-id="character.id" ref="createAdventureModal"></create-adventure-modal>
  </AuthenticatedLayout>
</template>
