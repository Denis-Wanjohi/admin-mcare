<template>
    <div v-if="visible" class="w-screen h-screen fixed top-0 left-0  z-10  bg-orange-600 bg-opacity-40">
        <Toast></Toast>
        <Dialog v-model:visible="visible" header="New Event Post" class="sm:w-1/2 w-screen mx-5">
            <form @submit.prevent="upload">
                <div>
                    <FloatLabel class="my-6  sm:w-3/4 mx-auto">
                        <InputText id="title"  class="w-full" required v-model="form.title" />
                        <label for="title">TITLE</label>
                    </FloatLabel>

                    <FloatLabel class="my-6  sm:w-3/4 mx-auto">
                        <label for="subtitle">SUBTITLE</label>
                        <InputText id="subtitle"  class="w-full" required v-model="form.subtitle" />
                    </FloatLabel>
                </div>
                <div class="card flex flex-col items-center sm:w-3/4 mx-auto gap-6 border rounded-xl px-4 py-4">
                    <p  class="text-sm">Banner for the post:</p>
                    <FileUpload mode="basic" @select="onFileSelect"  required customUpload auto severity="primary"  class="p-button-outlined" />
                    <img v-if="src" :src="src" alt="Image" class="shadow-md rounded-xl w-full sm:w-64" />
                    <Button  v-if="src" label="Remove" size="small" outlined severity="danger"  @click.prevent="src = null"></Button>
                </div>
                <div class="text-center mt-5">
                    <Textarea autoResize placeholder="Your content goes here . . ." required class="sm:w-3/4 w-[100%] my-auto mx-auto" v-model="form.content"></Textarea>
                    <p class="text-[10px] text-end">
                        {{ wordCount(form.content) }}
                        <span v-if="wordCount(form.content) === 1 ">word</span>
                        <span v-else>words</span>
                    </p>
                </div>

                <div class="text-center py-3">
                    <Button label="SUBMIT" type="submit" class="w-1/4"></Button>
                </div>
            </form>
            <div v-if="actions"  class="w-full h-full bg-black absolute top-0 bg-opacity-10 flex justify-center align-middle">
                <Uploading></Uploading>
            </div>
        </Dialog>
    </div>
</template>

<script setup>
import Dialog from 'primevue/dialog';
import FileUpload from 'primevue/fileupload';
import FloatLabel from 'primevue/floatlabel';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Button from 'primevue/button';
import Uploading from '../Uploading.vue';
import { router, useForm } from '@inertiajs/vue3'
import {ref, watch} from 'vue';
import Toast from 'primevue/toast';
import { useToast } from "primevue/usetoast";
const toast = useToast();
const visible = ref(true);
const actions = ref(false)
const src = ref(null);
const emits = defineEmits(['closePost'])
const props = defineProps({newPost:Boolean})
watch(()=>visible.value,()=>{
    if(visible.value == false){
        emits('closePost','post cancelled')
    }
})

function onFileSelect(event) {
    const file = event.files[0];
    const reader = new FileReader();

    reader.onload = async (e) => {

        // const src = document.getElementById('imagePreview'); // Adjust as necessary
        src.value = e.target.result;

        // Get base64 string and remove the prefix
        const imageData = e.target.result.replace(/^data:image\/jpeg;base64,/, '');

        // Convert base64 string to a binary string
        const byteCharacters = atob(imageData);
        const byteNumbers = new Array(byteCharacters.length);
        
        for (let i = 0; i < byteCharacters.length; i++) {
            byteNumbers[i] = byteCharacters.charCodeAt(i);
        }

        // Create a Uint8Array from the byte numbers
        const byteArray = new Uint8Array(byteNumbers);

        // Create a Blob from the byte array
        const blob = new Blob([byteArray], { type: 'image/jpeg' });

        // Create a File object from the Blob
        form.banner = new File([blob], 'image.jpg', { type: 'image/jpeg', lastModified: new Date().getTime() });

    };
    reader.readAsDataURL(file);
}
const form = useForm({
    title : '',
    subtitle : '',
    banner : '',
    content : ''
})
function wordCount(data){
    const arr = data.trim().split(' ')
    if(data.length != 0 ){
        return arr.length;
    }
}
function upload(){
    actions.value = true
    router.post('eventUpload',form,{
        forceFormData: true,
        onSuccess: (data)=>{
            actions.value = false
            emits('closePost','post uploaded')
            visible.value = false
            success.value = true
            setTimeout(() => {
                success.value = false;
            }, 3000);
        },
        onError:()=>{
            actions.value = false
            alert('error in uploading the event post')
            console.log('error')
            visible.value = true
        },
        onProgress:(data)=>{
            toast.add({ severity: 'info', summary: 'uploading...', detail: 'upload in progress', life: 3000 });
        }
    })
}
</script>