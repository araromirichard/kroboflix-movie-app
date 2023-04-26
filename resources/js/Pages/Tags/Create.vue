<template>
    <AdminLayout :title="pageTitle">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ pageTitle }}
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full flex mb-4">
                    <Link :href="route('admin.tags.index')"
                        class="flex py-2 px-4 text-white bg-[#3a4355] hover:bg-[#0c0d10] rounded-lg"><svg
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg><span class="hidden md:block">Back</span>
                    </Link>
                </div>
                <section class="flex content-center justify-center">
                    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                        <form @submit.prevent="storeTag">
                            <div class="px-4 py-5 bg-white p-6">
                                <div class="w-full">
                                    <div>
                                        <InputLabel for="tagName" value="Tag Name" />
                                        <TextInput id="tagName" v-model="form.tagName" type="text" class="mt-1 block w-full"
                                            autofocus />
                                        <InputError class="mt-2" :message="form.errors.tagName" />
                                    </div>
                                    <div class="mt-4 flex justify-end">
                                        <!-- <button type="submit"
                                            class="px-4 py-2 bg-gray-800 hover:bg-gray-700 rounded text-white">Create</button> -->

                                        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                            :disabled="form.processing">
                                            <span v-if="edit">Update</span>
                                            <span v-else>Create</span>
                                        </PrimaryButton>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { computed, onMounted } from 'vue';

const props = defineProps({
    edit: Boolean,
    tag: Object
})

const form = useForm({
    tagName: "",
})

const pageTitle = computed(() => {
    return `${props.edit ? 'Edit' : 'Add'} Tag`
})

function storeTag() {
   props.edit ? form.put('/admin/tags/' + props.tag.id): form.post('/admin/tags');
}

onMounted(() => {
    if (props.edit) {
        form.tagName = props.tag.tag_name;
    }
})
</script>

<style lang="scss" scoped></style>