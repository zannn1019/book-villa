<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    villa: Object
})

const form = useForm({
    name: props.villa.name,
    description: props.villa.description,
    price_per_night: props.villa.price_per_night,
    location: props.villa.location,
    capacity: props.villa.capacity,
    image: props.villa.image,
})

const submit = () => {
    form.put(route('villa.update', props.villa.id))
}
</script>

<template>
    <AppLayout title="Edit Villa">

        <Head title="Edit Villa" />

        <div class="max-w-2xl mx-auto py-10">
            <h2 class="text-2xl font-semibold mb-6">Edit Villa</h2>

            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label class="block mb-1">Name</label>
                    <input v-model="form.name" type="text" class="w-full border p-2 rounded" />
                </div>

                <div>
                    <label class="block mb-1">Description</label>
                    <textarea v-model="form.description" class="w-full border p-2 rounded"></textarea>
                </div>

                <div>
                    <label class="block mb-1">Location</label>
                    <input v-model="form.location" type="text" class="w-full border p-2 rounded" />
                </div>

                <div>
                    <label class="block mb-1">Price per night</label>
                    <input v-model="form.price_per_night" type="number" class="w-full border p-2 rounded" />
                </div>

                <div>
                    <label class="block mb-1">Capacity</label>
                    <input v-model="form.capacity" type="number" class="w-full border p-2 rounded" />
                </div>

                <div>
                    <label class="block mb-1">Image URL</label>
                    <input v-model="form.image" type="text" class="w-full border p-2 rounded" />
                </div>

                <div>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Update Villa
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
