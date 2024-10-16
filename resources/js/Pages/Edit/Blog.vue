<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="text-grey-500 dark:text-white bg-black text-5xl py-2  font-bold font-sans">
                Blog editing
            </div>
        </template>
        <Toast></Toast>
        <form @submit.prevent="upload" class=" pt-5">
            <div class="sm:flex ">
                <div  class="sm:w-1/2">
                    <div>
                        <FloatLabel class="my-6  sm:w-3/4 mx-auto">
                            <InputText id="title" name="title"  class="w-full" required v-model="form.title" />
                            <label for="title">TITLE</label>
                        </FloatLabel>

                        <FloatLabel class="my-6  sm:w-3/4 mx-auto">
                            <label for="subtitle">SUBTITLE</label>
                            <InputText name="subtitle" id="subtitle"  class="w-full" required v-model="form.subtitle" />
                        </FloatLabel>

                        <FloatLabel class="my-6  sm:w-3/4 mx-auto">
                            <label for="category">CATEGORY</label>
                            <InputText name="category" id="category"  class="w-full" required v-model="form.category" />
                        </FloatLabel>
                    </div>
                    <!-- <div>
                        <input type="file" name="banner" @input="form.banner = $event.target.files[0]" >
                    </div> -->
                    <div class="card flex flex-col items-center sm:w-3/4 mx-auto gap-6 border rounded-xl px-4 py-4">
                        <p  class="text-sm">Banner for the post:</p>
                        <FileUpload mode="basic" @select="onFileSelect"   required customUpload auto severity="primary"  class="p-button-outlined" />
                        <img v-if="src" :src="src" alt="Image" class="shadow-md rounded-xl w-full sm:w-64"/>
                        <Button  v-if="src" label="Remove" size="small" outlined severity="danger"  @click.prevent="src = null"></Button>
                    </div>
                </div>
                <div class="sm:w-1/2">
                    <div class="text-center mt-5   overflow-scroll hide-scrollbar">
                        <Textarea rows="20" name="content" autoResize placeholder="Your content goes here . . ."  required class="sm:w-full w-[100%]  my-auto mx-auto" v-model="form.content"></Textarea>
                        <p class="text-[10px] text-end">
                            {{ wordCount(form.content) }}
                            <span v-if="wordCount(form.content) === 1 ">word</span>
                            <span v-else>words</span>
                        </p>
                    </div>  
                </div>
            </div>
            
            <div class="text-center py-3">
                <Button type="submit" class="w-1/4 font-bold text-xl">UPDATE</Button>
            </div>
        </form>
        <div v-if="updating"  class="w-screen overflow-hidden z-10 h-full bg-red-400 fixed top-0 bg-opacity-10 flex justify-center align-middle">
            <Updating></Updating>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {onMounted, ref, watch} from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputText from 'primevue/inputtext';
import Updating from '@/Components/Updating.vue';
import FloatLabel from 'primevue/floatlabel';
import Button from 'primevue/button';
import Toast from 'primevue/toast';
import FileUpload from 'primevue/fileupload';
import Textarea from 'primevue/textarea';
import { useForm,router } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
const toast = useToast();
const updating = ref(false)
const {data} = defineProps({data:Object})
const src = ref(null);
const form = useForm({
    id: '',
    title : '',
    subtitle : '',
    banner : '',
    content : '',
    category:''
})
onMounted(()=>{
    form.id = data[0].id
    form.title = data[0].title
    form.subtitle = data[0].subtitle
    src.value =   data[0].banner
    form.banner = data[0].banner.replace(/^blogs\//, '');
    form.category  = data[0].category
    form.content = data[0].content
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

const convertBlobToBase64 = (blob) => {
  const reader = new FileReader();
  reader.onloadend = () => {
    base64Image.value = reader.result; // The base64 string
    console.log(base64Image.value); // You can handle the base64 string here
  };
  reader.readAsDataURL(blob); // Convert blob to base64
};
function wordCount(data){
    const arr = data.trim().split(' ')
    if(data.length != 0 ){
        return arr.length;
    }
}
function upload(){
    updating.value = true
    router.post('/blogUpdate',form,{
        forceFormData: true,
        onSuccess: (data)=>{
            updating.value = false
            toast.add({ severity: 'success', summary: 'DONE', detail: 'Update done', life: 5000 });
        },
        onError:()=>{
            updating.value = false
            alert('error in updating the blog post')
            console.log('error')
        },
        onProgress:(data)=>{
            toast.add({ severity: 'info', summary: 'uploading...', detail: 'upload in progress', life: 3000 });
        }
    })
}
</script>
<style>
/* Hide scrollbar for Chrome, Safari and Opera */
.hide-scrollbar::-webkit-scrollbar {
  display: none;
}

/* Hide scrollbar for IE, Edge, and Firefox */
.hide-scrollbar {
  -ms-overflow-style: none; /* IE and Edge */
  scrollbar-width: none; /* Firefox */
}
</style>