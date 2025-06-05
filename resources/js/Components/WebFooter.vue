<template>
  <footer class="modern-footer">
    <!-- Animated Background Elements -->
    <div class="bg-animation">
      <div class="floating-orb orb-1"></div>
      <div class="floating-orb orb-2"></div>
      <div class="floating-orb orb-3"></div>
    </div>

    <div class="container">
      <!-- Main Footer Content -->
      <div class="footer-grid">
        <!-- Contact Section with Cards -->
        <div class="contact-cards">
          <div class="section-header">
            <h3 class="section-title">Get In Touch</h3>
            <div class="title-accent"></div>
          </div>

          <div class="contact-card phone-card">
            <div class="card-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
              </svg>
            </div>
            <div class="card-content">
              <span class="card-label">Phone</span>
              <a href="tel:+94778454671" class="card-value">+94 778 454 671</a>
            </div>
          </div>

          <div class="contact-card email-card">
            <div class="card-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                <polyline points="22,6 12,13 2,6"></polyline>
              </svg>
            </div>
            <div class="card-content">
              <span class="card-label">Email</span>
              <a href="mailto:yogafotostation@yahoo.com" class="card-value">yogafotostation@yahoo.com</a>
            </div>
          </div>

          <div class="contact-card location-card">
            <div class="card-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                <circle cx="12" cy="10" r="3"></circle>
              </svg>
            </div>
            <div class="card-content">
              <span class="card-label">Studio</span>
              <p class="card-value">Kanthapodiyar Road, Eravur 05<br>Batticaloa, Sri Lanka</p>
            </div>
          </div>
        </div>

        <!-- Navigation & CTA Section -->
        <div class="nav-section">
          <!-- Glowing CTA Button -->
          <div class="cta-container">
            <button class="glow-btn">
              <span class="btn-content">
                <span class="btn-text">BOOK NOW</span>
                <span class="btn-arrow">→</span>
              </span>
              <div class="btn-glow-effect"></div>
            </button>
          </div>

          <!-- Modern Navigation -->
          <nav class="footer-nav">
            <ul class="nav-grid">
              <li class="nav-item">
                <InertiaLink href="/about" class="nav-links">
                  <span class="link-text">About Us</span>
                  <span class="link-hover"></span>
                </InertiaLink>
              </li>
              <li class="nav-item">
                <InertiaLink href="/gallery" class="nav-links">
                  <span class="link-text">Gallery</span>
                  <span class="link-hover"></span>
                </InertiaLink>
              </li>
              <li class="nav-item">
                <InertiaLink href="/products" class="nav-links">
                  <span class="link-text">Products</span>
                  <span class="link-hover"></span>
                </InertiaLink>
              </li>
              <li class="nav-item">
                <InertiaLink href="/contact" class="nav-links">
                  <span class="link-text">Contacts</span>
                  <span class="link-hover"></span>
                </InertiaLink>
              </li>
            </ul>
          </nav>

          <!-- Social Links (Optional) -->
          <div class="social-section">
            <div class="social-links">
              <a href="#" class="social-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                </svg>
              </a>
             <a href="https://www.tiktok.com/@yourusername" class="social-link" target="_blank" rel="noopener">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
       stroke-linecap="round" stroke-linejoin="round" width="24" height="24">
    <path d="M16 8a5.93 5.93 0 0 0 4 1.5V4.5a4.5 4.5 0 0 1-4-2v10a4.5 4.5 0 1 1-4.5-4.5" />
  </svg>
</a>
              <a href="#" class="social-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                  <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                  <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Copyright with Animation -->
      <div class="copyright-section">
        <div class="copyright-line"></div>
        <p class="copyright-text">
          <span class="copyright-year">2024</span>
          <span class="copyright-separator">•</span>
          <span class="copyright-brand">All Rights Reserved @ Yoga Foto Station</span>
          <span class="copyright-separator">•</span>
          <span class="copyright-location">Sri Lanka</span>
        </p>
      </div>
    </div>
  </footer>
</template>

<script>
import { Link as InertiaLink } from '@inertiajs/vue3'

export default {
  components: {
    InertiaLink
  }
};
</script>

<style scoped>












</style>
