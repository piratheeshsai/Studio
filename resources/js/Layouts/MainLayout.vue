<template>
  <div>
    <Header />
    <main class="min-h-screen">
      <slot />
    </main>
    <Footer />
  </div>
</template>

<script setup>
import Header from '@/Components/WebHeader.vue'
import Footer from '@/Components/WebFooter.vue'
</script>
