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
    <div class="py-12">
      <div class="max-w-7xl mx-auto">
        <div class="prose mb-12">
          <h2>{{ character.name }}</h2>
          <p>Lorem ipsum</p>
          <p>{{ character.character_classes[0].name }}</p>
          <p>Level {{ calculateLevel(calculateBubble(character.adventures)) }}</p>
          <p>{{ character.adventures.length }} played adventures </p>
          <p>Bubbles gained {{ calculateBubble(character.adventures) }} </p>
        </div>

        <div class="card bg-neutral text-neutral-content">
          <div class="card-body">
            <h2 class="card-title">
              Adventures
            </h2>
            <button @click="createAdventureModal.showModal()" class="btn w-40">Add adventure</button>
            <div v-for="(adventure, key) of character.adventures" :key="key">
              <div>{{ Math.floor(adventure.duration / 3600) }}h {{ (adventure.duration / 60) % 60 }}min</div>
              <div>Bubble {{ calculateBubble([adventure]) }}</div>
              <div>Has addtional Bubble {{ adventure.has_additional_bubble }}</div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <create-adventure-modal :character="character" ref="createAdventureModal"></create-adventure-modal>
  </AuthenticatedLayout>
</template>
