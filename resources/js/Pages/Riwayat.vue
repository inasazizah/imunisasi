<template>
    <app-layout>
        <template #header>
            <h2 class="font-bold text-xl text-center text-gray-800 leading-tight">
                Riwayat Imunisasi
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
                                <p>{{ formatDate(baby.ttl) }}</p>
                            </div>
                            <div class="my-1">
                                <p class="text-xs font-semibold">Usia</p>
                                <p>{{ displayAge }}</p>
                            </div>
                        </div>
                        <div class="max-w-4xl mx-auto">
                            <table class="min-w-full leading-normal mt-10">
                                <thead>
                                    <tr>
                                        <th class="px-3 py-3">No</th>
                                        <th class="px-2 py-3">Jenis Imunisasi</th>
                                        <th class="px-2 py-3">Tanggal Penjadwalan</th>
                                        <th class="px-2 py-3">Status</th>
                                        <th class="px-2 py-3">Tanggal Pemberian</th>
                                        <th class="px-2 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y text-sm">
                                    <tr v-for="(riwayat, index) in riwayats" :key="riwayat.id">
                                        <td class="px-2 py-1 text-center">{{ index+1 }}</td>
                                        <td class="px-2 py-1">{{ riwayat.imunisasi.jenis }}</td>
                                        <td class="px-2 py-1 text-center">{{ formatDate(riwayat.tgl_penjadwalan) }}</td>
                                        <td class="px-2 py-1 text-center">{{ riwayat.status || 'Belum' }}</td>
                                        <td class="px-2 py-1 text-center">{{ formatDate(riwayat.tgl_diberikan) }}</td>
                                        <td class="px-2 py-1 text-center">
                                            <button v-if="riwayat.status != 'Sudah'" @click="edit(riwayat)" class="bg-indigo-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" >
                                                 Update
                                            </button>
                                        </td>
                                        <td class="px-2 py-1 text-center"><inertia-link :href="route('detail', {id: riwayat.imunisasi_id})" class="text-blue-800 underline">Lihat Lebih Lanjut</inertia-link></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div class="fixed inset-0 transition-opacity">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                    </div>
                                    <!-- This element is to trick the browser into centering the modal contents. -->
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
                                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                        <form>
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <div class="">
                                                    <div class="mb-4">
                                                        <label for="tgl_diberikan" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Pemberian Imunisasi</label>
                                                        <input v-model="form.tgl_diberikan" type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="tgl_diberikan">
                                                        <!-- //<div v-if="$page.errors.title" class="text-red-500">{{ $page.errors.title[0] }}</div> -->
                                                    </div>
                                                    <!-- <div class="mb-4">
                                                        <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                                                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="status" v-model="form.status">
                                                            <option>Sudah</option>
                                                        </select>
                                                    </div> -->
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                                    <button v-show="editMode" @click="update(form)" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                                        Update
                                                    </button>
                                                </span>
                                                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                                    <button @click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                                        Cancel
                                                    </button>
                                                </span>
                                            </div>
                                        </form>
                                    </div>    
                                </div>
                            </div>
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
    import { format, differenceInMonths } from 'date-fns'
    import { id } from 'date-fns/locale'

    export default {
        components: {
            AppLayout,
            Welcome,
            JetButton,
        },
        props: ['baby', 'riwayats'],
        computed: {
            displayAge() {
                if (!this.baby.ttl) {
                    return 'Masukkan tanggal lahir bayi terlebih dahulu'
                }

                const age = differenceInMonths(new Date(), new Date(this.baby.ttl))
                if (age < 0) {
                   return 'Tanggal lahir bayi yang dimasukkan salah' 
                }
            
                return age + ' Bulan'
            },
            scheduled() {
                return this.riwayats
                    .filter(riwayat => !!riwayat.tgl_penjadwalan)
                    .sort((a, b) => new Date(a.tgl_penjadwalan) - new Date(b.tgl_penjadwalan))
            },
        },
        data() {
            return {
                editMode: false,
                isOpen: false,
                form: {},
            }
        },
        methods: {
            formatDate(date) {
                if (!date) {
                    return '-'
                }
                const tgl = new Date(date)
                return format(tgl, "d MMMM yyyy", {
                        locale: id
                    })
            },
            openModal: function () {
                this.isOpen = true;
            },
            closeModal: function () {
                this.isOpen = false;
                this.reset();
                this.editMode=false;
            },
            reset: function () {
                this.form = {}
            },
            edit: function (data) {
                this.form = Object.assign({}, data);
                this.editMode = true;
                this.openModal();
            },
            update: function(data) {
                data.status = 'Sudah';
                data._method = 'PUT';
                this.$inertia.post(this.route('riwayat.update'), data)
                this.reset();
                this.closeModal(); 
            }
        }
    }
</script>