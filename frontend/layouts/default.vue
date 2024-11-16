<template>
  <main class="bg-white p-10 min-h-screen">
    <div class="max-w-4xl mx-auto">
      <header class="flex justify-between items-center mb-20">
        <h1 class="font-semibold text-4xl">Logo</h1>
      </header>
      <div>
        <GenericTabs :tabs="tabs" />
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