<template>
    <div class="mx-auto py-10">
        <div v-if="isLoading" class="text-center">
            <p class="italic text-2xl font-medium text-gray-600">Loading...</p>
        </div>
        <div v-else class="flex flex-col lg:flex-row gap-8">
            <!-- Image on the left -->
            <div class="w-full lg:w-2/3">
                <NuxtImg v-if="movie?.image" :src="movie.image" :alt="movie.title"
                    class="w-full object-cover h-full rounded-lg shadow-lg" />
                <div v-else class="bg-slate-300 rounded-lg w-full h-96"></div>
                <!-- Tooltip Icons -->
                <div class="flex items-center justify-end space-x-6 mt-4">
                    <TooltipProvider>
                        <div class="flex items-center space-x-6">
                            <Tooltip v-for="(item, index) in tooltipItems" :key="index">
                                <TooltipTrigger>
                                    <Icon :name="item.icon" size="30" :class="item.colorClass"></Icon>
                                    <p class="ml-2 font-medium">{{ item.value }}</p>
                                </TooltipTrigger>
                                <TooltipContent>
                                    <p :class="item.colorClass">{{ item.name }}</p>
                                </TooltipContent>
                            </Tooltip>
                        </div>
                    </TooltipProvider>
                </div>
            </div>
            <!-- Details on the right -->
            <div class="flex-grow">
                <h1 class="text-4xl font-bold mb-4 text-gray-800">{{ movie?.title }}</h1>
                <p class="text-lg mb-6 text-gray-700">{{ movie?.overview }}</p>
                <!-- Genres Section -->
                <div class="mb-6">
                    <p class="text-lg text-gray-700">
                        <strong>Genres:</strong> {{ genreList }}
                    </p>
                </div>
                <!-- Cast Section with Collapsible -->
                <div class="mb-6">
                    <Collapsible v-model:open="isCastOpen" class="space-y-2">
                        <div class="flex items-center space-x-4">
                            <h1 class="text-lg font-semibold mb-2 text-gray-800">
                                Cast Members ({{ movie?.cast.length }})
                            </h1>
                            <CollapsibleTrigger as-child>
                                <Button variant="ghost" size="sm" class="w-9 p-0">
                                    <ChevronsUpDown class="h-4 w-4" />
                                    <span class="sr-only">Toggle</span>
                                </Button>
                            </CollapsibleTrigger>
                        </div>
                        <CollapsibleContent class="space-y-2">
                            <ScrollArea class="h-[400px] w-full rounded-md border p-4">
                                <ul class="space-y-4">
                                    <li v-for="castMember in movie?.cast" :key="castMember.id"
                                        class="text-gray-600 flex items-center space-x-4 px-4">
                                        <Avatar class="w-12 h-12">
                                            <AvatarImage v-if="castMember.profile_path" :src="castMember.profile_path"
                                                alt="Cast Member Profile Picture" />
                                            <AvatarFallback>CN</AvatarFallback>
                                        </Avatar>
                                        <div>
                                            <span class="font-medium text-gray-700">{{ castMember.name }}</span>
                                            as
                                            <span class="italic">{{ castMember.character }}</span>
                                        </div>
                                    </li>
                                </ul>
                            </ScrollArea>
                        </CollapsibleContent>
                    </Collapsible>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div v-if="movie?.latest_comments && movie?.latest_comments.length"
            class="mt-20 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Comments</h2>
            <ul class="space-y-6">
                <li v-for="comment in movie?.latest_comments" :key="comment.id" class="border-b border-gray-200 pb-4">
                    <div class="flex items-center space-x-4 mb-2">
                        <Avatar class="w-12 h-12">
                            <AvatarImage v-if="comment.user?.profile_pic" :src="comment.user?.profile_pic"
                                alt="User Profile Picture" />
                            <AvatarFallback>CN</AvatarFallback>
                        </Avatar>
                        <div>
                            <p class="font-medium text-gray-800">{{ comment.user.name }}</p>
                            <p class="text-sm text-gray-500">
                                {{ new Date(comment?.created_at).toLocaleString() }}
                            </p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-2">{{ comment.content }}</p>
                    <TooltipProvider>
                        <div class=" items-center space-x-6">
                            <Tooltip>
                                <TooltipTrigger class="flex">
                                    <Icon name="i-mdi-thumb-up" size="20" class="text-blue-500 me-1"></Icon>
                                    <p class="font-medium">{{ comment?.likes }}</p>
                                </TooltipTrigger>
                                <TooltipContent>
                                    <p class="text-blue-500">Upvotes</p>
                                </TooltipContent>
                            </Tooltip>
                        </div>
                    </TooltipProvider>
                </li>
            </ul>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { useRoute } from 'vue-router';
import { ref, onMounted, computed } from 'vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import { Button } from '@/components/ui/button';
import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from '@/components/ui/collapsible';
import { ChevronsUpDown } from 'lucide-vue-next';
import { ScrollArea } from '@/components/ui/scroll-area';

const isCastOpen = ref(true);

const {
    params: { movieId },
} = useRoute();
const axios = useApi();

const movie = ref<MediaProps>();
const isLoading = ref(true);

const fetchMovie = async () => {
    try {
        const response = await axios.get<MediaProps>(`/api/media/${movieId}`);
        movie.value = response.data;
    } catch (error) {
        console.error('Error fetching movie:', error);
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    fetchMovie();
});

// Computed property for genre list
const genreList = computed(() => {
    return movie.value?.genres?.map((genre) => genre.name).join(', ');
});

// Tooltip items
const tooltipItems = computed(() => [
    {
        name: 'Rating',
        icon: 'i-mdi-star',
        colorClass: 'text-yellow-500',
        value: movie.value ? `${movie.value.vote_average}/10` : '',
    },
    {
        name: 'Popularity',
        icon: 'i-mdi-chart-line',
        colorClass: 'text-green-500',
        value: movie.value?.popularity ?? '',
    },
    {
        name: 'Like Count',
        icon: 'i-mdi-cards-heart',
        colorClass: 'text-red-500',
        value: movie.value?.vote_count ?? '',
    },
]);
</script>