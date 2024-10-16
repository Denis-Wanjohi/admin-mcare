<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Button from "primevue/button"
import NewsData from './Dashboard/NewsData.vue';
import EventsData from './Dashboard/EventsData.vue';
import BlogsData from './Dashboard/BlogsData.vue';
const props = defineProps({blogs:Object,news:Object,events:Object,comments:Object})
function formartDate(data){
    let init_date = new Date(data)
    let month = String(init_date.getMonth() + 1).length == 1 ? '0'+ String(init_date.getMonth() + 1) : String(init_date.getMonth() + 1)
    let year = init_date.getFullYear()
    let day_of_month = String(init_date.getDate()).length == 1 ? '0'+ String(init_date.getDate()) : String(init_date.getDate())
    return  day_of_month+'/'+month+'/'+year
}
</script>

<template >
    <Head title="Dashboard" />
    
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-4xl  text-gray-800 dark:text-white dark:bg-slate-800 leading-tight">MCARE Dashboard</h2>
        </template>
        <div>
            
            <div class="grid grid-cols-12 gap-8 pt-5 w-[90%] mx-auto ">
                <div class="col-span-12 lg:col-span-6 xl:col-span-3 border shadow-md  rounded-lg p-1">
                    <div class="card mb-0">
                        <div class="flex justify-between mb-4">
                            <div>
                                <span class="block text-muted-color font-medium mb-4">Events Posted</span>
                                <div class="text-surface-900 dark:text-surface-0 font-medium text-xl px-5 ">{{props.events.length}}</div>
                            </div>
                            <div class="flex items-center justify-center bg-blue-100 dark:bg-blue-400/10 rounded-border" style="width: 4.5rem; height: 4.5rem">
                                <svg xmlns="http://www.w3.org/2000/svg" width="3rem" height="3rem" viewBox="0 0 24 24"><path fill="currentColor" d="M21 17V8H7v9zm0-14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h1V1h2v2h8V1h2v2zm-3.47 8.06l-4.44 4.44l-2.68-2.68l1.06-1.06l1.62 1.62L16.47 10zM3 21h14v2H3a2 2 0 0 1-2-2V9h2z"/></svg>
                            </div>
                        </div>
                        <span class="text-muted-color">Last post  was on</span>
                        <span class="text-primary font-medium px-2" v-if="props.events.length !=  0" >{{ formartDate(props.events[props.events.length - 1].created_at) }}</span>
                        <span class="text-primary font-medium px-2" v-else >--/--/----</span>
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-6 xl:col-span-3 border shadow-md rounded-lg p-1">
                    <div class="card mb-0">
                        <div class="flex justify-between mb-4">
                            <div>
                                <span class="block text-muted-color font-medium mb-4">News Posted</span>
                                <div class="text-surface-900 dark:text-surface-0 font-medium text-xl px-5">{{ props.news.length }}</div>
                            </div>
                            <div class="flex items-center justify-center bg-orange-100 dark:bg-orange-400/10 rounded-border" style="width: 4.5rem; height: 4.5rem">
                                <svg xmlns="http://www.w3.org/2000/svg" width="3rem" height="3rem" viewBox="0 0 24 24"><path fill="currentColor" d="m22 3l-1.67 1.67L18.67 3L17 4.67L15.33 3l-1.66 1.67L12 3l-1.67 1.67L8.67 3L7 4.67L5.33 3L3.67 4.67L2 3v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2zM11 19H4v-6h7zm9 0h-7v-2h7zm0-4h-7v-2h7zm0-4H4V8h16z"/></svg>
                            </div>
                        </div>
                        <span class="text-muted-color">Last post  was on</span>
                        <span class="text-primary font-medium px-2"  v-if="props.news.length != 0" >{{ formartDate(props.news[props.news.length - 1].created_at) }}</span>
                        <span class="text-primary font-medium px-2"  v-else >--/--/----</span>
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-6 xl:col-span-3 border shadow-md rounded-lg p-1">
                    <div class="card mb-0">
                        <div class="flex justify-between mb-4">
                            <div>
                                <span class="block text-muted-color font-medium mb-4">MCare Blogs</span>
                                <div class="text-surface-900 dark:text-surface-0 font-medium text-xl px-5">{{props.blogs.length}}</div>
                            </div>
                            <div class="flex items-center justify-center bg-cyan-100 dark:bg-cyan-400/10 rounded-border" style="width: 4.5rem; height: 4.5rem">
                                <svg xmlns="http://www.w3.org/2000/svg" width="3rem" height="3rem" viewBox="0 0 32 32"><path fill="currentColor" d="M22 26h-2v-8.24l-3.23 3.88a1 1 0 0 1-1.54 0L12 17.76V26h-2V15a1 1 0 0 1 .66-.94a1 1 0 0 1 1.11.3L16 19.44l4.23-5.08a1 1 0 0 1 1.11-.3A1 1 0 0 1 22 15zM4.16 14.65l-3-1.75a.76.76 0 1 0-.76 1.32l3 1.78a.76.76 0 1 0 .76-1.31zm4.13-4.13a.73.73 0 0 0 1 .27a.75.75 0 0 0 .28-1l-1.74-3a.76.76 0 1 0-1.32.76zM16 9a.76.76 0 0 0 .76-.76V4.76a.76.76 0 1 0-1.52 0v3.49A.76.76 0 0 0 16 9m6.68 1.79a.75.75 0 0 0 .37.11a.76.76 0 0 0 .66-.38l1.75-3a.76.76 0 0 0-1.32-.76l-1.74 3a.75.75 0 0 0 .28 1.03m9.22 2.39a.76.76 0 0 0-1-.28l-3 1.75a.76.76 0 0 0 .7 1.35l3-1.74a.77.77 0 0 0 .3-1.08"/></svg>
                            </div>
                        </div>
                        <span class="text-muted-color">Last post  was on</span>
                        <span class="text-primary font-medium px-2" v-if="props.blogs.length != 0">{{ formartDate(props.blogs[props.blogs.length - 1].created_at) }}</span>
                        <span class="text-primary font-medium px-2" v-else>--/--/----</span>
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-6 xl:col-span-3 border  shadow-md rounded-lg p-1">
                    <div class="card mb-0">
                        <div class="flex justify-between mb-4">
                            <div>
                                <span class="block text-muted-color font-medium mb-4">Comments</span>
                                <div class="text-surface-900 dark:text-surface-0 font-medium text-xl px-5" >
                                    <span v-if="props.blogs.length != 0">{{props.comments}}</span>
                                    <span v-else>0</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-center bg-purple-100 dark:bg-purple-400/10 rounded-border" style="width: 4.5rem; height: 4.5rem">
                                <svg xmlns="http://www.w3.org/2000/svg" width="3rem" height="3rem" viewBox="0 0 1024 1024"><path fill="currentColor" d="M573 421c-23.1 0-41 17.9-41 40s17.9 40 41 40c21.1 0 39-17.9 39-40s-17.9-40-39-40m-280 0c-23.1 0-41 17.9-41 40s17.9 40 41 40c21.1 0 39-17.9 39-40s-17.9-40-39-40"/><path fill="currentColor" d="M894 345c-48.1-66-115.3-110.1-189-130v.1c-17.1-19-36.4-36.5-58-52.1c-163.7-119-393.5-82.7-513 81c-96.3 133-92.2 311.9 6 439l.8 132.6c0 3.2.5 6.4 1.5 9.4c5.3 16.9 23.3 26.2 40.1 20.9L309 806c33.5 11.9 68.1 18.7 102.5 20.6l-.5.4c89.1 64.9 205.9 84.4 313 49l127.1 41.4c3.2 1 6.5 1.6 9.9 1.6c17.7 0 32-14.3 32-32V753c88.1-119.6 90.4-284.9 1-408M323 735l-12-5l-99 31l-1-104l-8-9c-84.6-103.2-90.2-251.9-11-361c96.4-132.2 281.2-161.4 413-66c132.2 96.1 161.5 280.6 66 412c-80.1 109.9-223.5 150.5-348 102m505-17l-8 10l1 104l-98-33l-12 5c-56 20.8-115.7 22.5-171 7l-.2-.1C613.7 788.2 680.7 742.2 729 676c76.4-105.3 88.8-237.6 44.4-350.4l.6.4c23 16.5 44.1 37.1 62 62c72.6 99.6 68.5 235.2-8 330"/><path fill="currentColor" d="M433 421c-23.1 0-41 17.9-41 40s17.9 40 41 40c21.1 0 39-17.9 39-40s-17.9-40-39-40"/></svg>
                            </div>
                        </div>
                        <span class="text-primary font-medium" v-if="props.blogs.length != 0">{{ props.blogs[0].comments.length }}</span>
                        <span class="text-primary font-medium" v-else > --</span>
                        <span class="text-muted-color">   comments on the last post</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:flex mx-5">
            <NewsData class="md:mx-4 my-5 p-2 md:w-1/2 w-full" :news=props.news></NewsData>
            <EventsData class="md:mx-4 my-5 p-2  md:w-1/2 w-full" :events=props.events></EventsData>
        </div>

        <div>
            <BlogsData class="mx-4 my-5 p-2" :blogs=props.blogs ></BlogsData>
        </div>
        
    </AuthenticatedLayout>
</template>
