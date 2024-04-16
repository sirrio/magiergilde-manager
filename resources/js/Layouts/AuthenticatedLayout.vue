<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
</script>

<template>
    <div>
        <div class="min-h-screen bg-base-300">
            <div class="navbar bg-base-100">
                <div class="flex-1">
                    <a :href="route('dashboard')" class="btn btn-ghost text-xl">
                        <ApplicationLogo class="h-10 fill-current" />
                        <span>Character manager</span>
                    </a>
                </div>
                <div class="flex-none">
                    <div class="dropdown dropdown-end">
                        <span class="mr-3">{{ $page.props.auth.user.name }}</span>
                        <div tabindex="0" role="button" class="btn btn-neutral btn-circle">
                            <div class="w-10 rounded-full text-base-content">
                                <font-awesome-icon :icon="['far', 'user']" size="xl"/>
                            </div>
                        </div>
                        <ul tabindex="0"
                            class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                            <li><a :href="route('profile.edit')">Profile</a></li>
                            <li>
                                <Link :href="route('logout')" method="post" as="button">Logout</Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main>
                <slot/>
            </main>
        </div>
    </div>
</template>
