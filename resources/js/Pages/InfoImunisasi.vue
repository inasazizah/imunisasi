<template>
    <app-layout>
        <template #header>
            <h2 class="font-bold text-xl text-center text-gray-800 leading-tight">
                Detail Imunisasi
            </h2>
        </template>
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-2">
            <div v-for="imunisasi in imunisasis" :key="imunisasi.id" class="lg:m-4 shadow-md rounded-lg bg-white my-12 mx-8">
                <!-- Card Content -->
                <div class="p-4">
                <h3 class="font-bold text-gray-600 text-lg my-2 uppercase">{{ imunisasi.jenis }}</h3>
                <p class="text-justify">{{ imunisasi.deskripsi }}</p>
                <div class="mt-5">
                    <inertia-link :href="route('detail', {id: imunisasi.id})" class="hover:bg-indigo-700 rounded-full py-2 px-3 font-semibold hover:text-white bg-indigo-500 text-gray-100">Baca Lebih Lanjut</inertia-link>
                </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import JetButton from '@/Jetstream/Button'
    import { format, differenceInMonths } from 'date-fns'
    import { id } from 'date-fns/locale'

    export default {
        components: {
            AppLayout,
            Welcome,
            JetButton,
        },
        props: ['imunisasis'],
        methods: {
            formatDate(date) {
                const tgl = new Date(date)
                return format(tgl, "d MMMM yyyy", {
                        locale: id
                    })
            } 
        },
    }
</script>