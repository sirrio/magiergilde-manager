<script setup lang="ts">
import TierLogo from '@/Components/TierLogo.vue'
import { User } from '@/Types'
import { InertiaForm, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps<{
  user: User
}>()

const form: InertiaForm<{
  event_bubbles: number
  event_coins: number
  bt_bubbles: number
  bt_coins: number
  lt_bubbles: number
  lt_coins: number
  ht_bubbles: number
  ht_coins: number
  et_bubbles: number
  et_coins: number
  other_bubbles: number
  other_coins: number
}> = useForm({
  event_bubbles: props.user.event_bubbles,
  event_coins: props.user.event_coins,
  bt_bubbles: props.user.bt_bubbles,
  bt_coins: props.user.bt_coins,
  lt_bubbles: props.user.lt_bubbles,
  lt_coins: props.user.lt_coins,
  ht_bubbles: props.user.ht_bubbles,
  ht_coins: props.user.ht_coins,
  et_bubbles: props.user.et_bubbles,
  et_coins: props.user.et_coins,
  other_bubbles: props.user.other_bubbles,
  other_coins: props.user.other_coins,
})

const modalBreakdownUpdate = ref()

const showModal = () => {
  modalBreakdownUpdate.value.showModal()
}

const clickUpdateBreakdown = () => {
  form.patch(route('breakdown.update', { user: props.user }), {
    preserveState: false,
  })
}

defineExpose({
  showModal,
})
</script>

<template>
  <dialog ref="modalBreakdownUpdate" class="modal">
    <div class="modal-box">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute top-2 right-2">✕</button>
      </form>
      <h3 class="mb-6 text-lg font-bold">Update your coins and bubbles</h3>

      <div class="flex gap-2">
        <label class="form-control mb-2 w-full">
          <div class="label">
            <span class="label-text">Event Bubble</span>
          </div>
          <input v-model="form.event_bubbles" type="number" min="0" placeholder="0" class="input" />
        </label>

        <label class="form-control mb-2 w-full">
          <div class="label">
            <span class="label-text">Event Coins</span>
          </div>
          <input v-model="form.event_coins" type="number" min="0" placeholder="0" class="input" />
        </label>
      </div>

      <div class="flex gap-2">
        <label class="form-control mb-2 w-full">
          <div class="label">
            <span class="label-text"><tier-logo tier="bt" :size="14" /> Bubble</span>
          </div>
          <input v-model="form.bt_bubbles" type="number" min="0" placeholder="0" class="input" />
        </label>

        <label class="form-control mb-2 w-full">
          <div class="label">
            <span class="label-text"><tier-logo tier="bt" :size="14" /> Coins</span>
          </div>
          <input v-model="form.bt_coins" type="number" min="0" placeholder="0" class="input" />
        </label>
      </div>

      <div class="flex gap-2">
        <label class="form-control mb-2 w-full">
          <div class="label">
            <span class="label-text"><tier-logo tier="lt" :size="14" /> Bubble</span>
          </div>
          <input v-model="form.lt_bubbles" type="number" min="0" placeholder="0" class="input" />
        </label>

        <label class="form-control mb-2 w-full">
          <div class="label">
            <span class="label-text"><tier-logo tier="lt" :size="14" /> Coins</span>
          </div>
          <input v-model="form.lt_coins" type="number" min="0" placeholder="0" class="input" />
        </label>
      </div>

      <div class="flex gap-2">
        <label class="form-control mb-2 w-full">
          <div class="label">
            <span class="label-text"><tier-logo tier="ht" :size="14" /> Bubble</span>
          </div>
          <input v-model="form.ht_bubbles" type="number" min="0" placeholder="0" class="input" />
        </label>

        <label class="form-control mb-2 w-full">
          <div class="label">
            <span class="label-text"><tier-logo tier="ht" :size="14" /> Coins</span>
          </div>
          <input v-model="form.ht_coins" type="number" min="0" placeholder="0" class="input" />
        </label>
      </div>

      <div class="flex gap-2">
        <label class="form-control mb-2 w-full">
          <div class="label">
            <span class="label-text"><tier-logo tier="et" :size="14" /> Bubble</span>
          </div>
          <input v-model="form.et_bubbles" type="number" min="0" placeholder="0" class="input" />
        </label>

        <label class="form-control mb-2 w-full">
          <div class="label">
            <span class="label-text"><tier-logo tier="et" :size="14" /> Coins</span>
          </div>
          <input v-model="form.et_coins" type="number" min="0" placeholder="0" class="input" />
        </label>
      </div>

      <div class="flex gap-2">
        <label class="form-control mb-2 w-full">
          <div class="label">
            <span class="label-text">Other Bubble</span>
          </div>
          <input v-model="form.other_bubbles" type="number" min="0" placeholder="0" class="input" />
        </label>

        <label class="form-control mb-2 w-full">
          <div class="label">
            <span class="label-text">Other Coins</span>
          </div>
          <input v-model="form.other_coins" type="number" min="0" placeholder="0" class="input" />
        </label>
      </div>

      <button class="btn btn-neutral mt-6" @click="clickUpdateBreakdown()">Update</button>
    </div>
  </dialog>
</template>
