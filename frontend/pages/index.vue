<template>
  <header class="flex justify-between items-center mb-20">
    <h1 class="font-semibold text-4xl">All</h1>
  </header>

  <div v-if="isLoading">
    <p class="italic text-2xl font-medium text-center">Loading...</p>
  </div>
  <div class="mt-8">
    <div class="flex flex-col gap-8">
      <div class="flex gap-4" v-for="movie in movies">
        <div v-if="movie" class="rounded-lg w-32 h-44 flex items-center justify-center">
          <NuxtImg :src="movie.image" :alt="movie.title" class="w-full h-auto" />
        </div>
        <div v-else class="bg-slate-300 drounded-lg w-32 h-44"></div>
        <div class="flex items-center justify-between flex-1">
          <div>
            <h3 class="font-medium text-xl mb-4">{{ movie.title }}</h3>
            <div class="flex">
              <span>Genres:</span>
              <p class="ms-1 italic" v-for="genre in movie.genres">{{ genre.name }}</p>
            </div>
          </div>
          <div class="actions flex gap-4">
            <Button @click="toggleEditMovieDrawer(movie)">Like</Button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <MediaDrawer v-if="isMovieDrawerOpen" :open="isMovieDrawerOpen"
    @update:open="(open: boolean) => isMovieDrawerOpen = open" :media="currentMedia" :endpoint="endpoint"
    @refresh-data="fetchMovies" />
  <DeleteMediaDrawer v-if="isDeleteMovieDialogOpen" :open="isDeleteMovieDialogOpen"
    @update:open="(open: boolean) => isDeleteMovieDialogOpen = open" :media="currentMedia" :endpoint="endpoint"
    @refresh-data="fetchMovies" />
</template>

<script lang="ts" setup>
import type { MediaProps } from "@/utils/types";

const axios = useApi();
const endpoint = '/api/media'

const isLoading = ref(false);
const movies = ref<MediaProps[]>([]);
const currentMedia = ref<MediaProps>();

const isMovieDrawerOpen = ref(false);
const isDeleteMovieDialogOpen = ref(false);

const toggleEditMovieDrawer = (movie: MediaProps) => {

  currentMedia.value = movie;
  isMovieDrawerOpen.value = !isMovieDrawerOpen.value;
};

const toggleDeleteDialog = (movie: MediaProps) => {
  currentMedia.value = movie;
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