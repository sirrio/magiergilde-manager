<script setup lang="ts">
import CreateAdventureModal from '@/Modals/Adventure/CreateAdventureModal.vue'
import DestroyAdventureModal from '@/Modals/Adventure/DestroyAdventureModal.vue'
import UpdateAdventureModal from '@/Modals/Adventure/UpdateAdventureModal.vue'
import { Adventure, Character } from "@/types"
import { nextTick, Ref, ref } from 'vue'
import { calculateBubbleByAdventures } from '@/helpers/calculateBubble'

defineProps<{
  character: Character
}>()

const createAdventureModal = ref()
const updateAdventureModal = ref()
const updateAdventureModalKey = ref('updateAdventureModalKey-1')
const destroyAdventureModal = ref()
const destroyAdventureModalKey = ref('destroyAdventureModalKey-1')
const currentAdventure: Ref<Adventure | null> = ref(null)

const clickUpdateAdventureModal = async (adventure: Adventure) => {
  currentAdventure.value = adventure
  updateAdventureModalKey.value = 'updateAdventureModalKey-' + Math.random()
  await nextTick()
  updateAdventureModal.value.showModal()
}

const clickDestroyAdventureModal = async (adventure: Adventure) => {
  currentAdventure.value = adventure
  destroyAdventureModalKey.value = 'destroyAdventureModalKey-' + Math.random()
  await nextTick()
  destroyAdventureModal.value.showModal()
}
</script>

<template>
  <div class="flex flex-col gap-3">
    <div class="flex justify-between">
      <h2 class="card-title">
        <font-awesome-icon
          :icon="['fas', 'compass']"
        />
        Adventures
      </h2>
      <button
        class="btn btn-ghost"
        @click="createAdventureModal.showModal()"
      >
        <font-awesome-icon :icon="['fas', 'plus']" />
        Add adventure
      </button>
    </div>
    <div
      v-if="character.adventures.length === 0"
      class="card bg-base-100 text-base-content"
    >
      <div class="card-body text-center">
        <font-awesome-icon
          :icon="['fas', 'circle-exclamation']"
          size="7x"
        />
        <h3 class="font-semibold text-xl">
          No adventures yet
        </h3>
      </div>
    </div>
    <div
      v-for="(adventure, key) of character.adventures"
      v-else
      :key="key"
      class="card card-sm bg-base-100 text-base-content group"
    >
      <div
        tabindex="0"
        class="card-body collapse cursor-pointer"
      >
        <div class="group-hover:absolute group-hover:flex gap-1 hidden top-2 right-2">
          <button
            class="btn btn-xs btn-square"
            @click="clickUpdateAdventureModal(adventure)"
          >
            <font-awesome-icon :icon="['fas', 'gear']" />
          </button>
          <button
            class="btn btn-xs btn-error btn-square"
            @click="clickDestroyAdventureModal(adventure)"
          >
            <font-awesome-icon :icon="['fas', 'x']" />
          </button>
        </div>
        <div>
          <div class="card-title">
            <h3>
              <font-awesome-icon
                :icon="['fas', 'hashtag']"
                size="xs"
              />
              {{ key + 1 }}
              {{ adventure.title ?? "Adventure" }}
              <font-awesome-icon
                v-if="adventure.notes"
                :icon="['fas', 'note-sticky']"
                fixed-width
                size="xs"
              />
            </h3>
          </div>
          <span class="text-xs">
            {{ adventure.game_master ? `Mastered by ${adventure.game_master} ` : "No game master" }}
          </span>
        </div>
        <div class="flex justify-between text-xs">
          <p>
            <font-awesome-icon
              :icon="['fas', 'clock']"
            />
            You gained
            {{ calculateBubbleByAdventures([adventure]) }}
            <span v-if="adventure.has_additional_bubble">(Character Quest)</span>
            <font-awesome-icon
              :icon="['fas', 'droplet']"
              size="xs"
              fixed-width
            />
            in {{ Math.floor(adventure.duration / 3600) }}h {{ (adventure.duration / 60) % 60 }}min
          </p>
          <p class="italic text-right">
            <font-awesome-icon
              :icon="['fas', 'calendar']"
            />
            {{ new Date(adventure.start_date).toLocaleDateString() }}
          </p>
        </div>
        <div class="collapse-content">
          <p
            v-if="adventure.notes"
            class="whitespace-pre-wrap "
          >
            {{ adventure.notes }}
          </p>
          <p v-else>
            <font-awesome-icon
              :icon="['fas', 'circle-exclamation']"
            />
            No notes
          </p>
        </div>
      </div>
    </div>
  </div>
  <CreateAdventureModal
    ref="createAdventureModal"
    :character-id="character.id"
  />
  <UpdateAdventureModal
    v-if="currentAdventure"
    ref="updateAdventureModal"
    :key="updateAdventureModalKey"
    :adventure="currentAdventure"
  />
  <DestroyAdventureModal
    v-if="currentAdventure"
    ref="destroyAdventureModal"
    :key="destroyAdventureModalKey"
    :adventure="currentAdventure"
  />
</template>
