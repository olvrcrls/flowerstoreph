<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
</script>

<template>
<div>
    <Head title="Edit Product" />
    
    <BreezeAuthenticatedLayout>
    <div class="text-center flex justify-center item-center flex-col container mx-auto p-4">
        <h1 class="mb-8 text-3xl font-bold">
            <Link class="text-indigo-400 hover:text-indigo-600" :href="`/products`">Products </Link>
            <span class="text-indigo-400 font-medium">/</span> {{ product.name }}
        </h1>
        <trashed-message v-if="!product.status" class="mb-6 ml-96" @restore="restore"> This product has been disabled or has no stock. </trashed-message>
        <div class="max-w-3xl ml-96 bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="update">
                <div class="flex flex-wrap flex-col -mb-8 -mr-6 p-8">
                    <text-input v-model="form.product_name" :error="form.errors.product_name" class="pb-8 pr-6 w-full uppercase" label="Product Name" />
                    <text-area-input v-model="form.product_description" :error="form.errors.product_description" rows="10" cols="5" class="pb-8 pr-6 w-full uppercase" label="Product Description" />
                    <text-input v-model="form.price" :error="form.errors.price" class="pb-8 pr-6 w-full uppercase" min="0" label="Price" step="0.01" type="number"/>
                    <text-input v-model="form.quantity" :error="form.errors.quantity" class="pb-8 pr-6 w-full uppercase" min="0" label="Quantity" type="number"/>  
                </div>
                <div class="flex items-center justify-center px-8 py-4 bg-gray-50 border-t border-gray-100">
                    <loading-button :loading="form.processing" class="btn-indigo" type="submit">Update Product</loading-button>
                    <button v-if="product.status" class="text-red-600 hover:underline ml-8" tabindex="-1" type="button" @click="destroy">Disable Product</button>
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
import TextAreaInput from '@/Components/TextAreaInput.vue';
import SelectInput from '@/Components/SelectInput'
import LoadingButton from '@/Components/LoadingButton'
import TrashedMessage from '@/Components/TrashedMessage';
import Icon from '@/Components/Icon';
    export default {
        components: {
            Head,
            Link,
            LoadingButton,
            SelectInput,
            TextAreaInput,
            TextInput,
            TrashedMessage,
            Icon,
        },
        props: {
            product: Object
        },
        remember: 'form',
        data() {
            return {
                form: this.$inertia.form({
                    'product_name': this.product.name,
                    'product_description': this.product.description,
                    'price': this.product.price,
                    'quantity': this.product.quantity,
                }),
            }
        }, // data
        methods: {
            update() {
                this.form.put(`/products/${this.product.id}`)
            },

            destroy() {
                if (confirm('Are you sure you want to disable this product?')) {
                    this.$inertia.delete(`/products/${this.product.id}`)
                }
            },

            restore() {
                if (confirm('Are you sure you want to restore this product?')) {
                    this.$inertia.put(`/products/${this.product.id}/restore`)
                }
            },
        },
    }
</script>