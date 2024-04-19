<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Adventure, Character } from '@/types'
import { nextTick, Ref, ref } from 'vue'
import { calculateBubbleByAdventure } from '@/helpers/calculateBubble'
import { calculateLevel } from '@/helpers/calculateLevel'
import CreateAdventureModal from '@/Modals/CreateAdventureModal.vue'
import DestroyAdventureModal from '@/Modals/DestroyAdventureModal.vue'
import UpdateAdventureModal from '@/Modals/UpdateAdventureModal.vue'

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

function onImgError(event: Event) {
  const target = event.target as HTMLImageElement
  target.src = '/images/placeholder.jpg'
}
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
                <img
                  class="my-0"
                  :src="'/storage/' + character.avatar"
                  alt=""
                  @error="onImgError($event)"
                >
              </div>
            </div>
            <p class="text-xs">
              Level {{ calculateLevel(character) }}
              {{ character.character_classes[0].name }}
            </p>
          </div>
        </div>

        <div class="flex justify-between">
          <h2 class="card-title">
            Adventures
          </h2>
          <button
            class="btn btn-neutral"
            @click="createAdventureModal.showModal()"
          >
            <font-awesome-icon :icon="['fas', 'plus']" />
            Add adventure
          </button>
        </div>
        <div class="grid grid-cols-2 gap-3 mt-3">
          <div
            v-for="(adventure, key) of character.adventures"
            :key="key"
            class="card card-compact bg-neutral text-neutral-content group"
          >
            <div class="card-body">
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
              <div class="card-title">
                <h3>Adventure {{ key + 1 }}</h3>
              </div>
              <div class="flex justify-between text-xs">
                <p>
                  You gained {{ calculateBubbleByAdventure([adventure]) }}
                  <span v-if="adventure.has_additional_bubble">+ {{ adventure.has_additional_bubble }}</span>
                  bubbles
                </p>
                <p class="italic text-right">
                  {{ new Date(adventure.start_date).toLocaleDateString() }}
                  {{ Math.floor(adventure.duration / 3600) }}h {{ (adventure.duration / 60) % 60 }}min
                </p>
              </div>
              <p
                v-if="adventure.notes"
                class="whitespace-pre-wrap"
              >
                {{ adventure.notes }}
              </p>
              <p v-else>
                There are no notes for this adventure
              </p>
            </div>
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
  </AuthenticatedLayout>
</template>
