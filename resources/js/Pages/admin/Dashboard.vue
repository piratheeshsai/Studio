<template>
  <div class="min-vh-100 bg-black text-white">
    <!-- Header -->
    <DashboardHeader :stats="stats" @file-upload="handleFileUpload" />

    <!-- Navigation -->
    <div class="bg-secondary bg-opacity-10 border-bottom border-secondary py-3">
      <div class="container-xl">
        <ul class="nav nav-pills gap-2 justify-content-center">
          <li class="nav-item" v-for="tab in tabs" :key="tab.id">
            <button
              class="nav-link d-flex align-items-center gap-2"
              :class="activeTab === tab.id ? 'nav-gradient-active text-white' : 'text-secondary'"
              @click="activeTab = tab.id"
            >
              <i :class="tab.icon"></i>
              <span>{{ tab.name }}</span>
            </button>
          </li>
        </ul>
      </div>
    </div>

    <!-- Main Content -->
    <div class="container-xl py-4">
      <!-- Overview Tab -->
     <OverviewTab
  v-if="activeTab === 'overview'"
  :stat-cards="statCards"
  :recent-shoots="recentShoots"
  :get-status-text="getStatusText"
  :stats="stats"
/>

      <!-- Shoots Tab -->
      <ShootsTab
        v-if="activeTab === 'shoots'"
        :shoot-types="shootTypes"
        :active-shoot-type="activeShootType"
        :filtered-shoots="filteredShoots"
        :get-type-icon="getTypeIcon"
        :get-status-text="getStatusText"
        @update:activeShootType="activeShootType = $event"
        @trigger-file-input="triggerFileInput"
        @copy-gallery-link="copyGalleryLink"
        @open-new-shoot-tab="openNewShootTab"
      />

      <!-- Galleries Tab -->
      <GalleryTab
        v-if="activeTab === 'galleries'"
        :shoot-types="shootTypes"
        :recent-shoots="recentShoots"
        :get-status-text="getStatusText"
        @copy-gallery-link="copyGalleryLink"
      />

      <!-- Website Tab -->
      <WebsiteTab
        v-if="activeTab === 'website'"
        :website-settings="websiteSettings"
        @save="saveWebsiteSettings"
        @preview="previewWebsite"
        @publish="publishWebsite"
      />

      <!-- New Shoot Tab -->
      <NewShoot
        v-if="activeTab === 'new-shoot'"
        @close="closeNewShootTab"
        @save="handleNewShootSave"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import DashboardHeader from './AdminComponent/DashboardHeader.vue';
import OverviewTab from './AdminComponent/OverviewTab.vue';
import ShootsTab from './AdminComponent/ShootTab.vue';
import GalleryTab from './AdminComponent/GalleryTab.vue';
import WebsiteTab from './AdminComponent/WebsiteTab.vue';
import NewShoot from './AdminComponent/NewShoot/NewShoot.vue'; // Import your form

const tabs = ref([
  { id: 'overview', name: 'Overview', icon: 'bi bi-camera-fill' },
  { id: 'shoots', name: 'All Shoots', icon: 'bi bi-images' },
  { id: 'galleries', name: 'Client Galleries', icon: 'bi bi-share-fill' },
  { id: 'website', name: 'Website Builder', icon: 'bi bi-gear-fill' }
]);
const activeTab = ref('overview');
const showNewShootTab = ref(false);
const activeShootType = ref('All');

const shootTypes = [
  { id: 'All', name: 'All Shoots', icon: 'bi bi-camera-fill' },
  { id: 'Wedding', name: 'Wedding', icon: 'bi bi-heart-fill' },
  { id: 'Birthday', name: 'Birthday', icon: 'bi bi-gift-fill' },
  { id: 'Model', name: 'Model', icon: 'bi bi-person-bounding-box' },
  { id: 'Baby', name: 'Baby Shoot', icon: 'bi bi-emoji-smile-fill' },
  { id: 'Puberty', name: 'Puberty Ceremony', icon: 'bi bi-stars' },
  { id: 'Events', name: 'Events', icon: 'bi bi-briefcase-fill' },
  { id: 'Videography', name: 'Videography', icon: 'bi bi-camera-reels-fill' }
];

const stats = ref({
  totalShoots: 42,
  totalImages: 8400,
  pendingReviews: 18,
  completedAlbums: 28,
  totalStorage: '420 GB',
  monthlyUploads: '2.1 TB',
  activeGalleries: 15,
  downloadRequests: 67
});

const statCards = [
  { title: 'Total Shoots', value: stats.value.totalShoots, icon: '📸', change: '+12%' },
  { title: 'Total Images', value: stats.value.totalImages.toLocaleString(), icon: '🖼️', change: '+8.2%' },
  { title: 'Pending Reviews', value: stats.value.pendingReviews, icon: '⏳', change: '-5.1%' },
  { title: 'Active Galleries', value: stats.value.activeGalleries, icon: '👁️', change: '+15.3%' }
];

const recentShoots = ref([
  { id: 1, client: 'John & Sarah', type: 'Wedding', date: '2024-06-15', images: 245, status: 'pending_review', lastActivity: '2 hours ago', verified: true },
  { id: 2, client: 'Emma Johnson', type: 'Birthday', date: '2024-06-14', images: 89, status: 'album_ready', lastActivity: '5 hours ago', verified: true },
  { id: 3, client: 'Isabella Martinez', type: 'Model', date: '2024-06-13', images: 156, status: 'completed', lastActivity: '1 day ago', verified: false },
  { id: 4, client: 'Baby Oliver', type: 'Baby', date: '2024-06-12', images: 78, status: 'uploaded', lastActivity: '2 days ago', verified: true },
  { id: 5, client: 'Maya Patel', type: 'Puberty', date: '2024-06-10', images: 134, status: 'pending_review', lastActivity: '3 days ago', verified: true },
  { id: 6, client: 'Corporate Event XYZ', type: 'Events', date: '2024-06-08', images: 198, status: 'album_ready', lastActivity: '5 days ago', verified: true }
]);

const filteredShoots = computed(() =>
  activeShootType.value === 'All'
    ? recentShoots.value
    : recentShoots.value.filter(shoot => shoot.type === activeShootType.value)
);

function getStatusText(status) {
  const texts = {
    uploaded: 'Uploaded',
    pending_review: 'Pending Review',
    album_ready: 'Album Ready',
    completed: 'Completed'
  };
  return texts[status] || status;
}

function getTypeIcon(type) {
  const found = shootTypes.find(t => t.name === type);
  return found ? found.icon.replace('bi ', '').replace('-fill', '').replace('-', ' ').toUpperCase() : '📸';
}

function copyGalleryLink(client) {
  const link = `https://gallery.studio.com/${client.toLowerCase().replace(/\s+/g, '-')}-2024`;
  navigator.clipboard.writeText(link);
  alert('Gallery link copied to clipboard!');
}

const fileInput = ref(null);
function triggerFileInput() {
  fileInput.value && fileInput.value.click();
}
function handleFileUpload(e) {
  // handle upload logic here
  alert(`${e.target.files.length} file(s) selected`);
}

const websiteSettings = ref({
  studioName: 'Elite Photography Studio',
  tagline: 'Capturing Your Perfect Moments',
  primaryColor: '#ff6b35',
  secondaryColor: '#000000',
  heroMessage: 'Welcome to our photography studio where every moment becomes a masterpiece.',
  aboutText: 'We are passionate photographers dedicated to capturing your most precious moments.',
  phone: '+1 (555) 123-4567',
  email: 'info@elitephotography.com',
  address: '123 Photography Lane, Studio City, CA 90210',
  socialLinks: '@elitephotography'
});

// --- Add the function here ---
function openNewShootTab() {
  if (!tabs.value.find(tab => tab.id === 'new-shoot')) {
    tabs.value.push({
      id: 'new-shoot',
      name: 'New Shoot',
      icon: 'bi bi-plus-circle'
    });
  }
  activeTab.value = 'new-shoot';
}
// --- End function ---
</script>

<style scoped>
.bg-orange {
  background: #ff6b35 !important;
  color: #fff !important;
}

.nav-gradient-active {
  background: linear-gradient(90deg, #ff6b35 60%, #f7931e 100%) !important;
  color: #fff !important;
  border: none;
  box-shadow: 0 2px 8px rgba(255, 107, 53, 0.08);
}
/* Your CSS here */
</style>


