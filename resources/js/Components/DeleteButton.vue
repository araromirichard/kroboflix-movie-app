<template>
    <div class="flex items-center">
        <button class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded-lg"
            @click.prevent="show = true">Delete</button>

        <ConfirmationModal :show="show">
            <template #title>
                Delete {{ moduleName }}
            </template>

            <template #content>
                Are you sure you wan to delete this {{ moduleName }}
            </template>

            <template #footer>
                <SecondaryButton @click="show = false">
                    Nevermind
                </SecondaryButton>

                <DangerButton class="ml-2" @click="deleteItem" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    Delete
                </DangerButton>
            </template>
        </ConfirmationModal>
    </div>
</template>
  
<script setup>

import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";


const props = defineProps({
    url: String,
    moduleName: String,
});

const show = ref(false);
const form = useForm({});

const deleteItem = () => {
    form.delete(props.url)
}

</script>