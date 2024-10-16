<template>
    <div class="hide-scrollbar w-screen h-screen fixed top-0 left-0  z-10 bg-blue-500 bg-opacity-40" v-if="visible">
        <Dialog v-model:visible="visible" header="Blog view" class="hide-scrollbar">
            <Toast />
            <!-- <ConfirmPopup></ConfirmPopup> -->
            <!-- {{props.postData}} -->
            <div class="hide-scrollbar sm:w-[90vw]">
                <div class="md:flex my-2">
                    <div class="text-center font-bold font-sans md:text-5xl text-3xl md:w-[90%] ">{{props.postData.title}}</div>
                    <div class="  flex h-[50px] my-auto justify-end">
                        <div class="mx-2 border h-fit p-2 rounded bg-green-900/80" @click="edit(props.postData.id)" style="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 48 48"><g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4"><path stroke-linecap="round" d="M7 42h36"/><path fill="currentColor" d="M11 26.72V34h7.317L39 13.308L31.695 6z"/></g></svg>
                            
                        </div>

                        <Button class="mx-2 border h-fit p-2 rounded bg-red-900/80"  @click.prevent="confirm1($event,props.postData)" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24"><g fill="white"><path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M20 5a1 1 0 1 1 0 2h-1l-.003.071l-.933 13.071A2 2 0 0 1 16.069 22H7.93a2 2 0 0 1-1.995-1.858l-.933-13.07L5 7H4a1 1 0 0 1 0-2zm-6-3a1 1 0 1 1 0 2h-4a1 1 0 0 1 0-2z"/></g></svg>
                            <ConfirmPopup></ConfirmPopup>
                        </Button>
                    </div>
                </div>
                <div class="sm:flex hide-scrollbar">
                    <div class="sm:w-1/2 sm:mx-3">
                        <img :src="props.postData.image" class="h-[400px]  mx-auto pt-2 rounded-lg" alt="image">
                        <div class="flex w-full my-3 justify-around">
                            <div  class="mx-4 flex  ">
                                <svg class="my-auto" xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 24 24"><path fill="currentColor" d="M15.056 9.004q.692-2.14.693-3.754c0-2.398-.939-4.247-2.5-4.247c-.847 0-1.109.504-1.437 1.747c.018-.065-.163.634-.215.821q-.152.539-.527 1.831a.3.3 0 0 1-.03.065L8.174 9.953a5.9 5.9 0 0 1-2.855 2.326l-1.257.482a1.75 1.75 0 0 0-1.092 1.967l.686 3.539a2.25 2.25 0 0 0 1.673 1.757l8.25 2.022a4.75 4.75 0 0 0 5.733-3.44l1.574-6.173a2.75 2.75 0 0 0-2.665-3.43z"/></svg>
                                <p class="my-auto mx-2 font-semibold text-gray-400 text-nowrap">20 likes</p>
                            </div>
                            <div class="mx-4 flex align-baseline">
                                <svg class="my-auto" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 1024 1024"><path fill="currentColor" d="M573 421c-23.1 0-41 17.9-41 40s17.9 40 41 40c21.1 0 39-17.9 39-40s-17.9-40-39-40m-280 0c-23.1 0-41 17.9-41 40s17.9 40 41 40c21.1 0 39-17.9 39-40s-17.9-40-39-40"/><path fill="currentColor" d="M894 345c-48.1-66-115.3-110.1-189-130v.1c-17.1-19-36.4-36.5-58-52.1c-163.7-119-393.5-82.7-513 81c-96.3 133-92.2 311.9 6 439l.8 132.6c0 3.2.5 6.4 1.5 9.4c5.3 16.9 23.3 26.2 40.1 20.9L309 806c33.5 11.9 68.1 18.7 102.5 20.6l-.5.4c89.1 64.9 205.9 84.4 313 49l127.1 41.4c3.2 1 6.5 1.6 9.9 1.6c17.7 0 32-14.3 32-32V753c88.1-119.6 90.4-284.9 1-408M323 735l-12-5l-99 31l-1-104l-8-9c-84.6-103.2-90.2-251.9-11-361c96.4-132.2 281.2-161.4 413-66c132.2 96.1 161.5 280.6 66 412c-80.1 109.9-223.5 150.5-348 102m505-17l-8 10l1 104l-98-33l-12 5c-56 20.8-115.7 22.5-171 7l-.2-.1C613.7 788.2 680.7 742.2 729 676c76.4-105.3 88.8-237.6 44.4-350.4l.6.4c23 16.5 44.1 37.1 62 62c72.6 99.6 68.5 235.2-8 330"/><path fill="currentColor" d="M433 421c-23.1 0-41 17.9-41 40s17.9 40 41 40c21.1 0 39-17.9 39-40s-17.9-40-39-40"/></svg>
                                <p class="my-auto mx-2 text-gray-400 font-semibold text-nowrap">{{ props.postData.comments.length }} comments</p>
                            </div>
                            <div class="mx-4 flex">
                                <svg class="my-auto" xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 30 30"><path fill="currentColor" d="M3.74 14.47c0-2.04.51-3.93 1.52-5.66s2.38-3.1 4.11-4.11s3.61-1.51 5.64-1.51c1.52 0 2.98.3 4.37.89s2.58 1.4 3.59 2.4s1.81 2.2 2.4 3.6s.89 2.85.89 4.39c0 1.52-.3 2.98-.89 4.37s-1.4 2.59-2.4 3.59s-2.2 1.8-3.59 2.39s-2.84.89-4.37.89s-3-.3-4.39-.89s-2.59-1.4-3.6-2.4s-1.8-2.2-2.4-3.58s-.88-2.84-.88-4.37m2.48 0c0 2.37.86 4.43 2.59 6.18c1.73 1.73 3.79 2.59 6.2 2.59c1.58 0 3.05-.39 4.39-1.18s2.42-1.85 3.21-3.2s1.19-2.81 1.19-4.39s-.4-3.05-1.19-4.4s-1.86-2.42-3.21-3.21s-2.81-1.18-4.39-1.18s-3.05.39-4.39 1.18S8.2 8.72 7.4 10.07s-1.18 2.82-1.18 4.4m7.92 0V7.81c0-.23.08-.43.24-.59s.36-.24.59-.24c.22 0 .42.08.59.24s.25.36.25.59v3.53l.75-1.3c.12-.2.29-.32.52-.38s.44-.03.64.09c.2.11.32.27.39.5s.04.43-.08.63l-2.29 3.91c-.13.35-.38.53-.76.53c-.23 0-.43-.08-.59-.24s-.25-.37-.25-.61"/></svg>
                                <p class="my-auto mx-2 text-gray-400 font-semibold text-nowrap">{{ props.postData.posted_on }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="sm:w-1/2  overflow-scroll hide-scrollbar max-h-[400px]">
                        <div class="sm:text-3xl text-xl  text-center">{{ props.postData.subtitle }}</div>
                        <div class="text-md">{{ props.postData.content }}</div>
                    </div>
                </div>
                <div>
                    <p class="font-bold text-xl">Comments</p>
                    <div>
                        <div class="border-b mt-2 border-gray-700 flex " v-for="comment in props.postData.comments">
                            <div class="w-full">
                                <p class="font-bold  shadow-lg w-fit px-1 rounded-md mb-2">{{comment.comment.name}} 
                                    <span class="text-xs">
                                        {{formartDate(comment.comment.created_at)[0]}}/
                                        {{formartDate(comment.comment.created_at)[1]}}/
                                        {{formartDate(comment.comment.created_at)[2]}}
                                    </span>
                                </p>
                                <p class="text-sm my-1">{{comment.comment.comment}}</p>
                            </div>
                            <div>
                                <div  class="mx-2 border  h-fit p-2 rounded bg-red-900/80"  @click.prevent="commentDelete($event,comment.comment.id)" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24"><g fill="white"><path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M20 5a1 1 0 1 1 0 2h-1l-.003.071l-.933 13.071A2 2 0 0 1 16.069 22H7.93a2 2 0 0 1-1.995-1.858l-.933-13.07L5 7H4a1 1 0 0 1 0-2zm-6-3a1 1 0 1 1 0 2h-4a1 1 0 0 1 0-2z"/></g></svg>
                                    <!-- <ConfirmPopup></ConfirmPopup> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="actions"  class="w-full h-full bg-black absolute top-0 bg-opacity-10 flex justify-center align-middle">
                <Deleting></Deleting>
            </div>
        </Dialog>
        
    </div>
</template>

<script setup>
import Dialog from 'primevue/dialog'
import Button from 'primevue/button';
import {ref,watch} from 'vue'
import { router,Link } from '@inertiajs/vue3';
import ConfirmPopup from 'primevue/confirmpopup';
import Toast from 'primevue/toast';
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import Deleting from '../Deleting.vue';
const confirm = useConfirm();
const toast = useToast();
const visible = ref(true);
const actions = ref(false)
const props = defineProps({postData:Object})
const emits = defineEmits(['closePost'])
watch(()=>visible.value,()=>{
    if(visible.value == false){
        emits('closePost',true)

    }
})
function deletePost(data){
    actions.value = true
    router.post('/deleteBlog',data,{
        onSuccess:(data)=>{
        //    toast.add({ severity: 'success', summary: 'Confirmed', detail: 'You have accepted', life: 5000 });
        actions.value = false
        visible.value = false
           emits('closePost','post deleted') 
        },
        onError:()=>{
            actions.value = false
            alert('error in deleting')
        },
        onProgress:(data)=>{

            toast.add({ severity: 'info', summary: 'deleting...', detail: 'deletion in progress', life: 3000 });
        }
    })
    
}
function deleteComment(data){
    let id = {
        'id':data,
        'open':true
    }
    // alert()
    router.post('/deleteComment',id,{
        onSuccess:(data)=>{
           toast.add({ severity: 'success', summary: 'Confirmed', detail: 'comment deleted', life: 5000 });

        },
        onError:()=>{
            actions.value = false
            alert('error in deleting')
        },
        onProgress:(data)=>{
           
            toast.add({ severity: 'info', summary: 'Comment deleting...', detail: 'deletion in progress', life: 3000 });
        }
    })
}
const confirm1 = (event,data) => {
    // setTimeout(() => {
        confirm.require({
            target: event.currentTarget,
            message: 'Are you sure you want to proceed?',
            icon: 'pi pi-exclamation-triangle',
            rejectProps: {
                label: 'Cancel',
                severity: 'secondary',
                outlined: true
            },
            acceptProps: {
                label: 'Delete',
                severity:'danger'
            },
            accept: () => {
                deletePost(data)
            },
            reject: () => {
                toast.add({ severity: 'info', summary: 'NOT DELETED', detail: 'Post not deleted', life: 3000 });
            }
        });
    // }, 10);
};
const commentDelete = (event,data) => {
    confirm.require({
        target: event.currentTarget,
        message: 'Are you sure you want to proceed?',
        icon: 'pi pi-exclamation-triangle',
        rejectProps: {
            label: 'Cancel',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Delete',
            severity:'danger'
        },
        accept: () => {
            deleteComment(data)
        },
        reject: () => {
            toast.add({ severity: 'info', summary: 'NOT DELETED', detail: 'Post not deleted', life: 3000 });
        }
    });
};
function edit(data){
    router.get('/edit/blog/'+data);
}
function formartDate(data){
    let init_date = new Date(data)
    let month = String(init_date.getMonth() + 1).length == 1 ? '0'+ String(init_date.getMonth() + 1) : String(init_date.getMonth() + 1)
    let year = init_date.getFullYear()
    let day_of_month = String(init_date.getDate()).length == 1 ? '0'+ String(init_date.getDate()) : String(init_date.getDate())
    return  [day_of_month,month,year]
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