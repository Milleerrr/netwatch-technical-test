<template>
    <main class="bg-white py-10 min-h-screen">
        <div class="max-w-4xl mx-auto">
            <header class="flex justify-between items-center mb-20">
                <h1 class="font-semibold text-4xl">Movies</h1>
                <Button @click="toggleAddMovieDrawer">Add Movie</Button>
            </header>

            <div v-if="isLoading">
                <p class="italic text-2xl font-medium text-center">Loading...</p>
            </div>
            <div class="mt-8">
                <div class="flex flex-col gap-8">
                    <div class="flex gap-4" v-for="movie in movies">
                        <div v-if="movie" class="rounded-lg w-32 h-44 flex items-center justify-center">
                            <NuxtImg :src="`https://dummyjson.com/icon/abc${movie.id}/150`" :alt="movie.title" class="w-full h-auto" />
                        </div>
                        <div v-else class="bg-slate-300 drounded-lg w-32 h-44"></div>
                        <div class="flex items-center justify-between flex-1">
                            <div>
                                <h3 class="font-medium text-xl mb-4">{{ movie.title }}</h3>
                                <p class="mb-2">
                                    <span> Released: </span>
                                    <span class="italic"> {{ movie.release_date }} </span>
                                </p>
                                <p v-for="category in movie.categories">
                                    <span>Categories:</span>
                                    {{ category.name }}
                                </p>
                            </div>
                            <div class="actions flex gap-4">
                                <Button @click="toggleEditMovieDrawer(movie)">Edit</Button>
                                <Button @click="toggleDeleteDialog(movie)" variant="destructive">
                                    Delete
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <BookDrawer v-if="isMovieDrawerOpen" :open="isMovieDrawerOpen"
            @update:open="(open: boolean) => isMovieDrawerOpen = open" :media="currentMedia" :endpoint="endpoint"
            @refresh-data="fetchMovies" />
        <DeleteBookDrawer v-if="isDeleteMovieDialogOpen" :open="isDeleteMovieDialogOpen"
            @update:open="(open: boolean) => isDeleteMovieDialogOpen = open" :media="currentMedia" :endpoint="endpoint"
            @refresh-data="fetchMovies" />
    </main>
</template>

<script lang="ts" setup>
import type { MediaProps } from "@/utils/types";

const axios = useApi();
const endpoint = '/api/movies'

const isLoading = ref(false);
const movies = ref<MediaProps[]>([]);
const currentMedia = ref<MediaProps>();

const isMovieDrawerOpen = ref(false);
const isDeleteMovieDialogOpen = ref(false);

const toggleAddMovieDrawer = () => {
    isMovieDrawerOpen.value = !isMovieDrawerOpen.value;
};

const toggleEditMovieDrawer = (movie: MediaProps) => {

    currentMedia.value = {
        id: movie.id,
        title: movie.title,
        description: movie.description,
        release_date: movie.release_date
    };
    isMovieDrawerOpen.value = !isMovieDrawerOpen.value;
};

const toggleDeleteDialog = (movie: MediaProps) => {
    currentMedia.value = {
        id: movie.id,
        title: movie.title,
        description: movie.description,
        release_date: movie.release_date
    };
    isDeleteMovieDialogOpen.value = !isDeleteMovieDialogOpen.value;
};

const fetchMovies = async () => {
    try {
        isLoading.value = true;

        const response = await axios.get<MediaProps[]>(endpoint);

        // Wait for all movies to process
        movies.value = (await Promise.all(response.data)).sort(
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
    fetchMovies();
});
</script>