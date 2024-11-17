<template>
    <div class="container mx-auto py-10 px-6 lg:px-12">
        <div v-if="isLoading" class="text-center">
            <p class="italic text-2xl font-medium text-gray-600">Loading...</p>
        </div>

        <div v-else class="flex flex-col lg:flex-row gap-10">
            <!-- Image Section -->
            <div class="relative w-full lg:w-2/3">
                <NuxtImg v-if="mediaItem?.image" :src="mediaItem.image" :alt="mediaItem.title"
                    class="w-full h-[500px] object-cover rounded-lg shadow-lg transition-transform duration-300 hover:scale-105" />
                <div v-else
                    class="bg-slate-300 w-full h-[500px] rounded-lg flex items-center justify-center text-gray-500 text-sm">
                    No Image Available
                </div>

                <!-- Floating Tooltip Icons -->
                <div class="absolute bottom-5 right-5 flex gap-4">
                    <TooltipProvider>
                        <Tooltip v-for="(item, index) in tooltipItems" :key="index">
                            <TooltipTrigger>
                                <div
                                    class="bg-white p-2 rounded-full flex flex-col items-center shadow-md hover:shadow-xl transition-transform duration-300 hover:scale-110">
                                    <Icon :name="item.icon" size="30" :class="item.colorClass"></Icon>
                                    {{ item.value }}
                                </div>
                            </TooltipTrigger>
                            <TooltipContent>
                                <p :class="item.colorClass" class="font-medium">
                                    {{ item.name }}: {{ item.value }}
                                </p>
                            </TooltipContent>
                        </Tooltip>
                    </TooltipProvider>
                </div>
            </div>

            <!-- Details Section -->
            <div class="flex-grow bg-white p-6 rounded-lg shadow-lg">
                <h1 class="text-4xl font-extrabold mb-4 text-gray-800">{{ mediaItem?.title }}</h1>
                <p class="text-lg leading-relaxed text-gray-700 mb-6">{{ mediaItem?.overview }}</p>

                <div class="mb-6">
                    <p class="text-lg text-gray-700">
                        <strong>Genres:</strong> {{ genreList }}
                    </p>
                </div>

                <!-- Cast Section -->
                <div class="mb-6">
                    <Collapsible v-model:open="isCastOpen" class="space-y-2">
                        <div class="flex items-center justify-between">
                            <h1 class="text-lg font-semibold text-gray-800">Cast Members</h1>
                            <CollapsibleTrigger as-child>
                                <Button variant="ghost" size="sm"
                                    class="rounded-full p-2 transition-transform duration-300 hover:bg-gray-100">
                                    <ChevronsUpDown class="h-5 w-5 text-gray-500" />
                                </Button>
                            </CollapsibleTrigger>
                        </div>
                        <CollapsibleContent>
                            <ScrollArea class="h-80 w-full rounded-md border p-4">
                                <ul class="space-y-4">
                                    <li v-for="castMember in mediaItem?.cast" :key="castMember.id"
                                        class="flex items-center gap-4">
                                        <Avatar class="w-14 h-14 shadow-md">
                                            <AvatarImage v-if="castMember.profile_path" :src="castMember.profile_path"
                                                alt="Profile Picture" />
                                            <AvatarFallback>{{ getInitials(castMember.name) }}</AvatarFallback>
                                        </Avatar>
                                        <div>
                                            <p class="text-gray-800 font-medium">{{ castMember.name }}</p>
                                            <p class="text-gray-500 italic">{{ castMember.character }}</p>
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
        <div v-if="mediaItem?.latest_comments && mediaItem?.latest_comments.length"
            class="mt-12 bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Comments</h2>
            <ul class="space-y-6">
                <li v-for="comment in mediaItem?.latest_comments" :key="comment.id"
                    class="border-b pb-6 last:border-b-0">
                    <div class="flex items-center gap-4 mb-4">
                        <Avatar class="w-12 h-12 shadow-md">
                            <AvatarImage v-if="comment.user?.profile_pic" :src="comment.user?.profile_pic"
                                alt="User Profile Picture" />
                            <AvatarFallback>{{ getInitials(comment.user.name) }}</AvatarFallback>
                        </Avatar>
                        <div>
                            <p class="font-medium text-gray-800">{{ comment.user.name }}</p>
                            <p class="text-sm text-gray-500">{{ new Date(comment?.created_at).toLocaleString() }}</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">{{ comment.content }}</p>
                    <TooltipProvider>
                        <Tooltip>
                            <TooltipTrigger class="flex items-center gap-1">
                                <Icon name="i-mdi-thumb-up" size="20" class="text-blue-500" />
                                <p class="font-medium text-gray-600">{{ comment.likes }}</p>
                            </TooltipTrigger>
                            <TooltipContent>
                                <p class="text-blue-500 font-medium">Upvotes</p>
                            </TooltipContent>
                        </Tooltip>
                    </TooltipProvider>
                </li>
            </ul>
        </div>
    </div>
</template>


<script lang="ts" setup>
import { useRoute } from 'vue-router';
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

interface Props {
    mediaType: 'movie' | 'tv_show';
}

const props = defineProps<Props>();

const isCastOpen = ref(true);
const route = useRoute();
const axios = useApi();

const mediaItem = ref<MediaProps>();
const isLoading = ref(true);

// Computed property for genre list
const genreList = computed(() => {
    return mediaItem.value?.genres?.map((genre) => genre.name).join(', ');
});

// Tooltip items
const tooltipItems = computed(() => [
    {
        name: 'Rating',
        icon: 'i-mdi-star',
        colorClass: 'text-yellow-500',
        value: mediaItem.value ? `${mediaItem.value.vote_average}/10` : '',
    },
    {
        name: 'Popularity',
        icon: 'i-mdi-chart-line',
        colorClass: 'text-green-500',
        value: mediaItem.value?.popularity ?? '',
    },
    {
        name: 'Like Count',
        icon: 'i-mdi-cards-heart',
        colorClass: 'text-red-500',
        value: mediaItem.value?.vote_count ?? '',
    },
]);

// Get the media ID from the route params
const mediaId = computed(() => {
    return props.mediaType === 'movie' ? route.params.movieId : route.params.showId;
});

const fetchMediaItem = async () => {
    try {
        const response = await axios.get<MediaProps>(`/api/media/${mediaId.value}`);
        mediaItem.value = response.data;
    } catch (error) {
        console.error(`Error fetching ${props.mediaType}:`, error);
    } finally {
        isLoading.value = false;
    }
};

const getInitials = (name: string): string => {
    if (!name) return '';

    const nameArray = name.trim().split(' ');
    const initials = nameArray
        .filter(word => word.length > 0)
        .map(word => word[0].toUpperCase())
        .join('');

    return initials;
};

onMounted(() => {
    fetchMediaItem();
});
</script>