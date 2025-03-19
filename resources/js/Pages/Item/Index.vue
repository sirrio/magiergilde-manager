<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import CreateItemModal from '@/Modals/Item/CreateItemModal.vue'
import UpdateItemModal from '@/Modals/Item/UpdateItemModal.vue'
import { Item } from '@/Types'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { Head, usePage } from '@inertiajs/vue3'
import { nextTick, ref } from 'vue'

const { items } = defineProps<{
  items: Item[]
}>()

const currentItem = ref()
const updateItemModal = ref()
const updateItemModalKey = ref('updateCharacterModalKey-1')

const createItemModal = ref()

const clickCreateItemModal = async () => {
  createItemModal.value.showModal()
}

const clickUpdateItemModal = async (item: Item) => {
  currentItem.value = item
  updateItemModalKey.value = 'updateItemModalKey-' + Math.random()
  await nextTick()
  updateItemModal.value.showModal()
}

const itemsByRarity: Record<string, Record<string, Item[]>> = items.reduce(
  (result, item) => {
    if (!result[item.rarity]) {
      result[item.rarity] = {}
    }
    if (!result[item.rarity][item.type]) {
      result[item.rarity][item.type] = []
    }
    result[item.rarity][item.type].push(item)

    return result
  },
  {} as Record<string, Record<string, Item[]>>,
)

const page = usePage()
</script>

<template>
  <Head title="Items" />

  <AuthenticatedLayout>
    <div class="px-6 py-6">
      <div class="max-w-9xl mx-auto">
        <div v-if="page.props.auth.user.is_admin" class="btn btn-neutral mb-6" @click="clickCreateItemModal">
          <font-awesome-icon icon="plus" />
          <span>Add new item</span>
        </div>
        <div class="grid gap-3 md:grid-cols-4">
          <div v-for="(itemsByType, rarity) in itemsByRarity" :key="rarity" class="bg-base-100 rounded-xl">
            <h2 class="bg-base-100 sticky top-0 z-20 flex justify-center rounded-t-xl text-lg font-bold capitalize">
              {{ rarity.replace('_', ' ') }}
            </h2>
            <div class="bg-base-100 sticky top-6 z-20 grid grid-cols-[35px_1fr_30px_100px_20px] gap-1 px-1 font-bold uppercase">
              <div>id</div>
              <div>name</div>
              <div>url</div>
              <div>cost</div>
            </div>
            <div v-for="(itemSorted, type) in itemsByType" :key="type">
              <div class="bg-neutral text-neutral-content sticky top-12 grid grid-cols-[35px_1fr_30px_100px_20px] gap-1">
                <div class="col-span-5 flex justify-center p-2 text-sm font-bold tracking-widest uppercase">
                  {{ type }}
                </div>
              </div>
              <div
                v-for="item in itemSorted"
                :key="item.id"
                class="odd:bg-base-200 grid grid-cols-[35px_1fr_30px_100px_20px] gap-1 px-1"
                :class="{ 'text-error': !item.url || !item.cost }"
              >
                <div>
                  {{ item.id }}
                </div>
                <div class="truncate">
                  {{ item.name }}
                </div>
                <div class="truncate">
                  <a v-if="item.url" :href="item.url" target="_blank" class="link"> Link </a>
                  <template v-else> - </template>
                </div>
                <div class="truncate">
                  {{ item.cost }}
                </div>
                <div
                  v-if="page.props.auth.user.is_admin"
                  class="text-base-content/30 hover:text-base-content/70 flex cursor-pointer items-center justify-center"
                  @click="clickUpdateItemModal(item)"
                >
                  <font-awesome-icon icon="feather" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
  <UpdateItemModal v-if="currentItem" :key="updateItemModalKey" ref="updateItemModal" :item="currentItem" />
  <CreateItemModal ref="createItemModal" />
</template>
