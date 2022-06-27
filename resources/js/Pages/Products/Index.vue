<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import throttle from 'lodash/throttle';
import pickBy from 'lodash/pickBy';
</script>
<template>
    <Head title="Products"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Products
            </h2>
        </template>
        <div class="container mx-auto p-4">
            <div class="flex items-center justify-between mb-6 mt-12 mx-auto w-full">
                <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
                    <label class="block text-gray-700">Filter:</label>
                    <select v-model="form.trashed" class="form-select mt-1 w-1/2">
                    <option value="with">With Disabled</option>
                    <option value="only">Only Disabled</option>
                    </select>
                </search-filter>
                <Link class="btn-indigo mt-2" href="/products/create">
                    <span>Create</span>
                    <span class="hidden md:inline">&nbsp;New Product</span>
                </Link>
            </div>
            <div class="flex flex-wrap justify-center items-center">
                <pagination class="mt-6" :links="products.links" />
            </div>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-2 bg-white border-b border-gray-200">
                            <table class="w-full whitespace-nowrap">
                                <thead>
                                    <tr class="text-left font-bold">
                                        <th class="pb-4 pt-6 px-6">Product Name</th>
                                        <th class="pb-4 pt-6 px-6">Description</th>
                                        <th class="pb-4 pt-6 px-6" colspan="2">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="product in products.data" :key="product.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                                        <td class="border-t">
                                            <Link class="flex items-center px-6 py-4 font-bold focus:text-indigo-500" :class="product.status ? '' : 'text-red-600'" :href="`/products/${product.id}/edit`">
                                            {{ product.name }} {{ product.status ? '' : ' (Disabled)'}}
                                            </Link>
                                        </td>
                                        <td class="border-t">
                                            <Link class="flex items-center px-6 py-4" :class="product.status ? '' : 'text-red-600'" :href="`/products/${product.id}/edit`">
                                            {{ product.description }}
                                            </Link>
                                        </td>
                                        <td class="border-t">
                                            <Link class="flex items-center font-bold text-green-500 px-6 py-4" :href="`/products/${product.id}/edit`" tabindex="-1">
                                            ₱ {{ product.price }}
                                            </Link>
                                        </td>
                                        <td class="w-px border-t">
                                            <Link class="flex items-center px-4" :href="`/products/${product.id}/edit`" tabindex="-1">
                                            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                                            </Link>
                                        </td>
                                    </tr>
                                    <tr v-if="products.data.length === 0">
                                        <td class="px-6 py-4 border-t" colspan="4">No Products found.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
<script>
import Icon from '@/Components/Icon';
import Pagination from '@/Components/Pagination.vue';

export default {
    components: {
        Icon,
        Pagination
    },
    props: {
        products: Object,
        filters: Object
    },
    data() {
        return {
            form: {
                search: this.filters.search,
                trashed: this.filters.trashed ?? 'with',
            }
        }
    },

    watch: {
        form: {
            deep: true,
            handler: throttle(function () {
                this.$inertia.get('/products', pickBy(this.form), { preserveState: true })
            }, 150),
        },
    }, // watch
    
    methods: {
        reset() {
            this.form = mapValues(this.form, () => null)
        }
    }
}
</script>
