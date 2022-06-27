<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
</script>

<template>
<div>
    <Head title="Create Product" />
    
    <BreezeAuthenticatedLayout>
    <div class="text-center flex justify-center item-center flex-col container mx-auto p-4">
        <h1 class="mb-8 text-3xl font-bold w-full">
            <Link class="text-indigo-400 hover:text-indigo-600" :href="`/products`">Products </Link>
            <span class="text-indigo-400 font-medium">/</span> Create
        </h1>
        <div class="max-w-3xl ml-96 bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="store">
                <div class="flex flex-wrap flex-col -mb-8 -mr-6 p-8">
                    <text-input v-model="form.product_name" :error="form.errors.product_name" class="pb-8 pr-6 w-full uppercase" label="Product Name" />
                    <text-area-input v-model="form.product_description" :error="form.errors.product_description" rows="10" cols="5" class="pb-8 pr-6 w-full uppercase" label="Product Description" />
                    <text-input v-model="form.price" :error="form.errors.price" class="pb-8 pr-6 w-full uppercase" min="0" label="Price" type="number" step="0.01"/>
                    <text-input v-model="form.quantity" :error="form.errors.quantity" class="pb-8 pr-6 w-full uppercase" min="0" label="Quantity" type="number"/>  
                </div>
                <div class="flex items-center justify-center px-8 py-4 bg-gray-50 border-t border-gray-100">
                    <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Product</loading-button>
                </div>
            </form>
        </div>
    </div>
    </BreezeAuthenticatedLayout>
</div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import TextInput from '@/Components/TextInput'
import SelectInput from '@/Components/SelectInput'
import TextAreaInput from '@/Components/TextAreaInput'
import LoadingButton from '@/Components/LoadingButton'
export default {
    components: {
        Head,
        Link,
        LoadingButton,
        SelectInput,
        TextInput,
        TextAreaInput,
    },
    props: {},
    remember: 'form',
    data() {
        return {
        form: this.$inertia.form({
            'product_name': '',
            'product_description': '',
            'price': 0,
            'quantity': '',
        }),
        }
    },
    methods: {
        store() {
            this.form.post('/products')
        },
    },
    }
</script>