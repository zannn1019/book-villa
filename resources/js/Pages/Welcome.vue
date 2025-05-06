<template>

    <Head title="Welcome" />
    <swiper v-if="villas.length > 0" :modules="[Pagination, Navigation]" :slides-per-view="1.5" :space-between="24"
        :centered-slides="true" :loop="true" :pagination="{ clickable: true }" navigation class="pb-16"
        @slideChange="onSlideChange" @swiper="onSwiperInit">
        <swiper-slide v-for="(villa, index) in villas" :key="index"
            class="bg-white rounded-xl shadow-lg p-6 transition-all duration-300 ease-in-out transform">
            <div class="h-96 mb-10 rounded-lg overflow-hidden">
                <img :src="villa.image" :alt="villa.name" class="w-full h-full object-cover" />
            </div>
        </swiper-slide>
    </swiper>
    <div v-else class="text-center py-16 text-xl text-gray-500">
        Belum ada villa yang tersedia saat ini.
    </div>
    <div v-if="activeVilla" class="mt-16 bg-white p-8 rounded-xl shadow-lg max-w-3xl mx-auto">
        <div class="p-6">
            <h3 class="text-4xl font-bold mb-2">{{ activeVilla.name }}</h3>

            <div class="flex items-center text-villa-500 text-lg mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text- mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>{{ activeVilla.location }}</span>
            </div>

            <div class="flex items-center text-villa-600 text-lg mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>{{ activeVilla.capacity }} People</span>
            </div>

            <hr class="my-6 border-t border-gray-200" />

            <div class="flex justify-between items-center mb-6">
                <span class="text-2xl font-semibold text-luxury-navy">
                    Rp {{ formatCurrency(activeVilla.price_per_night) }}
                    <span class="text-sm text-villa-500">/ night</span>
                </span>

            </div>
            <Link :href="'/detail/' + activeVilla.id"
                class="text-sm font-medium border-green-500 px-5 py-3 border text-green-500 hover:text-luxury-navy transition-colors">
            View Details →
            </Link>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Pagination, Navigation } from 'swiper/modules'
import 'swiper/css'
import 'swiper/css/pagination'
import 'swiper/css/navigation'
import AppLayout from '@/Layouts/DefaultLayout.vue'
import axios from 'axios'

defineOptions({
    layout: AppLayout
})
const page = usePage()

const villas = computed(() => page.props.villas)

const activeVillaIndex = ref(0)
const swiperInstance = ref(null)

const onSwiperInit = (swiper) => {
    swiperInstance.value = swiper
    updateActiveIndex(swiper.realIndex)
}

const onSlideChange = () => {
    if (swiperInstance.value) {
        updateActiveIndex(swiperInstance.value.realIndex)
    }
}

const updateActiveIndex = (index) => {
    activeVillaIndex.value = index

}

const activeVilla = computed(() => {
    const list = villas.value
    if (!list || list.length === 0) return null

    const index = activeVillaIndex.value % list.length
    return list[index]
})

const formatCurrency = (number) => {
    return number.toLocaleString('id-ID')
}
</script>
