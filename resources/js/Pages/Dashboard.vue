<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import {Character} from "@/types";

const props = defineProps<{
    characters: Character
}>()

console.log(props.characters)

const clickCreateNewCharacter = () => {
    router.visit(route('character.create'))
}
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>

        <div>
            <button @click="clickCreateNewCharacter" class="btn">Create new character</button>
        </div>

        <div v-for="(character, key) of characters" :key="key">1{{ character}}</div>
    </AuthenticatedLayout>
</template>
