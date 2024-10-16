<template>
    <div class="card mt-5  shadow-lg rounded-lg text-black dark:text-white">
        <Toast></Toast>
        <DataTable v-model:filters="filters" :value="blogs" :rows="5" paginator  :rowsPerPageOptions="[5, 10, 20, 50]" responsiveLayout="scroll" tableStyle="" size="small"
        :globalFilterFields="['title','category','comments','likes','comments','posted_on']" filterDisplay="row"
        >
            <template #header >
                <div class="sm:flex sm:justify-between rounded-xl  py-2 sm:text-end text-center">
                    <div class="flex my-auto  justify-between sm:pl-5 ">
                       <div class="font-semibold    text-2xl mb-4 text-center text-black dark:text-white sm:w-3/4">Mcare Educative Blogs</div> 
                       <div class="flex mx-3 border border-black w-fit h-fit rounded px-2 py-1 bg-blue-500 cursor-pointer text-black font-bold" @click.prevent="newPost = true">
                            <svg class="my-auto" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24"><path fill="currentColor" d="M19 12.998h-6v6h-2v-6H5v-2h6v-6h2v6h6z"/></svg>
                            <p class="   text-nowrap">new post</p>
                        </div>
                    </div>
                    <div class="w-fit">
                        <Button  v-if="filters.global.value !== null" type="button" class="text-xs mx-3" label="Clear fliter" outlined @click="clearFilter()" />
                        <InputText class="" v-model="filters['global'].value" placeholder="Search" />
                    </div>
                </div>
            </template>
            <template #empty class="text-center"> No news found. </template>
            <template #loading> Loading  data. Please wait. </template>
            <Column field="title" header="Title" :sortable="true" style="width: 15%">
                <template #body="slotProps" >
                    <div class="md:text-md text-sm md:w-[100%] w-[200px] ">
                        {{ slotProps.data.title }}
                    </div>
                </template>
            </Column>
            <Column style="width: 10%" header="Image">
                <template #body="slotProps">
                    <!-- <img src="../../../../public/Images/image.png" class="w-[100px] rounded-lg p-1" alt=""> -->
                    <img :src="slotProps.data.image" alt="image" width="50" class="shadow rounded" />
                </template>
            </Column>
            <Column field="category" header="Category" :sortable="true" style="width: 15%">
                <template #body="slotProps" >
                    <div class="md:text-md text-sm md:w-[100%] w-[100px] ">
                        {{ slotProps.data.category }}
                    </div>
                </template>
            </Column>
            <Column field="content" header="Content" :sortable="true" style="width: 25%;" >
                <!-- <template #body="slotProps">
                    <div class=" h-[100px]  overflow-hidden text-ellipsis text-sm">
                        {{ slotProps.data.content }}
                    </div>
                </template> -->
                <template #body="slotProps" >
                    <div class="md:text-md text-sm md:w-[100%] max-h-[100px]  overflow-hidden w-[200px] ">
                        {{ slotProps.data.title }} 
                    </div>
                </template>
            </Column>
            <Column field="comments" header="Comments" :sortable="true" style="width: 5%;text-align: center">
                <template #body="slotProps">
                    <div class="">
                        {{ slotProps.data.comments.length }}
                    </div>
                </template>
            </Column>
            <Column field="likes" header="Likes" :sortable="true" style="width: 5%;text-align: center"></Column>
            <Column field="posted_on" header="Posted on" class="text-nowrap" :sortable="true" style="width: 15%"></Column>
            <Column style="width: 10%" header="View">
                <template #body="slotProps">
                    <svg @click.prevent="postView( slotProps.data)" class="bg-blue-300 dark:bg-blue-600 rounded p-1 cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor"><path d="M21.544 11.045c.304.426.456.64.456.955c0 .316-.152.529-.456.955C20.178 14.871 16.689 19 12 19c-4.69 0-8.178-4.13-9.544-6.045C2.152 12.529 2 12.315 2 12c0-.316.152-.529.456-.955C3.822 9.129 7.311 5 12 5c4.69 0 8.178 4.13 9.544 6.045"/><path d="M15 12a3 3 0 1 0-6 0a3 3 0 0 0 6 0"/></g></svg>
                </template>
            </Column>
        </DataTable>
        <BlogPost v-if="newPost" :newPost=newPost @closePost="closePost"></BlogPost>
        <BlogView v-if="viewPost"  :postData=postData @closePost="closePost"></BlogView>
    </div>
</template>

<script setup>
import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import BlogPost from "@/Components/NewPost/BlogPost.vue";
import BlogView from "@/Components/ViewPost/BlogView.vue";
import { onMounted, ref, watch } from "vue";
import {FilterMatchMode} from '@primevue/core/api'
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import Toast from "primevue/toast";
import { useToast } from "primevue/usetoast";
const toast = useToast();
const props = defineProps({blogs:Object})
const newPost = ref(false)
const viewPost = ref(false)
const postData = ref(null)
const postId = ref(null)
function closePost(data){
    if(data == true){
       viewPost.value = false
       postData.value = ''
       newPost.value = false 
    }else if(data == 'post deleted'){
        toast.add({ severity: 'success', summary: 'Confirmed', detail: 'Blog deleted successfully', life: 3000 });
        viewPost.value = false
        postData.value = ''
    }else if(data == 'comment deleted'){
        toast.add({ severity: 'success', summary: 'Confirmed', detail: 'Comment deleted successfully', life: 3000 });
        viewPost.value = false
        postData.value = ''
    }else if(data == 'post uploaded'){
        toast.add({ severity: 'success', summary: 'Confirmed', detail: 'Post uploaded successfully', life: 3000 });
        viewPost.value = false
        postData.value = ''
        newPost.value = false
    }else if(data == 'post cancelled'){
        newPost.value = false
    }
}
function postView(data){
    viewPost.value = true
    postData.value = data
    postId.value = data.id
}
const blogs = ref([])
onMounted(()=>{
    data_init()
})
watch(()=>props.blogs,()=>{
    data_init()
    if(viewPost.value == true){
        viewPost.value = false
        blogs.value.forEach((el)=>{
            if(el.id === postId.value){
                postData.value = el
            }
        })
        viewPost.value = true

    }
})
function data_init(){
    blogs.value = []
    props.blogs.forEach((blog)=>{
        let blogObj = {
            id: blog.id,
            title: blog.title,
            subtitle: blog.subtitle,
            image: blog.banner,
            category: blog.category,
            content: blog.content,
            comments: blog.comments,
            likes: 5,
            posted_on:formartDate(blog.created_at),
        }
        blogs.value.push(blogObj)
        blogObj = {
            id: '',
            title: '',
            subtitle: '',
            image: '',
            category: '',
            content: '',
            comments: '',
            likes: 5,
            posted_on:'',
        }
    })
}

const filters =  ref({
    global:{value:null, matchMode: FilterMatchMode.CONTAINS}
})
const initFilters = () => {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    };
};

initFilters();
const clearFilter = () => {
    initFilters();
};
function formartDate(data){
    let init_date = new Date(data)
    let month = String(init_date.getMonth() + 1).length == 1 ? '0'+ String(init_date.getMonth() + 1) : String(init_date.getMonth() + 1)
    let year = init_date.getFullYear()
    let day_of_month = String(init_date.getDate()).length == 1 ? '0'+ String(init_date.getDate()) : String(init_date.getDate())
    return  day_of_month+'-'+month+'-'+year
}
</script>

<style scoped>
.p-datatable-tbody tr {
    height: 50px; /* Adjust this value to your desired height */
    background-color: red;
}
</style>
