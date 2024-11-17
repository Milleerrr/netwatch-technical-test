<template>
  <main class="bg-gray-50 p-10 m-4 min-h-screen">
    <div class="max-w-8xl mx-auto">
      <header
        class="flex flex-col gap-6 mb-10 p-6 rounded-lg shadow-lg bg-gradient-to-r from-teal-400 via-blue-500 to-purple-600 text-white">
        <NuxtLink to="/" class="flex items-center gap-4">
          <h1 class="font-bold text-5xl tracking-wide">
            Explore Movies & TV Shows
          </h1>
          <Icon name="i-fluent:movies-and-tv-16-filled" alt="Website Logo" size="50" />
        </NuxtLink>
        <section>
          <p class="text-lg leading-relaxed">
            Your one-stop destination to discover movies and TV shows with comprehensive metrics and authentic critiques
            from people who/'ve watched them. Find out what/'s trending, what/'s coming soon, and stay up-to-date with your
            favorite streaming services.
          </p>
        </section>
        <div class="flex gap-4">
          <Icon name="i-cbi-prime-video-alt" alt="Prime Video Logo" size="60"
            class="p-2 bg-black rounded-lg shadow-md" />
          <Icon name="i-cbi-disney-plus-alt" alt="Disney Plus Logo" size="60"
            class="p-2 bg-blue-500 rounded-lg shadow-md" />
          <Icon name="i-cbi-netflix-alt" alt="Netflix Logo" size="60" class="p-2 bg-red-500 rounded-lg shadow-md" />
        </div>
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
