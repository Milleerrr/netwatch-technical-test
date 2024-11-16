<template>
  <main class="bg-white p-10 m-4 min-h-screen">
    <div class="max-w-8xl mx-auto">
      <header class="flex justify-between items-center mb-20">
        <h1 class="font-semibold text-4xl">Logo</h1>
      </header>
      <div>
        <GenericTabs :tabs="tabs" class="mb-4"/>
        <slot />
      </div>
    </div>
  </main>
</template>

<script setup>
const tabs = ref([
  {
    text: 'All',
    to: `/`,
    value: 1,
  },
  {
    text: 'Movies',
    to: `/movies`,
    value: 2,
  },
  {
    text: 'TV Shows',
    to: `/shows`,
    value: 3,
  },
]);
</script>