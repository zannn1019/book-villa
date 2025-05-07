<template>

    <Head title="Detail" />
    <div class="max-w-6xl mx-auto p-6 sm:p-10 bg-white shadow-lg rounded-2xl">
        <div class="relative mb-8">
            <img :src="villa.image" alt="Villa Image" class="w-full h-80 sm:h-[500px] object-cover rounded-xl" />
        </div>

        <div class="mb-8 space-y-4">
            <h1 class="text-3xl sm:text-5xl font-bold text-gray-800">{{ villa.name }}</h1>
            <div class="py-1 rounded-lg text-2xl">
                Rp {{ formatCurrency(villa.price_per_night) }} <span class="text-xs">/ night</span>
            </div>

            <div class="flex flex-wrap gap-6 text-gray-600 text-lg">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ villa.location }}
                </div>

                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2 7-7 7 7 2 2v10a1 1 0 01-1 1h-3a1 1 0 01-1-1v-4a1 1 0 00-1-1h-2a1 1 0 00-1 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V12z" />
                    </svg>
                    {{ villa.capacity }} Guests
                </div>
            </div>

            <p class="text-gray-700 leading-relaxed text-base sm:text-lg">
                {{ villa.description }}
            </p>
        </div>

        <div class="mb-8  grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="check_in">Check-in Date</label>
                <input v-model="form.check_in" type="date" id="check_in" class="border rounded-lg px-4 py-2 w-full" />
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="check_out">Check-out Date</label>
                <input v-model="form.check_out" type="date" id="check_out" class="border rounded-lg px-4 py-2 w-full" />
            </div>
        </div>

        <div v-if="successMessage" class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
            {{ successMessage }}
        </div>

        <div class="flex flex-col sm:flex-row gap-4">
            <button @click="bookVilla"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg shadow text-lg w-full sm:w-auto">
                Book Now
            </button>
        </div>
    </div>
</template>

<script setup>
import { usePage, Head, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/DefaultLayout.vue'
import { reactive, ref } from 'vue'

defineOptions({
    layout: AppLayout
})

const villa = usePage().props.villa

const formatCurrency = (number) => {
    return number.toLocaleString('id-ID')
}

const form = reactive({
    villa_id: villa.id,
    check_in: null,
    check_out: null
})

const successMessage = ref(null)

function bookVilla() {
    if (!form.check_in || !form.check_out) {
        alert("Please select both check-in and check-out dates.")
        return
    }
    router.post("/book", form, {
        onSuccess: () => {
            successMessage.value = "Booking successful! Enjoy your stay."
            setTimeout(() => successMessage.value = null, 5000)
        }
    })
}
</script>
