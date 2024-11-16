<template>
    <header class="flex justify-between items-center mb-20">
        <h1 class="font-semibold text-4xl">Movies</h1>
        <div class="w-1/3">
            <label for="genre-filter" class="block text-sm font-medium text-gray-700">Filter by Genre</label>
            <Popover>
                <PopoverTrigger asChild>
                    <Button variant="outline" class="w-full mt-2 justify-between">
                        <span>{{ selectedGenresLabel }}</span>
                        <Icon name="i-mdi-chevron-down" class="ml-2" />
                    </Button>
                </PopoverTrigger>
                <PopoverContent class="w-full p-0">
                    <Command>
                        <CommandInput placeholder="Search genres..." />
                        <CommandList>
                            <CommandGroup>
                                <CommandItem v-for="option in genreOptions" :key="option.value" :value="option.value"
                                    @select="toggleGenre(option.value)">
                                    <Icon name="i-mdi-check" v-if="selectedGenres.includes(option.value)"
                                        class="mr-2" />
                                    <span>{{ option.label }}</span>
                                </CommandItem>
                            </CommandGroup>
                        </CommandList>
                    </Command>
                </PopoverContent>
            </Popover>
        </div>
    </header>

    <div v-if="isLoading">
        <p class="italic text-2xl font-medium text-center">Loading...</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        <Card v-for="movie in filteredMovies" :key="movie.id" @click="redirectToMovie(movie)"
            class="transform transition duration-300 hover:scale-105 hover:shadow-lg hover:ring-2 hover:ring-indigo-500 shadow-lg">
            <CardHeader>
                <NuxtImg v-if="movie.image" :src="movie.image" :alt="movie.title"
                    class="w-full object-cover rounded-lg" />
                <div v-else class="bg-slate-300 rounded-lg w-full h-44"></div>
                <CardTitle>{{ movie.title }}</CardTitle>
            </CardHeader>
            <CardFooter class="flex justify-between items-center">
                <div class="flex items-center">
                    <Icon name="i-mdi-star" size="30" class="text-yellow-500" />
                    <p>{{ movie.vote_average }}</p>
                </div>
                <div class="flex items-center">
                    <Icon name="i-mdi-cards-heart" size="30" class="text-red-500" />
                    <p>{{ movie.vote_count }}</p>
                </div>
                <div class="flex items-center">
                    <Icon name="i-mdi-chart-line" size="30" class="text-green-500" />
                    <p class="ml-1">{{ movie?.popularity }}</p>
                </div>
            </CardFooter>
        </Card>
    </div>
</template>

<script lang="ts" setup>
import type { MediaProps } from "@/utils/types";
import {
    Card,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import { Popover, PopoverTrigger, PopoverContent } from "@/components/ui/popover";
import {
    Command,
    CommandInput,
    CommandList,
    CommandItem,
    CommandGroup,
} from "@/components/ui/command";
import { Button } from "@/components/ui/button";

const axios = useApi();
const endpoint = "/api/media";

const isLoading = ref(false);
const movies = ref<MediaProps[]>([]);
const genreOptions = ref<{ value: string; label: string }[]>([]);
const selectedGenres = ref<string[]>([]);

const selectedGenresLabel = computed(() => {
    if (selectedGenres.value.length === 0) return "Select genres";
    return selectedGenres.value.join(", ");
});

const redirectToMovie = (movie: MediaProps) => {
    navigateTo(`/movies/${movie.id}`);
};

const fetchMovies = async () => {
    try {
        isLoading.value = true;

        const response = await axios.get<MediaProps[]>(endpoint, {
            params: { type: "movie" },
        });
        movies.value = response.data.sort(
            (a, b) =>
                Number(new Date(b.created_at as string)) -
                Number(new Date(a.created_at as string))
        );

        // Extract unique genres for the filter options
        const genresSet = new Set<string>();
        movies.value.forEach((movie) => {
            movie.genres?.forEach((genre) => genresSet.add(genre.name));
        });
        genreOptions.value = Array.from(genresSet).map((name) => ({
            value: name,
            label: name,
        }));
    } catch (error) {
        console.error(error);
    } finally {
        isLoading.value = false;
    }
};

const toggleGenre = (genreName: string) => {
    const index = selectedGenres.value.indexOf(genreName);
    if (index >= 0) {
        selectedGenres.value.splice(index, 1);
    } else {
        selectedGenres.value.push(genreName);
    }
};

const filteredMovies = computed(() => {
    if (!selectedGenres.value.length) return movies.value;
    return movies.value.filter((movie) =>
        movie.genres?.some((genre) => selectedGenres.value.includes(genre.name))
    );
});

onMounted(() => {
    fetchMovies();
});
</script>
