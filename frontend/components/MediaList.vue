<template>
    <header class="flex flex-col lg:flex-row justify-between items-center mb-10 gap-6">
        <h1 class="font-extrabold text-4xl text-gray-800 tracking-wide">{{ title }}</h1>
        <div class="w-full lg:w-1/3">
            <label for="genre-filter" class="block text-sm font-medium text-gray-600">Filter by Genre</label>
            <Popover>
                <PopoverTrigger asChild>
                    <Button variant="outline"
                        class="w-full mt-2 flex justify-between items-center text-gray-700 border border-gray-300 rounded-lg shadow-sm hover:border-indigo-500 focus:ring focus:ring-indigo-200">
                        <span>{{ selectedGenresLabel }}</span>
                        <Icon name="i-mdi-chevron-down" class="ml-2 text-gray-500" />
                    </Button>
                </PopoverTrigger>
                <PopoverContent class="w-full p-0 bg-white rounded-lg shadow-lg">
                    <Command>
                        <CommandInput placeholder="Search genres..." class="p-3 text-gray-700 border-b" />
                        <CommandList class="p-3 max-h-60 overflow-y-auto">
                            <CommandGroup>
                                <CommandItem v-for="option in genreOptions" :key="option.value" :value="option.value"
                                    class="flex items-center gap-2 p-2 hover:bg-indigo-100 rounded-lg cursor-pointer"
                                    @select="toggleGenre(option.value)">
                                    <Icon v-if="selectedGenres.includes(option.value)" name="i-mdi-check"
                                        class="text-indigo-600" />
                                    <span>{{ option.label }}</span>
                                </CommandItem>
                            </CommandGroup>
                        </CommandList>
                    </Command>
                </PopoverContent>
            </Popover>
        </div>
    </header>

    <div v-if="isLoading" class="text-center">
        <p class="italic text-2xl font-medium text-gray-600">Loading...</p>
    </div>

    <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        <div v-for="mediaItem in filteredMedia" :key="mediaItem.id" @click="redirectToMediaItem(mediaItem)"
            class="relative group transform transition-transform duration-300 hover:scale-105 cursor-pointer shadow-md rounded-lg border border-gray-200 bg-white overflow-hidden">
            <div
                class="absolute inset-0 border-4 border-transparent rounded-lg transition-all duration-300 group-hover:border-indigo-500">
            </div>
            <Card>
                <CardHeader>
                    <NuxtImg v-if="mediaItem.image" :src="mediaItem.image" :alt="mediaItem.title"
                        class="w-full h-60 object-cover rounded-t-lg" />
                    <div v-else
                        class="bg-slate-300 h-60 rounded-t-lg flex items-center justify-center text-gray-500 text-sm">
                        No Image Available
                    </div>
                    <CardTitle class="text-lg font-semibold text-gray-800 mt-4 px-4">{{ mediaItem.title }}</CardTitle>
                </CardHeader>
                <CardFooter class="flex justify-between items-center px-4 py-2 border-t border-gray-200">
                    <div class="flex items-center gap-1">
                        <Icon name="i-mdi-star" size="20" class="text-yellow-500" />
                        <p class="text-gray-700 text-sm">{{ mediaItem.vote_average }}</p>
                    </div>
                    <div class="flex items-center gap-1">
                        <Icon name="i-mdi-cards-heart" size="20" class="text-red-500" />
                        <p class="text-gray-700 text-sm">{{ mediaItem.vote_count }}</p>
                    </div>
                    <div class="flex items-center gap-1">
                        <Icon name="i-mdi-chart-line" size="20" class="text-green-500" />
                        <p class="text-gray-700 text-sm">{{ mediaItem.popularity }}</p>
                    </div>
                </CardFooter>
            </Card>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {
    Card,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Popover, PopoverTrigger, PopoverContent } from '@/components/ui/popover';
import {
    Command,
    CommandInput,
    CommandList,
    CommandItem,
    CommandGroup,
} from '@/components/ui/command';
import { Button } from '@/components/ui/button';

interface Props {
    title: string;
    mediaType: 'movie' | 'tv_show' | 'all';
}

const props = defineProps<Props>();

const axios = useApi();
const endpoint = '/api/media';

const isLoading = ref(false);
const media = ref<MediaProps[]>([]);
const genreOptions = ref<{ value: string; label: string }[]>([]);
const selectedGenres = ref<string[]>([]);

const selectedGenresLabel = computed(() => {
    if (selectedGenres.value.length === 0) return 'Select genres';
    return selectedGenres.value.join(', ');
});

const redirectToMediaItem = (mediaItem: MediaProps) => {
    const mediaType = mediaItem.type === 'movie' ? 'movies' : 'shows';
    navigateTo(`/${mediaType}/${mediaItem.id}`);
};

const fetchMedia = async () => {
    try {
        isLoading.value = true;

        const params: Record<string, string> = {};
        if (props.mediaType !== 'all') {
            params.type = props.mediaType;
        }

        const response = await axios.get<MediaProps[]>(endpoint, { params });
        media.value = response.data.sort(
            (a, b) => Number(new Date(b.created_at as string)) - Number(new Date(a.created_at as string))
        );

        const genresSet = new Set<string>();
        media.value.forEach((mediaItem) => {
            mediaItem.genres?.forEach((genre) => genresSet.add(genre.name));
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

const filteredMedia = computed(() => {
    if (!selectedGenres.value.length) return media.value;
    return media.value.filter((mediaItem) =>
        mediaItem.genres?.some((genre) => selectedGenres.value.includes(genre.name))
    );
});

onMounted(() => {
    fetchMedia();
});
</script>