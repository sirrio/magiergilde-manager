<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { Character } from '@/types'
import { nextTick, Ref, ref } from 'vue'
import { calculateBubble } from '@/helpers/calculateBubble'
import { calculateLevel } from '@/helpers/calculateLevel'
import { calculateLevelBubbles } from '@/helpers/calculateLevelBubbles'
import CreateCharacterModal from '@/Modals/CreateCharacterModal.vue'
import UpdateCharacterModal from '@/Modals/UpdateCharacterModal.vue'
import DestroyCharacterModal from '@/Modals/DestroyCharacterModal.vue'
import CreateAdventureModal from '@/Modals/CreateAdventureModal.vue'

defineProps<{
  characters: Character[]
}>()

const createCharacterModal = ref()
const updateCharacterModal = ref()
const updateCharacterModalKey = ref('updateCharacterModalKey-1')
const destroyCharacterModal = ref()
const destroyCharacterModalKey = ref('destroyCharacterModalKey-1')
const createAdventureModal = ref()
const currentCharacterId = ref(0)
const currentCharacter: Ref<Character | null> = ref(null)

const clickShowCharacter = (id: number) => {
  router.visit(route('character.show', { character: id }))
}
const clickUpdateCharacterModal = async (character: Character) => {
  currentCharacter.value = character
  updateCharacterModalKey.value = 'updateCharacterModalKey-' + Math.random()
  await nextTick()
  updateCharacterModal.value.showModal()
}

const clickDestroyCharacterModal = async (character: Character) => {
  currentCharacter.value = character
  destroyCharacterModalKey.value = 'destroyCharacterModalKey-' + Math.random()
  await nextTick()
  destroyCharacterModal.value.showModal()
}

const clickCreateAdventureModal = (id: number) => {
  currentCharacterId.value = id
  createAdventureModal.value.showModal()
}

function onImgError(event: Event) {
  const target = event.target as HTMLImageElement
  target.src = '/images/placeholder.jpg'
}
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <div class="py-12 px-6">
      <div class="max-w-7xl mx-auto">
        <div class="flex justify-between">
          <div class="prose mb-12">
            <h2>Your characters</h2>
            <p>You can manager your characters here</p>
          </div>
          <div>
            <button
              class="btn btn-neutral"
              @click="createCharacterModal.showModal()"
            >
              <font-awesome-icon :icon="['fas', 'plus']" />
              Create new character
            </button>
          </div>
        </div>


        <div
          v-if="characters.length === 0"
          class="card bg-neutral text-neutral-content"
        >
          <div class="card-body text-center">
            <font-awesome-icon
              :icon="['fas', 'circle-exclamation']"
              size="7x"
            />
            <h3 class="font-semibold text-xl">
              No character yet
            </h3>
          </div>
        </div>

        <div
          v-else
          class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4"
        >
          <div
            v-for="(character, key) of characters"
            :key="key"
            class="card max-w-sm bg-neutral text-neutral-content"
          >
            <div class="card-body group">
              <div class="group-hover:absolute group-hover:flex gap-1 hidden top-2 right-2">
                <button
                  class="btn btn-xs btn-square"
                  @click="clickUpdateCharacterModal(character)"
                >
                  <font-awesome-icon :icon="['fas', 'gear']" />
                </button>
                <button
                  class="btn btn-xs btn-error btn-square"
                  @click="clickDestroyCharacterModal(character)"
                >
                  <font-awesome-icon :icon="['fas', 'x']" />
                </button>
              </div>
              <h3 class="card-title capitalize">
                {{ character.name }}
              </h3>
              <div class="flex justify-between">
                <p class="text-xs">
                  Level {{ calculateLevel(calculateBubble(character.adventures), character.start_tier) }}
                  {{ character.character_classes[0].name }}
                </p>
                <!--                <div>-->
                <!--                  <img :src="character.character_classes[0].src" height="16" width="16" alt=""/>-->
                <!--                </div>-->
              </div>
              <div class="avatar">
                <div class="aspect-square rounded-full w-full">
                  <img
                    :src="'storage/' + character.avatar"
                    alt=""
                    @error="onImgError($event)"
                  >
                </div>
              </div>
              <div>
                <progress
                  class="progress w-full"
                  :value="calculateBubble(character.adventures) - calculateLevelBubbles(calculateLevel(calculateBubble(character.adventures), character.start_tier) - 1, character.start_tier)"
                  :max="calculateLevelBubbles(calculateLevel(calculateBubble(character.adventures), character.start_tier), character.start_tier) - calculateLevelBubbles(calculateLevel(calculateBubble(character.adventures), character.start_tier) - 1, character.start_tier)"
                />
                <div class="text-xs text-right -mt-1.5">
                  Bubbles to next level
                  {{ calculateBubble(character.adventures) - calculateLevelBubbles(calculateLevel(calculateBubble(character.adventures), character.start_tier) - 1, character.start_tier)
                  }} /
                  {{
                    calculateLevelBubbles(calculateLevel(calculateBubble(character.adventures), character.start_tier), character.start_tier) - calculateLevelBubbles(calculateLevel(calculateBubble(character.adventures), character.start_tier) - 1, character.start_tier)
                  }}
                </div>
              </div>
              <div class="mt-3 flex justify-end gap-3">
                <p
                  class="grow-0 uppercase tooltip tooltip-accent"
                  data-tip="Started his adventure here"
                >
                  <font-awesome-icon :icon="['fas', 'flag-checkered']" />
                  {{ character.start_tier }}
                </p>
                <p
                  class="grow-0 uppercase tooltip tooltip-accent"
                  data-tip="Adventures played"
                >
                  <font-awesome-icon :icon="['fas', 'person-hiking']" />
                  {{ character.adventures.length }}
                </p>
                <p class="grow-0">
                  <a
                    class="underline"
                    :href="character.external_link"
                    target="_blank"
                  >
                    Beyond
                    <font-awesome-icon
                      :icon="['fas', 'arrow-up-right-from-square']"
                      size="xs"
                    />
                  </a>
                </p>
              </div>
              <div class="mt-3 flex gap-1">
                <button
                  class="btn btn-sm"
                  @click="clickShowCharacter(character.id)"
                >
                  <font-awesome-icon :icon="['fas', 'person-hiking']" />
                  View adventures
                </button>
                <button
                  class="btn btn-sm"
                  @click="clickCreateAdventureModal(character.id)"
                >
                  <font-awesome-icon :icon="['fas', 'plus']" />
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <CreateCharacterModal ref="createCharacterModal" />
    <UpdateCharacterModal
      v-if="currentCharacter"
      ref="updateCharacterModal"
      :key="updateCharacterModalKey"
      :character="currentCharacter"
    />
    <DestroyCharacterModal
      v-if="currentCharacter"
      ref="destroyCharacterModal"
      :key="destroyCharacterModalKey"
      :character="currentCharacter"
    />
    <CreateAdventureModal
      ref="createAdventureModal"
      :character-id="currentCharacterId"
    />
  </AuthenticatedLayout>
</template>
