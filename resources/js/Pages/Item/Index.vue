<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { Item } from '../../Types'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import UpdateItemModal from '@/Modals/Item/UpdateItemModal.vue'
import CreateItemModal from '@/Modals/Item/CreateItemModal.vue'
import { nextTick, ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'


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

const itemsByRarity: Record<string, Record<string, Item[]>> = items.reduce((result, item) => {
  if (!result[item.rarity]) {
    result[item.rarity] = {}
  }
  if (!result[item.rarity][item.type]) {
    result[item.rarity][item.type] = []
  }
  result[item.rarity][item.type].push(item)

  return result
}, {} as Record<string, Record<string, Item[]>>)
</script>

<template>
  <Head title="Items" />

  <AuthenticatedLayout>
    <div class="py-6 px-6">
      <div class="max-w-9xl mx-auto">
        <div
          v-if="$page.props.auth.user.is_admin"
          class="btn btn-neutral mb-6"
          @click="clickCreateItemModal"
        >
          <font-awesome-icon icon="plus" />
          <span>Add new item</span>
        </div>
        <div class="grid md:grid-cols-4 gap-3">
          <div
            v-for="(itemsByType, rarity) in itemsByRarity"
            :key="rarity"
            class="bg-base-100 rounded-xl"
          >
            <h2 class="text-lg font-bold capitalize flex justify-center sticky top-0 z-20 bg-base-100 rounded-t-xl">
              {{ rarity.replace("_", " ") }}
            </h2>
            <div
              class="grid gap-1 px-1 grid-cols-[35px_1fr_30px_100px_20px] font-bold uppercase sticky z-20 bg-base-100 top-6"
            >
              <div>id</div>
              <div>name</div>
              <div>url</div>
              <div>cost</div>
            </div>
            <div
              v-for="(itemSorted, type) in itemsByType"
              :key="type"
            >
              <div
                class="grid gap-1 grid-cols-[35px_1fr_30px_100px_20px] bg-neutral text-neutral-content sticky top-12"
              >
                <div class="p-2 font-bold uppercase text-sm tracking-widest col-span-5 flex justify-center">
                  {{ type }}
                </div>
              </div>
              <div
                v-for="item in itemSorted"
                :key="item.id"
                class="grid px-1 gap-1 grid-cols-[35px_1fr_30px_100px_20px] odd:bg-base-200"
                :class="{'text-error': !item.url || !item.cost}"
              >
                <div>
                  {{ item.id }}
                </div>
                <div class="truncate">
                  {{ item.name }}
                </div>
                <div class="truncate">
                  <a
                    v-if="item.url"
                    :href="item.url"
                    target="_blank"
                    class="link"
                  >
                    Link
                  </a>
                  <template v-else>
                    -
                  </template>
                </div>
                <div class="truncate">
                  {{ item.cost }}
                </div>
                <div
                  v-if="$page.props.auth.user.is_admin"
                  class="text-base-content/30 hover:text-base-content/70 cursor-pointer flex justify-center items-center"
                  @click="clickUpdateItemModal(item)"
                >
                  <font-awesome-icon
                    icon="feather"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
  <UpdateItemModal
    v-if="currentItem"
    :key="updateItemModalKey"
    ref="updateItemModal"
    :item="currentItem"
  />
  <CreateItemModal ref="createItemModal" />
</template>
