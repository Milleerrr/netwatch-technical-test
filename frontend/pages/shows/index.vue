<template>
    <header class="flex justify-between items-center mb-20">
        <h1 class="font-semibold text-4xl">TV Shows</h1>
    </header>

    <div v-if="isLoading">
        <p class="italic text-2xl font-medium text-center">Loading...</p>
    </div>
    <div class="mt-8">
        <div class="flex flex-col gap-8">
            <div class="flex gap-4" v-for="show in shows">
                <div v-if="show" class="rounded-lg w-32 h-44 flex items-center justify-center">
                    <NuxtImg :src="show.image" :alt="show.title" class="w-full h-auto" />
                </div>
                <div v-else class="bg-slate-300 drounded-lg w-32 h-44"></div>
                <div class="flex items-center justify-between flex-1">
                    <div>
                        <h3 class="font-medium text-xl mb-4">{{ show.title }}</h3>
                        <!-- <p class="mb-2">
                                    <span> Released: </span>
                                    <span class="italic"> {{ show.release_date }} </span>
                                </p> -->
                        <p v-for="genre in show.genres">
                            <span>Genres:</span>
                            {{ genre.name }}
                        </p>
                    </div>
                    <div class="actions flex gap-4">
                        <Button @click="toggleEditShowDrawer(show)">Edit</Button>
                        <Button @click="toggleDeleteDialog(show)" variant="destructive">
                            Delete
                        </Button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <MediaDrawer v-if="isShowDrawerOpen" :open="isShowDrawerOpen"
        @update:open="(open: boolean) => isShowDrawerOpen = open" :media="currentMedia" :endpoint="endpoint"
        @refresh-data="fetchShows" />
    <DeleteMediaDrawer v-if="isDeleteShowDialogOpen" :open="isDeleteShowDialogOpen"
        @update:open="(open: boolean) => isDeleteShowDialogOpen = open" :media="currentMedia" :endpoint="endpoint"
        @refresh-data="fetchShows" />
</template>

<script lang="ts" setup>
import type { MediaProps } from "@/utils/types";

const axios = useApi();
const endpoint = '/api/media'

const isLoading = ref(false);
const shows = ref<MediaProps[]>([]);
const currentMedia = ref<MediaProps>();

const isShowDrawerOpen = ref(false);
const isDeleteShowDialogOpen = ref(false);

const toggleEditShowDrawer = (show: MediaProps) => {

    currentMedia.value = show;
    isShowDrawerOpen.value = !isShowDrawerOpen.value;
};

const toggleDeleteDialog = (show: MediaProps) => {
    currentMedia.value = show;
    isDeleteShowDialogOpen.value = !isDeleteShowDialogOpen.value;
};

const fetchShows = async () => {
    try {
        isLoading.value = true;

        const response = await axios.get<MediaProps[]>(endpoint, { params: { type: 'tv_show' } });

        // Wait for all Shows to process
        shows.value = (await Promise.all(response.data)).sort(
            (a, b) =>
                Number(new Date(b.created_at as string)) -
                Number(new Date(a.created_at as string))
        );
    } catch (error) {
        console.error(error);
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    fetchShows();
});
</script>