<template>
  <Tabs :default-value="startValue" class="w-[400px]">
    <TabsList>
      <NuxtLink 
        v-for="tab in tabs" 
        :key="tab.value"
        :to="tab.to"
      >
        <TabsTrigger :value="tab.value">
          {{ tab.text }}
        </TabsTrigger>
      </NuxtLink>
    </TabsList>
  </Tabs>
</template>

<script setup lang="ts">
import { Tabs, TabsList, TabsTrigger } from '@/components/ui/tabs'

interface Props {
  tabs: TabProps[];
  startValue?: number;
}

const props = withDefaults(defineProps<Props>(), {
  tabs: () => [],
  startValue: 1
})

const startValue = ref(props.startValue)
</script>