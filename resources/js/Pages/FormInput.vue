<template>
    <app-layout>
        <template #header>
            <h2 class="font-bold text-xl text-center text-gray-800 leading-tight">
                Tambah Jadwal Pengingat Imunisasi
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6 mt-4">
                            <h1 class="font-semibold text-indigo-500 text-xl">Data Bayi</h1>
                            <div class="my-5 text-sm">
                                <label for="nama" class="block text-black">Nama</label>
                                <input v-model="form.nama" type="text" id="nama" class="rounded-sm px-4 py-3 mt-3 focus:outline-none bg-gray-100 w-full" placeholder="Nama">
                            </div>
                            <div class="my-5 text-sm">
                                <label for="ttl">Tanggal Lahir Bayi</label>
                                <input v-model="form.ttl" type="date" id="ttl" class="rounded-sm px-4 py-3 mt-3 focus:outline-none bg-gray-100 w-full">
                            </div>
                            <div  class="my-5 text-sm">
                                <label for="usia">Usia Bayi</label>
                                <div class="rounded-sm px-4 py-3 mt-3 focus:outline-none bg-gray-100 w-full">{{ displayAge }}</div>
                            </div>
                            <div class="my-5 text-sm">
                                <label for="bb">Berat Badan Bayi (dalam kg)</label>
                                <input v-model="form.bb" type="number" id="bb" class="rounded-sm px-4 py-3 mt-3 focus:outline-none bg-gray-100 w-full" placeholder="Berat Badan Bayi">
                            </div>
                        </div>
                        <div class="p-6 mt-4">
                            <h1 class="font-semibold text-indigo-500 text-xl text-semibold">Riwayat Imunisasi</h1>
                            <div class="my-5 text-sm">
                                <label>Imunisasi yang telah diberikan</label><br>
                                <input v-model="form.done" type='checkbox' id='done1' value='HB0'>
                                <label class="ml-3" for="done1">HB0</label><br>
                                <input v-model="form.done" type='checkbox' id='done2' value='BCG'>
                                <label class="ml-3" for="done2">BCG</label><br>
                                <input v-model="form.done" type='checkbox' id='done3' value='Polio 1'>
                                <label class="ml-3" for="done3">Polio 1</label><br>
                                <input v-model="form.done" type='checkbox' id='done4' value='DPT-HB-Hib 1'>
                                <label class="ml-3" for="done4">DPT-HB-Hib 1</label><br>
                                <input v-model="form.done" type='checkbox' id='done5' value='Polio 2'>
                                <label class="ml-3" for="done5">Polio 2</label><br>
                                <input v-model="form.done" type='checkbox' id='done6' value='DPT-HB-Hib 2'>
                                <label class="ml-3" for="done6">DPT-HB-Hib 2</label><br>
                                <input v-model="form.done" type='checkbox' id='done7' value='Polio 3'>
                                <label class="ml-3" for="done7">Polio 3</label><br>
                                <input v-model="form.done" type='checkbox' id='done8' value='DPT-HB-Hib 3'>
                                <label class="ml-3" for="done8">DPT-HB-Hib 3</label><br>
                                <input v-model="form.done" type='checkbox' id='done9' value='Polio 4'>
                                <label class="ml-3" for="done9">Polio 4</label><br>
                                <input v-model="form.done" type='checkbox' id='done10' value='MR'>
                                <label class="ml-3" for="done10">MR</label><br>
                                <input v-model="form.done" type='checkbox' id='done11' value='DPT-HB-Hib Lanjutan'>
                                <label class="ml-3" for="done11">DPT-HB-Hib Lanjutan</label><br>
                                <input v-model="form.done" type='checkbox' id='done11' value='MR Lanjutan'>
                                <label class="ml-3" for="done11">MR Lanjutan</label><br>
                            </div>
                                <div class="my-5 text-sm">
                                    <label for="last_polio">Tanggal Pemberian Polio Terakhir</label>
                                    <input v-model="form.last_polio" type="date" id="last_polio" class="rounded-sm px-4 py-3 mt-3 focus:outline-none bg-gray-100 w-full">
                                </div>
                                <div class="my-5 text-sm">
                                    <label for="last_dpt">Tanggal Pemberian DPT-HB-Hib Terakhir</label>
                                    <input v-model="form.last_dpt" type="date" id="last_dpt" name="last_dpt" class="rounded-sm px-4 py-3 mt-3 focus:outline-none bg-gray-100 w-full">
                                </div>
                                <div class="my-5 text-sm">
                                    <label for="last_mr">Tanggal Pemberian MR Terakhir</label>
                                    <input v-model="form.last_mr" type="date" id="last_mr" name="last_mr" class="rounded-sm px-4 py-3 mt-3 focus:outline-none bg-gray-100 w-full">
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center p-6 pb-10">
                            <jet-button class="bg-indigo-500">
                                Simpan
                            </jet-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import JetButton from '@/Jetstream/Button'
    import { differenceInMonths } from 'date-fns'

    export default {
        components: {
            AppLayout,
            Welcome,
            JetButton,
        },
        data() {
            return {
                form: {
                    nama: null,
                    ttl: null,
                    bb: null,
                    done: [],
                    last_polio: null,
                    last_dpt: null,
                    last_mr: null,
                    user_id: this.$page.props.user.id
                }
            }
        },
         methods: {
            submit() {
                const data = {...this.form}
                data.done = JSON.stringify(this.form.done)
                this.$inertia.post(this.route('form.store'), data)
            }
        },
        computed: {
            displayAge() {
                if (!this.form.ttl) {
                    return 'Masukkan tanggal lahir bayi terlebih dahulu'
                }

                const age = differenceInMonths(new Date(), new Date(this.form.ttl))
                if (age < 0) {
                   return 'Tanggal lahir bayi yang dimasukkan salah' 
                }
            
                return age + ' Bulan'
            }
        }
    }
</script>


