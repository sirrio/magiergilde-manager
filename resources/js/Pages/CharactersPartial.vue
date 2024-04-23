<script setup lang="ts">
import { nextTick, Ref, ref } from 'vue'
import { Character, Game } from '@/types'
import { router } from '@inertiajs/vue3'
import CreateCharacterModal from '@/Modals/Character/CreateCharacterModal.vue'
import UpdateCharacterModal from '@/Modals/Character/UpdateCharacterModal.vue'
import DestroyCharacterModal from '@/Modals/Character/DestroyCharacterModal.vue'
import CreateAdventureModal from '@/Modals/Adventure/CreateAdventureModal.vue'
import CreateDowntimeModal from '@/Modals/Downtime/CreateDowntimeModal.vue'
import { calculateTier } from '../helpers/calculateTier'
import { calculateLevel } from '../helpers/calculateLevel'
import { calculateClassString } from '../helpers/calculateClassString'
import TierLogo from '@/Components/TierLogo.vue'
import { calculateBubblesInCurrentLevel } from '@/helpers/calculateBubblesInCurrentLevel'
import { calculateBubblesToNextLevel } from '@/helpers/calculateBubblesToNextLevel'
import { calculateBubble } from '../helpers/calculateBubble'
import { secondsToHourMinuteString } from '../helpers/secondsToHourMinuteString'
import { calculateRemainingDowntime } from '../helpers/calculateRemainingDowntime'

defineProps<{
  characters: Character[]
}>()

const currentCharacterId = ref(0)
const currentCharacter: Ref<Character | null> = ref(null)

const createCharacterModal = ref()
const createCharacterModalKey = ref('createCharacterModalKey-1')
const updateCharacterModal = ref()
const updateCharacterModalKey = ref('updateCharacterModalKey-1')
const destroyCharacterModal = ref()
const destroyCharacterModalKey = ref('destroyCharacterModalKey-1')


const createAdventureModal = ref()

const createDowntimeModal = ref()

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

const clickCreateCharacterModal = async () => {
  createCharacterModalKey.value = 'createCharacterModalKey-' + Math.random()
  await nextTick()
  createCharacterModal.value.showModal()
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
  <div class="flex justify-between items-center mb-6">
    <div>
      <h2 class="text-2xl font-bold">
        Your characters
        <span
          class="text-sm tooltip tooltip-bottom"
          data-tip="Your ET and Filler Character are not counted against the limit"
        >
          ({{ characters.filter(char => !(char.is_filler || calculateTier(char) === "et")).length
          }} + {{ characters.filter(char => (char.is_filler || calculateTier(char) === "et")).length
          }}/8)
        </span>
      </h2>
      <p class="text-xs hidden sm:block">
        Manage your characters here.
      </p>
    </div>
    <div>
      <button
        class="btn btn-neutral"
        :disabled="characters.filter(char => !(char.is_filler || calculateTier(char) === 'et') ).length >= 8"
        @click="clickCreateCharacterModal()"
      >
        <font-awesome-icon :icon="['fas', 'plus']" />
        <span class="hidden sm:inline">Create new character</span>
      </button>
    </div>
  </div>
  <div
    v-if="characters.length === 0"
    class="card bg-base-100 text-base-content"
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
    class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
  >
    <div
      v-for="(character, key) of characters"
      :key="key"
      class="card bg-base-100 text-base-content"
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
          <span class="break-all">{{ character.name }}</span>
          <TierLogo
            :size="20"
            :tier="calculateTier(character)"
          />
        </h3>
        <div class="flex justify-between">
          <p class="text-xs">
            Level {{ calculateLevel(character) }}
            {{ calculateClassString(character) }}
          </p>
          <!--                <div>-->
          <!--                  <img :src="character.character_classes[0].src" height="16" width="16" alt=""/>-->
          <!--                </div>-->
        </div>
        <div class="avatar">
          <div class="aspect-square rounded-full w-full">
            <img
              v-if="character.avatar"
              :src="'storage/' + character.avatar"
              alt="Avatar"
              @error="onImgError($event)"
            >
            <img
              v-else
              src="/images/placeholder.jpg"
              alt="Avatar missing"
            >
          </div>
        </div>
        <div>
          <progress
            class="progress progress-accent w-full"
            :value="calculateBubblesInCurrentLevel(character)"
            :max="calculateBubblesToNextLevel(character)"
          />
          <div class="text-xs text-right -mt-1">
            {{
              calculateBubblesToNextLevel(character) - calculateBubblesInCurrentLevel(character)
            }}
            <font-awesome-icon
              :icon="['fas', 'droplet']"
              size="sm"
              fixed-width
            />
            to next level
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
              Start Tier
              <TierLogo
                :size="14"
                :tier="character.start_tier"
              />
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
  <CreateCharacterModal
    ref="createCharacterModal"
    :key="createCharacterModalKey"
  />
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
</template>
