<script setup lang="ts">
import CreateGameModal from '@/Modals/Game/CreateGameModal.vue'
import { nextTick, Ref, ref } from 'vue'
import { Character, Game } from '@/types'
import { calculateBubbleByFillerCharacters, calculateBubbleByGames } from '@/helpers/calculateBubble'
import { calculateCoins } from '@/helpers/calculateCoins'
import { calculateBubbleSpend } from '@/helpers/calculateBubbleSpend'
import { calculateCoinsSpend } from '@/helpers/calculateCoinsSpend'
import UpdateGameModal from '@/Modals/Game/UpdateGameModal.vue'
import DestroyGameModal from '@/Modals/Game/DestroyGameModal.vue'
import TierLogo from '@/Components/TierLogo.vue'

defineProps<{
  games: Game[]
  characters: Character[]
}>()

const createGameModal = ref()
const updateGameModal = ref()
const updateGameModalKey = ref('updateGameModalKey-1')
const destroyGameModal = ref()
const destroyGameModalKey = ref('destroyGameModalKey-1')
const currentGame: Ref<Game | null> = ref(null)

const clickCreateGameModal = () => {
  createGameModal.value.showModal()
}

const clickUpdateGameModal = async (game: Game) => {
  currentGame.value = game
  updateGameModalKey.value = 'updateGameModalKey-' + Math.random()
  await nextTick()
  updateGameModal.value.showModal()
}

const clickDestroyGameModal = async (game: Game) => {
  currentGame.value = game
  destroyGameModalKey.value = 'destroyGameModalKey-' + Math.random()
  await nextTick()
  destroyGameModal.value.showModal()
}
</script>

<template>
  <div class="flex justify-between items-center mb-6">
    <div>
      <h2 class="text-2xl font-bold">
        Your mastered games
      </h2>
      <p class="text-xs hidden sm:block">
        Manage the games in which you were the Game Master.
      </p>
    </div>
    <div>
      <button
        class="btn btn-neutral"
        @click="clickCreateGameModal()"
      >
        <font-awesome-icon :icon="['fas', 'plus']" />
        <span class="hidden sm:inline">Create new game</span>
      </button>
    </div>
  </div>
  <div
    v-if="games.length === 0 && calculateBubbleByFillerCharacters(characters) === 0"
    class="card bg-base-100 text-base-content"
  >
    <div class="card-body text-center">
      <font-awesome-icon
        :icon="['fas', 'circle-exclamation']"
        size="7x"
      />
      <h3 class="font-semibold text-xl">
        No games in which you were the Game Master or games played with a filler character yet
      </h3>
    </div>
  </div>
  <div
    v-else
    class="grid sm:grid-cols-2 gap-12 mt-3"
  >
    <div>
      <div class="card md:card-side bg-base-100">
        <figure class="md:w-1/2 ">
          <img
            class="object-cover h-full w-full"
            src="/images/gamemaster.jpg"
            alt="Game Master"
          >
        </figure>
        <div class="card-body">
          <h3 class="card-title">
            <font-awesome-icon
              :icon="['fas', 'droplet']"
              size="sm"
            />
            {{ calculateBubbleByGames(games) + calculateBubbleByFillerCharacters(characters) - calculateBubbleSpend(characters) }} Bubbles
          </h3>
          <progress
            class="progress progress-accent w-full"
            :value="calculateBubbleSpend(characters)"
            :max="calculateBubbleByGames(games)"
          />
          <div class="text-xs text-right -mt-1">
            Spend
            {{ calculateBubbleSpend(characters) }}
            of your {{ calculateBubbleByGames(games) + calculateBubbleByFillerCharacters(characters) }}
            <font-awesome-icon
              :icon="['fas', 'droplet']"
              size="sm"
              fixed-width
            />
          </div>
          <p
            v-if="calculateBubbleSpend(characters) > calculateBubbleByGames(games) + calculateBubbleByFillerCharacters(characters)"
            class="text-xs text-error"
          >
            <font-awesome-icon
              :icon="['fas', 'exclamation-circle']"
              size="sm"
              fixed-width
            />
            You spend more bubbles then you got
          </p>
          <h3 class="card-title">
            <font-awesome-icon
              :icon="['fas', 'coins']"
              size="sm"
            />
            {{ calculateCoins(games) - calculateCoinsSpend(characters) }} Coins
          </h3>
          <progress
            class="progress progress-accent w-full"
            :value="calculateCoinsSpend(characters)"
            :max="calculateCoins(games)"
          />
          <div class="text-xs text-right -mt-1">
            Spend
            {{ calculateCoinsSpend(characters) }}
            of your {{ calculateCoins(games) }}
            <font-awesome-icon
              :icon="['fas', 'coins']"
              size="sm"
              fixed-width
            />
          </div>
          <p
            v-if="calculateCoinsSpend(characters) > calculateCoins(games)"
            class="text-xs text-error"
          >
            <font-awesome-icon
              :icon="['fas', 'exclamation-circle']"
              size="sm"
              fixed-width
            />
            You spend more coins then you got
          </p>
          <h3 class="card-title">
            Other
          </h3>
          <p>
            You mastered a total of {{ games.length }} games.
          </p>
          <p>
            You gained a total of {{ calculateBubbleByFillerCharacters(characters) }}
            <font-awesome-icon
              :icon="['fas', 'droplet']"
              size="sm"
            />
            from your filler characters.
          </p>
        </div>
      </div>
    </div>
    <div class="flex flex-col gap-3">
      <div
        v-for="(game, key) of games"
        :key="key"
        class="card card-compact bg-base-100 text-base-content group"
      >
        <div
          tabindex="0"
          class="card-body collapse cursor-pointer"
        >
          <div class="group-hover:absolute group-hover:flex gap-1 hidden top-2 right-2">
            <button
              class="btn btn-xs btn-square"
              @click="clickUpdateGameModal(game)"
            >
              <font-awesome-icon :icon="['fas', 'gear']" />
            </button>
            <button
              class="btn btn-xs btn-error btn-square"
              @click="clickDestroyGameModal(game)"
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
                {{ game.title ?? "Game" }}
                <font-awesome-icon
                  v-if="game.notes"
                  :icon="['fas', 'note-sticky']"
                  fixed-width
                  size="xs"
                />
              </h3>
              <TierLogo
                :size="20"
                :tier="game.tier"
              />
            </div>
            <span class="text-xs" />
          </div>
          <div class="flex justify-between text-xs">
            <p>
              <font-awesome-icon
                :icon="['fas', 'clock']"
              />
              You gained
              {{ calculateBubbleByGames([game]) }}
              <span v-if="game.has_additional_bubble">(Character Quest)</span>
              <font-awesome-icon
                :icon="['fas', 'droplet']"
                size="xs"
                fixed-width
              />
              and
              {{ calculateCoins([game]) }}
              <font-awesome-icon
                :icon="['fas', 'coins']"
                size="xs"
                fixed-width
              />
              in {{ Math.floor(game.duration / 3600) }}h {{ (game.duration / 60) % 60 }}min
              and {{ game.sessions }} sessions
            </p>
            <p class="italic text-right">
              <font-awesome-icon
                :icon="['fas', 'calendar']"
              />
              {{ new Date(game.start_date).toLocaleDateString() }}
            </p>
          </div>
          <div class="collapse-content">
            <p
              v-if="game.notes"
              class="whitespace-pre-wrap "
            >
              {{ game.notes }}
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
  </div>
  <CreateGameModal
    ref="createGameModal"
  />
  <UpdateGameModal
    v-if="currentGame"
    ref="updateGameModal"
    :key="updateGameModalKey"
    :game="currentGame"
  />
  <DestroyGameModal
    v-if="currentGame"
    ref="destroyGameModal"
    :key="destroyGameModalKey"
    :game="currentGame"
  />
</template>
