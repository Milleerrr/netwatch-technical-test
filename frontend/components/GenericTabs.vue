<template>
    <Tabs :default-value="tab" class="w-[400px]">
        <TabsList>
            <NuxtLink v-for="tab in tabs" :to="tab.to">
                <TabsTrigger :value="tab.value">
                    {{ tab.text }}
                </TabsTrigger>
            </NuxtLink>
        </TabsList>
    </Tabs>
</template>

<script setup lang="ts">
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs'

defineProps({
  tabs: {
    type: Array,
    default: [],
  },
});
const tab = ref(1);

</script>