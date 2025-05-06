<template>
    <div class=" bg-gray-100 min-h-screen overflow-hidden position-relative">
        <header
            class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6 px-4 py-3 bg-white shadow rounded-lg">
            <Link href="/" class="text-2xl font-bold text-green-600 tracking-tight">BooVilla</Link>

            <div class="w-full sm:max-w-sm flex items-center">
                <input type="text" placeholder="Search villas..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-green-500" />
                <button class="bg-green-600 text-white px-4 py-2 rounded-r-md hover:bg-green-700 transition">
                    🔍
                </button>
            </div>
            <div class="flex space-x-4" v-if="$page.props.auth.user == null">
                <Link href="/login"
                    class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition flex items-center gap-2">
                <span>Login</span>
                </Link>
                <Link href="/register"
                    class="border-green-600 border px-4 py-2 rounded-md  transition flex items-center gap-2">
                <span>Register</span>
                </Link>
            </div>
            <div v-else class="flex gap-2">
                <Link href="/dashboard"
                    class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition flex items-center gap-2"
                    v-if="$page.props.auth.user.is_admin">
                <span>Dashboard</span>
                </Link>
                <button @click="logout"
                    class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition flex items-center gap-2">
                    <span>Logout</span>
                </button>
            </div>
        </header>

        <div class="flex justify-center items-center mt-16">
            <div class="w-full container overflow-visible relative">
                <slot />
            </div>
        </div>

        <footer class="bg-gray-800 text-white py-8 mt-20">
            <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-3 gap-8 text-sm">
                <div>
                    <h3 class="text-lg font-semibold mb-3">BooVilla</h3>
                    <p class="text-gray-400">
                        Temukan villa impianmu di seluruh Indonesia. Booking mudah, cepat, dan aman bersama BooVilla.
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-3">Quick Links</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white transition">Home</a></li>
                        <li><a href="#" class="hover:text-white transition">Villas</a></li>
                        <li><a href="#" class="hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-3">Contact</h3>
                    <ul class="text-gray-300 space-y-2">
                        <li>Email: support@boovilla.com</li>
                        <li>Phone: +62 896 6193 6381</li>
                        <li>Address: Jl. Ranco No.23, Jakarta</li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 border-t border-gray-700 pt-4 text-center text-gray-500 text-sm">
                © {{ new Date().getFullYear() }} BooVilla. All rights reserved.
            </div>
        </footer>
    </div>

</template>


<script setup>
import { Link, router } from '@inertiajs/vue3'

const logout = () => {
    router.post(route('logout'));
};
</script>
