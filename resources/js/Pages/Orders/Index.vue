<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Orders" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Orders
            </h2>
        </template>
        <div class="container mx-auto p-4">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <table class="w-full whitespace-nowrap">
                                <thead>
                                    <tr class="text-left font-bold">
                                        <th class="pb-4 pt-6 px-6">Order Number</th>
                                        <th class="pb-4 pt-6 px-6">Product Name</th>
                                        <th class="pb-4 pt-6 px-6" colspan="2">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="order in orders" :key="order.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                                        <td class="border-t text-center">
                                            {{ order.id }}
                                        </td>
                                        <td class="border-t">
                                            <span class="flex font-bold items-center px-6 py-4">
                                            {{ order.product }}
                                            </span>
                                        </td>
                                        <td class="border-t">
                                            <span class="flex items-center font-bold text-green-600 px-6 py-4">
                                            ₱ {{ order.price }}
                                            </span>
                                        </td>
                                        <td class="w-px border-t">
                                            <span class="flex items-center px-4">
                                                <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                                            </span>
                                        </td>
                                    </tr>
                                    <tr v-if="orders.length === 0">
                                        <td class="px-6 py-4 border-t" colspan="4">No Orders found.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <span class="font-bold uppercase">Total Orders: {{ orders.length }}</span>
                            <span class="font-bold uppercase float-right mr-72">Total Sales: <span class="font-bold text-xl italic text-green-800">₱ {{ formatMoney(totalSales) }}</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
export default {
    props: {
        orders: Array
    },
    methods: {
        formatMoney(value) {
             if (typeof value !== "number") {
                return value;
            }
            // let currency = (value/1).toFixed(3).replace('.', ',');
            // return currency.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return (value).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
    },
    computed: {
        totalSales() {
            let total = 0;
            for (let order of this.$page.props.orders) {
                total += order.price;
            }
            return total;
        }
    }
}
</script>

