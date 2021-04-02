<template>
    <app-layout>
        <template #header>
            <h2 class="font-bold text-xl text-center text-gray-800 leading-tight">
                Imunisasi Selanjutnya
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 max-w-4xl mx-auto">
                        <div class="flex flex-col sm:flex-row justify-between">
                            <div class="my-1">
                                <p class="text-xs font-semibold">Nama</p>
                                <p>{{ baby.nama }}</p>
                            </div>
                            <div class="my-1">
                                <p class="text-xs font-semibold">Tanggal Lahir</p>
                                <p>{{ baby.ttl }}</p>
                            </div>
                            <div class="my-1">
                                <p class="text-xs font-semibold">Usia</p>
                                <p>{{ displayAge }}</p>
                            </div>
                        </div>
                        <div class="max-w-2xl mx-auto">
                            <table class="min-w-full leading-normal mt-10">
                                <thead>
                                    <tr>
                                        <th class="px-3 py-3">No</th>
                                        <th class="px-2 py-3">Jenis Imunisasi</th>
                                        <th class="px-2 py-3">Tanggal Penjadwalan</th>
                                        <th class="px-2 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(riwayat, index) in riwayats" :key="riwayat.id">
                                        <td class="px-2 py-1 text-center">{{ index+1 }}</td>
                                        <td class="px-2 py-1">{{ riwayat.imunisasi.jenis }}</td>
                                        <td class="px-2 py-1 text-center">{{ riwayat.tgl_penjadwalan }}</td>
                                        <td class="px-2 py-1 text-center"><a href="#" class="text-blue-800 underline">Lihat Lebih Lanjut</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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

    export default {
        components: {
            AppLayout,
            Welcome,
            JetButton,
        },
        props: ['baby', 'riwayats'],
        computed: {
            displayAge() {
                const timeDifference = new Date() - new Date(this.baby.ttl)
                const monthDifference = Math.floor(timeDifference / (2e3 * 3600 * 365.25))
                return monthDifference ? monthDifference +' Bulan' : '0 Bulan'
            }
        }
    }
</script>


