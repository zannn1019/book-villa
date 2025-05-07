<script setup>
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    villas: Array
})

const editVilla = (id) => {
    router.visit(`/villa/${id}/edit`)
}

const deleteVilla = (id) => {
    if (confirm('Are you sure you want to delete this villa?')) {
        router.delete(`/villa/${id}`)
    }
}
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Manage Villas</h1>
                    <a href="/villa/create"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                        + Add Villa
                    </a>
                </div>

                <div class="bg-white shadow rounded-lg overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Name</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Location</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Capacity</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Price/Night</th>
                                <th class="px-6 py-3 text-right text-sm font-medium text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="villa in villas.data" :key="villa.id">
                                <td class="px-6 py-4">{{ villa.name }}</td>
                                <td class="px-6 py-4">{{ villa.location }}</td>
                                <td class="px-6 py-4">{{ villa.capacity }}</td>
                                <td class="px-6 py-4">Rp {{ villa.price_per_night.toLocaleString('id-ID') }}</td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <button @click="editVilla(villa.id)"
                                        class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">
                                        Edit
                                    </button>
                                    <button @click="deleteVilla(villa.id)"
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="!villas.data.length">
                                <td colspan="5" class="text-center px-6 py-4 text-gray-500">No villas available.</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="px-6 py-4 flex justify-end space-x-2">
                        <button v-for="(link, i) in villas.links" :key="i" :disabled="!link.url"
                            @click="router.visit(link.url)" v-html="link.label" class="px-3 py-1 rounded text-sm"
                            :class="[
                                link.active ? 'bg-green-600 text-white' : 'text-gray-700 hover:bg-gray-200',
                                !link.url ? 'opacity-50 cursor-not-allowed' : ''
                            ]" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
