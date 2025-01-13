<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});


</script>

<template>
    <Head title="Welcome" />
    <GuestLayout >
    <div class="bg-gray-50 text-black/50 text-gray-800">
     
        <div
            class="relative flex flex-col"
        >
        <h2 class="self-center p-6 text-3xl text-center">Welcome to Cherp'n'Derp!</h2>
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <h2 class="text-center p-2 text-xl" v-if="$page.props.auth.user">Welcome back, you're already authorized</h2>
                <header
                    class="flex"
                >
                   
                    <nav v-if="canLogin" class=" flex flex-1 justify-center gap-3">
                      
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="px-3 py-2"
                        >
                          Let's see the dashboard
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class=" px-3 py-2"
                            >
                                Log in
                            </Link>
                            <p class="py-2">or</p>
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class=" px-3 py-2"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
                </header>
            </div>
        </div>
        <footer
            class="py-16 text-center text-sm text-black"
        >
            @copywrite v.1.1 2025 derpiecorp 
        </footer>
    </div>
</GuestLayout>
</template>
