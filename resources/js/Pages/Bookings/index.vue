<template>
    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-800 mb-8">Your Booking History</h2>

            <div v-if="bookings.length" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-2">
                <div v-for="booking in bookings" :key="booking.id"
                    class="bg-white shadow-md rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="flex flex-col sm:flex-row">
                        <img :src="booking.villa.image" alt="Villa Image" class="h-48 sm:h-auto sm:w-48 object-cover" />
                        <div class="p-5 flex flex-col justify-between flex-1">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">{{ booking.villa.name }}</h3>
                                <p class="text-gray-500 mb-2">{{ booking.villa.location }}</p>
                                <p class="text-sm text-gray-500 mb-1">
                                    Booked on: {{ formatDate(booking.created_at) }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    Nights: <strong>{{ booking.nights }}</strong>
                                    &nbsp;|&nbsp;
                                    Total: <strong class="text-green-600">Rp {{ formatCurrency(booking.total_price)
                                        }}</strong>
                                </p>
                            </div>
                            <div class="mt-4">
                                <a :href="`/detail/${booking.villa.id}`" class="text-blue-600 hover:underline text-sm">
                                    View Villa →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="text-gray-500 text-center mt-12">
                You haven't made any bookings yet.
            </div>
        </div>
    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/DefaultLayout.vue'

defineOptions({
    layout: AppLayout
})

const bookings = usePage().props.bookings || []

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' }
    return new Date(dateString).toLocaleDateString('id-ID', options)
}

const formatCurrency = (value) => {
    return value.toLocaleString('id-ID')
}
</script>
