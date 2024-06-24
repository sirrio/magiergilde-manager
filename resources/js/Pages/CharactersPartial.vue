<script setup lang="ts">
import { nextTick, Ref, ref } from 'vue'
import { Character } from '@/types'
import { router } from '@inertiajs/vue3'
import AllyModal from '@/Modals/AllyModal.vue'
import CreateCharacterModal from '@/Modals/Character/CreateCharacterModal.vue'
import UpdateCharacterModal from '@/Modals/Character/UpdateCharacterModal.vue'
import DestroyCharacterModal from '@/Modals/Character/DestroyCharacterModal.vue'
import CreateAdventureModal from '@/Modals/Adventure/CreateAdventureModal.vue'
import CreateDowntimeModal from '@/Modals/Downtime/CreateDowntimeModal.vue'
import DestroyDeletedCharacterModal from '@/Modals/Character/DestroyDeletedCharacterModal.vue'
import UpdateDeletedCharacterModal from '@/Modals/Character/UpdateDeletedCharacterModal.vue'
import TierLogo from '@/Components/TierLogo.vue'
import { calculateTier } from '@/helpers/calculateTier'
import { calculateLevel } from '@/helpers/calculateLevel'
import { calculateClassString } from '@/helpers/calculateClassString'
import { calculateBubblesInCurrentLevel } from '@/helpers/calculateBubblesInCurrentLevel'
import { calculateBubblesToNextLevel } from '@/helpers/calculateBubblesToNextLevel'
import { calculateBubble } from '@/helpers/calculateBubble'
import { secondsToHourMinuteString } from '@/helpers/secondsToHourMinuteString'
import { calculateRemainingDowntime } from '@/helpers/calculateRemainingDowntime'
import { calculateFactionDowntime, calculateOtherDowntime } from '@/helpers/calculateDowntime'
import { calculateFactionLevel } from '@/helpers/calculateFactionLevel'
import draggable from 'vuedraggable'

const props = defineProps<{
  characters: Character[]
}>()

const trashedMode = ref(false)

const currentCharacterId = ref(0)
const currentCharacter: Ref<Character | null> = ref(null)

const allyModal = ref()
const allyModalKey = ref('allyModalKey-1')

const createCharacterModal = ref()
const createCharacterModalKey = ref('createCharacterModalKey-1')
const updateCharacterModal = ref()
const updateCharacterModalKey = ref('updateCharacterModalKey-1')
const destroyCharacterModal = ref()
const destroyCharacterModalKey = ref('destroyCharacterModalKey-1')

const updateDeletedCharacterModal = ref()
const updateDeletedCharacterModalKey = ref('updateCharacterModalKey-1')
const destroyDeletedCharacterModal = ref()
const destroyDeletedCharacterModalKey = ref('destroyCharacterModalKey-1')

const createAdventureModal = ref()

const createDowntimeModal = ref()

const filteredCharacters = ref(props.characters.filter(char => !char.deleted_at))
const drag = ref(false)

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

const clickUpdateDeletedCharacterModal = async (character: Character) => {
  currentCharacter.value = character
  updateDeletedCharacterModalKey.value = 'updateDeletedCharacterModalKey-' + Math.random()
  await nextTick()
  updateDeletedCharacterModal.value.showModal()
}

const clickDestroyDeletedCharacterModal = async (character: Character) => {
  currentCharacter.value = character
  destroyDeletedCharacterModalKey.value = 'destroyDeletedCharacterModalKey-' + Math.random()
  await nextTick()
  destroyDeletedCharacterModal.value.showModal()
}

const clickCreateCharacterModal = async () => {
  createCharacterModalKey.value = 'createCharacterModalKey-' + Math.random()
  await nextTick()
  createCharacterModal.value.showModal()
}

const clickAllyModal = async (character: Character) => {
  currentCharacter.value = character
  allyModalKey.value = 'allyModalKey-' + Math.random()
  await nextTick()
  allyModal.value.showModal()
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

const onEnd = () => {
  drag.value = false
  router.post(route('character.sort'), {
    list: filteredCharacters.value,
  }, { preserveScroll: true })
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
          ({{
            characters.filter(char => !char.deleted_at && !(char.is_filler || calculateTier(char) === "et")).length
          }}<template
            v-if="characters.filter(char => !char.deleted_at && (char.is_filler || calculateTier(char) === 'et')).length > 0"
          >+{{ characters.filter(char => !char.deleted_at && (char.is_filler || calculateTier(char) === "et")).length
          }}</template>/8)
          <span
            v-if="characters.filter(char => !char.deleted_at && !(char.is_filler || calculateTier(char) === 'et')).length > 8"
            class="text-xs text-error"
          >
            <font-awesome-icon
              :icon="['fas', 'exclamation-circle']"
              size="sm"
              fixed-width
            />
            You have more then maximum character
            {{ characters.filter(char => !(!char.is_filler || calculateTier(char) === "et")).length }}
          </span>
        </span>
      </h2>
      <p class="text-xs hidden sm:block">
        Manage your characters here.
      </p>
    </div>
    <div>
      <button
        class="btn btn-neutral text-neutral-content"
        @click="clickCreateCharacterModal()"
      >
        <font-awesome-icon :icon="['fas', 'plus']" />
        <span class="hidden sm:inline">Create new character</span>
      </button>
      <button
        class="btn btn-neutral text-neutral-content ml-1"
        :class="{'btn-error text-error-content': trashedMode}"
        @click="trashedMode = !trashedMode"
      >
        <font-awesome-icon :icon="['fas', 'arrow-rotate-left']" />
      </button>
    </div>
  </div>
  <div
    v-if="characters.filter(char => trashedMode ? char.deleted_at : !char.deleted_at).length === 0"
    class="card bg-base-100 text-base-content"
  >
    <div class="card-body text-center">
      <font-awesome-icon
        :icon="['fas', 'circle-exclamation']"
        size="7x"
      />
      <h3 class="font-semibold text-xl">
        No <span
          v-if="trashedMode"
          class="text-error"
        >Deleted </span> character yet
      </h3>
    </div>
  </div>
  <draggable
    v-else-if="!trashedMode"
    :list="filteredCharacters"
    item-key="id"
    :sort="true"
    handle=".handle"
    class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
    @start="drag=true"
    @end="onEnd"
  >
    <template #item="{element}">
      <div class="card bg-base-100 text-base-content">
        <div
          v-if="!element.is_filler"
          class="card-body group"
        >
          <div
            v-if="!element.deleted_at"
            class="group-hover:absolute group-hover:flex gap-1 hidden top-2 right-2"
          >
            <div
              class="tooltip"
              data-tip="Drag and drop to reorder character"
            >
              <button
                class="btn btn-xs btn-square handle"
              >
                <font-awesome-icon :icon="['fas', 'grip-vertical']" />
              </button>
            </div>
            <div
              class="tooltip"
              data-tip="Character settings"
            >
              <button
                class="btn btn-xs btn-square"
                @click="clickUpdateCharacterModal(element)"
              >
                <font-awesome-icon :icon="['fas', 'gear']" />
              </button>
            </div>
            <div
              class="tooltip"
              data-tip="Delete character"
            >
              <button
                class="btn btn-xs btn-error btn-square"
                @click="clickDestroyCharacterModal(element)"
              >
                <font-awesome-icon :icon="['fas', 'x']" />
              </button>
            </div>
          </div>

          <h3 class="card-title capitalize">
            <span class="break-all">
              <span
                v-if="element.deleted_at"
                class="text-error"
              >(Deleted) </span>{{ element.name }}</span>
            <TierLogo
              :size="20"
              :tier="calculateTier(element)"
            />
          </h3>
          <div class="flex justify-between">
            <p class="text-xs">
              Level {{ calculateLevel(element) }}
              {{ calculateClassString(element) }}
            </p>
            <!--                <div>-->
            <!--                  <img :src="character.character_classes[0].src" height="16" width="16" alt=""/>-->
            <!--                </div>-->
          </div>
          <div class="avatar">
            <div class="aspect-square rounded-full w-full">
              <img
                v-if="element.avatar"
                :src="'storage/' + element.avatar"
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
              :value="calculateBubblesInCurrentLevel(element)"
              :max="calculateBubblesToNextLevel(element)"
            />
            <div
              class="text-xs text-right -mt-1"
            >
              <template v-if="calculateBubblesToNextLevel(element) - calculateBubblesInCurrentLevel(element) > 0">
                {{
                  calculateBubblesToNextLevel(element) - calculateBubblesInCurrentLevel(element)
                }}
                <font-awesome-icon
                  :icon="['fas', 'droplet']"
                  size="sm"
                  fixed-width
                />
                to next level
              </template>
              <template v-else>
                Max level
              </template>
            </div>
          </div>
          <div class="mt-3 text-xs grid grid-cols-2 gap-1">
            <div class="border rounded p-1">
              <h4 class="font-bold">
                <font-awesome-icon
                  :icon="['fas', 'compass']"
                  fixed-width
                />
                Adventure
              </h4>
              <p>
                Played: {{ element.adventures.length }} times
              </p>
              <p>
                Started in:
                <TierLogo
                  :size="14"
                  :tier="element.start_tier"
                />
              </p>
              <p>
                Bubble Shop: {{ element.bubble_shop_spend }}
                <font-awesome-icon
                  :icon="['fas', 'droplet']"
                />
              </p>
            </div>

            <div class="border rounded p-1">
              <h4 class="font-bold">
                <font-awesome-icon
                  :icon="['fas', 'users']"
                  fixed-width
                />
                Faction
              </h4>
              <p>
                <span class="capitalize">{{ calculateTier(element) === "bt" ? `none (${element.faction} later)` : element.faction }}</span>
              </p>
              <p>
                Level: {{ calculateFactionLevel(element) }}
              </p>
            </div>

            <div class="border rounded p-1">
              <h4 class="font-bold">
                <font-awesome-icon
                  :icon="['fas', 'hourglass']"
                  fixed-width
                />
                Downtime
              </h4>
              <p>
                Total: {{ calculateBubble(element) * 8 }}h
              </p>
              <p>
                On faction: {{ secondsToHourMinuteString(calculateFactionDowntime(element)) }}
              </p>
              <p>
                On other: {{ secondsToHourMinuteString(calculateOtherDowntime(element)) }}
              </p>
              <p class="font-bold">
                Remaining: {{ secondsToHourMinuteString(calculateRemainingDowntime(element)) }}
              </p>
            </div>

            <div class="border rounded p-1">
              <h4 class="font-bold">
                <font-awesome-icon
                  :icon="['fas', 'hat-wizard']"
                  fixed-width
                />
                Game Master
              </h4>
              <p>
                Bubbles: {{ element.dm_bubbles }}
                <font-awesome-icon
                  :icon="['fas', 'droplet']"
                />
              </p>
              <p>
                Coins: {{ element.dm_coins }}
                <font-awesome-icon
                  :icon="['fas', 'coins']"
                />
              </p>
            </div>
          </div>
          <div class="mt-3 flex flex-wrap justify-between gap-1">
            <button
              class="btn btn-sm w-full"
              @click="clickShowCharacter(element.id)"
            >
              <font-awesome-icon :icon="['fas', 'person']" />
              Details
            </button>
            <button
              class="btn btn-sm tooltip grow"
              data-tip="Add adventure"
              @click="clickCreateAdventureModal(element.id)"
            >
              <font-awesome-icon :icon="['fas', 'compass']" />
            </button>
            <button
              class="btn btn-sm tooltip grow"
              data-tip="Add downtime"
              @click="clickCreateDowntimeModal(element.id)"
            >
              <font-awesome-icon :icon="['fas', 'hourglass']" />
            </button>
            <button
              class="btn btn-sm tooltip grow"
              data-tip="Show allies"
              @click="clickAllyModal(element)"
            >
              <font-awesome-icon :icon="['fas', 'sitemap']" />
            </button>
            <a

              :href="element.external_link"
              target="_blank"
              class="grow"
            >
              <button
                class="btn btn-sm tooltip w-full"
                data-tip="DnDBeyond Link"
              >
                <font-awesome-icon :icon="['fas', 'arrow-up-right-from-square']" />
              </button>
            </a>
          </div>
        </div>
        <div
          v-else
          class="card-body group"
        >
          <div
            v-if="!element.deleted_at"
            class="group-hover:absolute group-hover:flex gap-1 hidden top-2 right-2"
          >
            <div
              class="tooltip"
              data-tip="Drag and drop to reorder character"
            >
              <button
                class="btn btn-xs btn-square handle"
              >
                <font-awesome-icon :icon="['fas', 'grip-vertical']" />
              </button>
            </div>
            <div
              class="tooltip"
              data-tip="Character settings"
            >
              <button
                class="btn btn-xs btn-square"
                @click="clickUpdateCharacterModal(element)"
              >
                <font-awesome-icon :icon="['fas', 'gear']" />
              </button>
            </div>
            <div
              class="tooltip"
              data-tip="Delete character"
            >
              <button
                class="btn btn-xs btn-error btn-square"
                @click="clickDestroyCharacterModal(element)"
              >
                <font-awesome-icon :icon="['fas', 'x']" />
              </button>
            </div>
          </div>
          <h3 class="card-title capitalize">
            <span class="break-all"><span
              v-if="element.deleted_at"
              class="text-error"
            >(Deleted) </span>{{ element.name }}</span>
            <font-awesome-icon
              :icon="['fas', 'plus']"
              size="2xs"
              class="-mr-1.5"
            />
            <font-awesome-icon
              :icon="['fas', '1']"
              size="sm"
            />
          </h3>
          <div class="flex justify-between">
            <p class="text-xs">
              Level 3
              {{ calculateClassString(element) }}
            </p>
            <!--                <div>-->
            <!--                  <img :src="character.character_classes[0].src" height="16" width="16" alt=""/>-->
            <!--                </div>-->
          </div>
          <div class="avatar">
            <div class="aspect-square rounded-full w-full">
              <img
                v-if="element.avatar"
                :src="'storage/' + element.avatar"
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
          <div class="mt-3 text-xs grid grid-cols-2 gap-y-1 [&>*:nth-child(even)]:text-right">
            <div>
              <p>
                <font-awesome-icon
                  :icon="['fas', 'plus']"
                  size="2xs"
                />
                <font-awesome-icon
                  :icon="['fas', '1']"
                  size="sm"
                />
                Filler character
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
                Adventures: {{ element.adventures.length }}
              </p>
            </div>
          </div>
          <div class="mt-3 flex flex-wrap gap-1">
            <button
              class="btn btn-sm grow"
              @click="clickShowCharacter(element.id)"
            >
              <font-awesome-icon :icon="['fas', 'person']" />
              Details
            </button>
            <button
              class="btn btn-sm tooltip"
              data-tip="Add adventure"
              @click="clickCreateAdventureModal(element.id)"
            >
              <font-awesome-icon :icon="['fas', 'compass']" />
            </button>
            <button
              class="btn btn-sm tooltip"
              data-tip="Show allies"
              @click="clickAllyModal(element)"
            >
              <font-awesome-icon :icon="['fas', 'sitemap']" />
            </button>
            <a

              :href="element.external_link"
              target="_blank"
            >
              <button
                class="btn btn-sm tooltip"
                data-tip="DnDBeyond Link"
              >
                <font-awesome-icon :icon="['fas', 'arrow-up-right-from-square']" />
              </button>
            </a>
          </div>
        </div>
      </div>
    </template>
  </draggable>
  <div
    v-else
    class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
  >
    <div
      v-for="(character, key) of characters.filter(char => char.deleted_at )"
      :key="key"
      class="card bg-base-100 text-base-content"
    >
      <div
        v-if="!character.is_filler"
        class="card-body group"
      >
        <div
          class="group-hover:absolute group-hover:flex gap-1 hidden top-2 right-2"
        >
          <button
            class="btn btn-xs btn-square"
            @click="clickUpdateDeletedCharacterModal(character)"
          >
            <font-awesome-icon :icon="['fas', 'arrow-rotate-left']" />
          </button>
          <button
            class="btn btn-xs btn-error btn-square"
            @click="clickDestroyDeletedCharacterModal(character)"
          >
            <font-awesome-icon :icon="['fas', 'x']" />
          </button>
        </div>
        <h3 class="card-title capitalize">
          <span class="break-all">
            <span
              v-if="character.deleted_at"
              class="text-error"
            >(Deleted) </span>{{ character.name }}</span>
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
          <div
            class="text-xs text-right -mt-1"
          >
            <template v-if="calculateBubblesToNextLevel(character) - calculateBubblesInCurrentLevel(character) > 0">
              {{
                calculateBubblesToNextLevel(character) - calculateBubblesInCurrentLevel(character)
              }}
              <font-awesome-icon
                :icon="['fas', 'droplet']"
                size="sm"
                fixed-width
              />
              to next level
            </template>
            <template v-else>
              Max level
            </template>
          </div>
        </div>
        <div class="mt-3 text-xs grid grid-cols-2 gap-1">
          <div class="border rounded p-1">
            <h4 class="font-bold">
              <font-awesome-icon
                :icon="['fas', 'compass']"
                fixed-width
              />
              Adventure
            </h4>
            <p>
              Played: {{ character.adventures.length }} times
            </p>
            <p>
              Started in:
              <TierLogo
                :size="14"
                :tier="character.start_tier"
              />
            </p>
            <p>
              Bubble Shop: {{ character.bubble_shop_spend }}
              <font-awesome-icon
                :icon="['fas', 'droplet']"
              />
            </p>
          </div>

          <div class="border rounded p-1">
            <h4 class="font-bold">
              <font-awesome-icon
                :icon="['fas', 'users']"
                fixed-width
              />
              Faction
            </h4>
            <p>
              <span class="capitalize">{{ calculateTier(character) === "bt" ? `none (${character.faction} later)` : character.faction }}</span>
            </p>
            <p>
              Level: {{ calculateFactionLevel(character) }}
            </p>
          </div>

          <div class="border rounded p-1">
            <h4 class="font-bold">
              <font-awesome-icon
                :icon="['fas', 'hourglass']"
                fixed-width
              />
              Downtime
            </h4>
            <p>
              Total: {{ calculateBubble(character) * 8 }}h
            </p>
            <p>
              On faction: {{ secondsToHourMinuteString(calculateFactionDowntime(character)) }}
            </p>
            <p>
              On other: {{ secondsToHourMinuteString(calculateOtherDowntime(character)) }}
            </p>
            <p class="font-bold">
              Remaining: {{ secondsToHourMinuteString(calculateRemainingDowntime(character)) }}
            </p>
          </div>

          <div class="border rounded p-1">
            <h4 class="font-bold">
              <font-awesome-icon
                :icon="['fas', 'hat-wizard']"
                fixed-width
              />
              Game Master
            </h4>
            <p>
              Bubbles: {{ character.dm_bubbles }}
              <font-awesome-icon
                :icon="['fas', 'droplet']"
              />
            </p>
            <p>
              Coins: {{ character.dm_coins }}
              <font-awesome-icon
                :icon="['fas', 'coins']"
              />
            </p>
          </div>
        </div>
        <div class="mt-3 flex flex-wrap justify-between gap-1">
          <button
            class="btn btn-sm w-full"
            @click="clickShowCharacter(character.id)"
          >
            <font-awesome-icon :icon="['fas', 'person']" />
            Details
          </button>
          <button
            class="btn btn-sm tooltip grow"
            data-tip="Add adventure"
            @click="clickCreateAdventureModal(character.id)"
          >
            <font-awesome-icon :icon="['fas', 'compass']" />
          </button>
          <button
            class="btn btn-sm tooltip grow"
            data-tip="Add downtime"
            @click="clickCreateDowntimeModal(character.id)"
          >
            <font-awesome-icon :icon="['fas', 'hourglass']" />
          </button>
          <button
            class="btn btn-sm tooltip grow"
            data-tip="Show allies"
            @click="clickAllyModal(character)"
          >
            <font-awesome-icon :icon="['fas', 'sitemap']" />
          </button>
          <a

            :href="character.external_link"
            target="_blank"
            class="grow"
          >
            <button
              class="btn btn-sm tooltip w-full"
              data-tip="DnDBeyond Link"
            >
              <font-awesome-icon :icon="['fas', 'arrow-up-right-from-square']" />
            </button>
          </a>
        </div>
      </div>
      <div
        v-else
        class="card-body group"
      >
        <div class="group-hover:absolute group-hover:flex gap-1 hidden top-2 right-2">
          <button
            class="btn btn-xs btn-square"
            @click="clickUpdateDeletedCharacterModal(character)"
          >
            <font-awesome-icon :icon="['fas', 'arrow-rotate-left']" />
          </button>
          <button
            class="btn btn-xs btn-error btn-square"
            @click="clickDestroyDeletedCharacterModal(character)"
          >
            <font-awesome-icon :icon="['fas', 'x']" />
          </button>
        </div>
        <h3 class="card-title capitalize">
          <span class="break-all"><span
            v-if="character.deleted_at"
            class="text-error"
          >(Deleted) </span>{{ character.name }}</span>
          <font-awesome-icon
            :icon="['fas', 'plus']"
            size="2xs"
            class="-mr-1.5"
          />
          <font-awesome-icon
            :icon="['fas', '1']"
            size="sm"
          />
        </h3>
        <div class="flex justify-between">
          <p class="text-xs">
            Level 3
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
        <div class="mt-3 text-xs grid grid-cols-2 gap-y-1 [&>*:nth-child(even)]:text-right">
          <div>
            <p>
              <font-awesome-icon
                :icon="['fas', 'plus']"
                size="2xs"
              />
              <font-awesome-icon
                :icon="['fas', '1']"
                size="sm"
              />
              Filler character
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
            class="btn btn-sm tooltip"
            data-tip="Add adventure"
            @click="clickCreateAdventureModal(character.id)"
          >
            <font-awesome-icon :icon="['fas', 'compass']" />
          </button>
          <button
            class="btn btn-sm tooltip"
            data-tip="Show allies"
            @click="clickAllyModal(character)"
          >
            <font-awesome-icon :icon="['fas', 'sitemap']" />
          </button>
          <a

            :href="character.external_link"
            target="_blank"
          >
            <button
              class="btn btn-sm tooltip"
              data-tip="DnDBeyond Link"
            >
              <font-awesome-icon :icon="['fas', 'arrow-up-right-from-square']" />
            </button>
          </a>
        </div>
      </div>
    </div>
  </div>
  <AllyModal
    v-if="currentCharacter"
    ref="allyModal"
    :key="allyModalKey"
    :character="currentCharacter"
    @update-key="currentCharacter = (characters.find(c => c.id === currentCharacter?.id) ?? currentCharacter)"
  />
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
  <UpdateDeletedCharacterModal
    v-if="currentCharacter"
    ref="updateDeletedCharacterModal"
    :key="updateDeletedCharacterModalKey"
    :character="currentCharacter"
  />
  <DestroyCharacterModal
    v-if="currentCharacter"
    ref="destroyCharacterModal"
    :key="destroyCharacterModalKey"
    :character="currentCharacter"
  />
  <DestroyDeletedCharacterModal
    v-if="currentCharacter"
    ref="destroyDeletedCharacterModal"
    :key="destroyDeletedCharacterModalKey"
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
