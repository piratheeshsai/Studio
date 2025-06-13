<template>
  <section
    class="hero-section d-flex align-items-center text-white position-relative"
    :style="{ backgroundImage: `url(${currentBackground})` }"
  >
    <!-- Background overlay -->
    <div class="hero-overlay"></div>

    <!-- Social icons sidebar -->
    <div class="social-sidebar">
      <div class="social-icon">
        <i class="fab fa-instagram"></i>
      </div>
      <div class="social-icon">
        <i class="fab fa-facebook-f"></i>
      </div>
       <div class="social-icon">
       <i class="fa-brands fa-tiktok"></i>
      </div>
    </div>

    <div class="container hero-content">
      <div class="row align-items-center">
        <!-- Text Column -->
        <div class="col-lg-10 col-md-8 text-start mb-5 mb-md-0">
          <h5 class="welcome-text mb-2">WELCOME</h5>
          <h1 class="hero-title mb-4">YOGA FOTO STATION</h1>
          <p class="hero-description mb-4">
            We turn your special moments into timeless memories. With over 7 years of experience,
            we specialize in wedding, birthday, baby, puberty, and model shoots blending creativity
            and passion in every frame. Let us tell your story through our lens.
          </p>
          <button class="btn btn-book-now px-4 py-3 fw-bold mb-2 text-uppercase">BOOK NOW</button>
        </div>

        <!-- Image Column (hidden on mobile) -->
        <!-- <div class="col-lg-6 col-md-5 d-none d-md-block">
          <div class="hero-image-container">
            <img :src="currentBackground" alt="Yoga Foto Station" class="hero-main-image" />
          </div>
        </div> -->
      </div>

      <!-- Mini Gallery -->
      <div class="row mt-5 justify-content-start">
        <div class="col-12">
          <div class="mini-gallery d-flex  align-items-center">
            <!-- Navigation arrows -->
            <button class="gallery-nav-btn  me-3" @click="previousImage">
              <i class="fas fa-chevron-left"></i>
            </button>
            <button class="gallery-nav-btn rect-btn me-4" @click="nextImage">
              <i class="fas fa-chevron-right"></i>
            </button>

            <!-- Gallery items -->
            <div class="gallery-items  d-flex">
              <div
                v-for="(item, index) in services"
                :key="index"
                class="gallery-item me-4"
                @click="changeBackground(index)"
                :class="{ active: currentIndex === index }"
              >
                <div class="gallery-thumb-container mt-2 ">
                  <img :src="item.img" :alt="item.label" class="gallery-thumb" />
                </div>
                <p class="gallery-label mt-2 mb-0">{{ item.label }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const services = [
  { img: '/img/1.jpg', label: 'Puberty Ceremonies' },
  { img: '/img/3.1.jpg', label: 'Baby Shoot' },
  { img: '/img/4.jpg', label: 'Wedding Shoot' },
]

const currentIndex = ref(0)
const currentBackground = ref(services[0].img)

const changeBackground = (index) => {
  currentIndex.value = index
  currentBackground.value = services[index].img
}

const nextImage = () => {
  const newIndex = (currentIndex.value + 1) % services.length
  changeBackground(newIndex)
}

const previousImage = () => {
  const newIndex = currentIndex.value === 0 ? services.length - 1 : currentIndex.value - 1
  changeBackground(newIndex)
}

// onMounted(() => {
//   // Auto-change background every 5 seconds
//   setInterval(() => {
//     nextImage()
//   }, 5000)
// })
</script>

