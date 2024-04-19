<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { Character } from '@/types'
import { nextTick, Ref, ref } from 'vue'
import { calculateBubble } from '@/helpers/calculateBubble'
import { calculateLevel } from '@/helpers/calculateLevel'
import { calculateBubblesInCurrentLevel } from '@/helpers/calculateBubblesInCurrentLevel'
import { calculateBubblesToNextLevel } from '@/helpers/calculateBubblesToNextLevel'
import { calculateRemainingDowntime } from '@/helpers/calculateRemainingDowntime'
import { secondsToHourMinuteString } from '@/helpers/secondsToHourMinuteString'
import CreateCharacterModal from '@/Modals/Character/CreateCharacterModal.vue'
import UpdateCharacterModal from '@/Modals/Character/UpdateCharacterModal.vue'
import DestroyCharacterModal from '@/Modals/Character/DestroyCharacterModal.vue'
import CreateAdventureModal from '@/Modals/Adventure/CreateAdventureModal.vue'
import CreateDowntimeModal from '@/Modals/Downtime/CreateDowntimeModal.vue'

defineProps<{
  characters: Character[]
}>()

const createCharacterModal = ref()
const updateCharacterModal = ref()
const updateCharacterModalKey = ref('updateCharacterModalKey-1')
const destroyCharacterModal = ref()
const destroyCharacterModalKey = ref('destroyCharacterModalKey-1')
const createAdventureModal = ref()
const createDowntimeModal = ref()
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

const clickCreateDowntimeModal = (id: number) => {
  currentCharacterId.value = id
  createDowntimeModal.value.showModal()
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
                  Level {{ calculateLevel(character) }}
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
                  :value="calculateBubblesInCurrentLevel(character)"
                  :max="calculateBubblesToNextLevel(character)"
                />
                <div class="text-xs text-right -mt-1">
                  <font-awesome-icon
                    :icon="['fas', 'droplet']"
                    size="sm"
                    fixed-width
                  />
                  to next level
                  {{
                    calculateBubblesInCurrentLevel(character)
                  }} /
                  {{
                    calculateBubblesToNextLevel(character)
                  }}
                </div>
              </div>
              <div class="mt-3 text-xs grid grid-cols-2 gap-y-1 [&>*:nth-child(even)]:text-right">
                <div>
                  <p
                    class="tooltip tooltip-accent"
                    data-tip="Started his adventure here"
                  >
                    <font-awesome-icon
                      :icon="['fas', 'flag-checkered']"
                      fixed-width
                    />
                    Start Tier: <span class="uppercase">{{ character.start_tier }}</span>
                  </p>
                </div>
                <div>
                  <p>
                    <a
                      class="underline"
                      :href="character.external_link"
                      target="_blank"
                    >
                      Beyond Link
                      <font-awesome-icon
                        :icon="['fas', 'arrow-up-right-from-square']"
                        fixed-width
                      />
                    </a>
                  </p>
                </div>
                <div>
                  <p>
                    <font-awesome-icon
                      :icon="['fas', 'droplet']"
                      fixed-width
                    />
                    DM Bubbles: {{ character.dm_bubbles }}
                  </p>
                </div>
                <div>
                  <p>
                    DM Coins: {{ character.dm_coins }}
                    <font-awesome-icon
                      :icon="['fas', 'coins']"
                      fixed-width
                    />
                  </p>
                </div>
                <div>
                  <p
                    class="tooltip tooltip-accent"
                    data-tip="Adventures played"
                  >
                    <font-awesome-icon
                      :icon="['fas', 'compass']"
                      fixed-width
                    />
                    Adventures: {{ character.adventures.length }}
                  </p>
                </div>
                <div>
                  <p>
                    Bubble Shop: {{ character.bubble_shop_spend }}
                    <font-awesome-icon
                      :icon="['fas', 'shop']"
                      fixed-width
                    />
                  </p>
                </div>
                <div>
                  <p>
                    <font-awesome-icon
                      :icon="['fas', 'hourglass']"
                      fixed-width
                    />
                    DT Total: {{ calculateBubble(character) * 8 }}h
                  </p>
                </div>
                <div>
                  <p>
                    DT Remaining: {{ secondsToHourMinuteString(calculateRemainingDowntime(character)) }}
                    <font-awesome-icon
                      :icon="['far', 'moon']"
                      fixed-width
                    />
                  </p>
                </div>
              </div>
              <div class="mt-3 flex flex-wrap gap-1">
                <button
                  class="btn btn-sm grow"
                  @click="clickShowCharacter(character.id)"
                >
                  <font-awesome-icon :icon="['fas', 'person']" />
                  Details
                </button>
                <button
                  class="btn btn-sm grow"
                  @click="clickCreateAdventureModal(character.id)"
                >
                  <font-awesome-icon :icon="['fas', 'compass']" />
                  Add
                </button>
                <button
                  class="btn btn-sm grow"
                  @click="clickCreateDowntimeModal(character.id)"
                >
                  <font-awesome-icon :icon="['fas', 'hourglass']" />
                  Add
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
    <CreateDowntimeModal
      ref="createDowntimeModal"
      :character-id="currentCharacterId"
    />
  </AuthenticatedLayout>
</template>
