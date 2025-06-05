<template>
  <header class="bg-black shadow sticky-top border-bottom">
    <div class="container py-3 d-flex justify-content-between align-items-center">
      <img :src="logoUrl" alt="Yoga Foto Station Logo" class="h-16">

      <!-- Desktop Navigation -->
      <nav class="d-none d-lg-block">
        <ul class="nav">
          <li class="nav-item">
            <InertiaLink href="/" class="nav-link text-white fw-bold hover-glow">Home</InertiaLink>
          </li>
          <li class="nav-item">
            <InertiaLink href="/about" class="nav-link text-white fw-bold hover-glow">About</InertiaLink>
          </li>
          <li class="nav-item">
            <InertiaLink href="/gallery" class="nav-link text-white fw-bold hover-glow">Gallery</InertiaLink>
          </li>
          <li class="nav-item">
            <InertiaLink href="/products" class="nav-link text-white fw-bold hover-glow">Products</InertiaLink>
          </li>
          <li class="nav-item">
            <InertiaLink href="/contact" class="nav-link text-white fw-bold hover-glow">Contacts</InertiaLink>
          </li>
          <li class="nav-item">
            <InertiaLink href="/login" class="login nav-link fw-bold text-black hover-glow">Login</InertiaLink>
          </li>
        </ul>
      </nav>

      <!-- Modern Toggle Button -->
      <button
        @click="toggleMenu"
        class="d-lg-none modern-toggle-btn"
        :class="{ 'active': isMenuOpen }"
        aria-label="Toggle navigation"
      >
        <span class="toggle-line"></span>
        <span class="toggle-line"></span>
        <span class="toggle-line"></span>
      </button>
    </div>

    <!-- Mobile Navigation Overlay -->
    <div class="mobile-nav-overlay" :class="{ 'active': isMenuOpen }" @click="closeMenu">
      <nav class="mobile-nav" @click.stop>
        <div class="mobile-nav-header">
          <img :src="logoUrl" alt="Yoga Foto Station Logo" class="mobile-logo">
          <button @click="closeMenu" class="close-btn">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="18" y1="6" x2="6" y2="18"></line>
              <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
          </button>
        </div>

        <ul class="mobile-nav-list">
          <li class="mobile-nav-item">
            <InertiaLink href="/" @click="closeMenu" class="mobile-nav-link">
              <span class="nav-icon">🏠</span>
              Home
            </InertiaLink>
          </li>
          <li class="mobile-nav-item">
            <InertiaLink href="/about" @click="closeMenu" class="mobile-nav-link">
              <span class="nav-icon">ℹ️</span>
              About
            </InertiaLink>
          </li>
          <li class="mobile-nav-item">
            <InertiaLink href="/gallery" @click="closeMenu" class="mobile-nav-link">
              <span class="nav-icon">🖼️</span>
              Gallery
            </InertiaLink>
          </li>
          <li class="mobile-nav-item">
            <InertiaLink href="/products" @click="closeMenu" class="mobile-nav-link">
              <span class="nav-icon">🛍️</span>
              Products
            </InertiaLink>
          </li>
          <li class="mobile-nav-item">
            <InertiaLink href="/contact" @click="closeMenu" class="mobile-nav-link">
              <span class="nav-icon">📞</span>
              Contacts
            </InertiaLink>
          </li>
          <li class="mobile-nav-item">
            <InertiaLink href="/login" @click="closeMenu" class="mobile-nav-link login-link">
              <span class="nav-icon ">👤</span>
              Login
            </InertiaLink>
          </li>
        </ul>
      </nav>
    </div>
  </header>
</template>

<script>
import { Link as InertiaLink } from '@inertiajs/vue3'

export default {
  components: {
    InertiaLink
  },
  data() {
    return {
      logoUrl: '/img/logo.png',
      isMenuOpen: false
    };
  },
  methods: {
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
      // Prevent body scroll when menu is open
      document.body.style.overflow = this.isMenuOpen ? 'hidden' : '';
    },
    closeMenu() {
      this.isMenuOpen = false;
      document.body.style.overflow = '';
    }
  },
  mounted() {
    // Close menu on escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && this.isMenuOpen) {
        this.closeMenu();
      }
    });
  }
};
</script>

