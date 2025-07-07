<template>
  <div class="shoots-tab">
    <!-- Statistics Overview -->
  
    <!-- Upload Zone -->
    <div class="upload-zone mb-4" @click="$emit('trigger-file-input')">
      <div class="upload-content">
        <div class="upload-icon">
          <i class="bi bi-cloud-arrow-up"></i>
        </div>
        <h5 class="upload-title">Upload New Shoot Images</h5>
        <p class="upload-description">
          Drag and drop your RAW/JPG images here or click to browse
        </p>
        <div class="upload-specs">
          <span class="spec-item">
            <i class="bi bi-file-earmark-image"></i>
            RAW, JPG, PNG
          </span>
          <span class="spec-item">
            <i class="bi bi-hdd"></i>
            Max 50MB per image
          </span>
          <span class="spec-item">
            <i class="bi bi-stack"></i>
            Up to 500 images
          </span>
        </div>
        <button class="btn btn-warning text-dark mt-3">
          <i class="bi bi-plus-circle me-2"></i>
          Select Images
        </button>
      </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section mb-4">
      <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">
        <div class="filter-group">
          <h6 class="filter-title">Filter by Type</h6>
          <div class="filter-buttons">
            <button
              v-for="type in shootTypes"
              :key="type.id"
              class="filter-btn"
              :class="{ 'active': activeShootType === type.id }"
              @click="$emit('update:activeShootType', type.id)"
            >
              <i :class="type.icon"></i>
              <span>{{ type.name }}</span>
              <div class="filter-count">{{ getTypeCount(type.id) }}</div>
            </button>
          </div>
        </div>

        <div class="view-controls">
          <div class="btn-group" role="group">
            <button
              class="btn btn-outline-secondary"
              :class="{ 'active': viewMode === 'grid' }"
              @click="viewMode = 'grid'"
            >
              <i class="bi bi-grid-3x3-gap"></i>
            </button>
            <button
              class="btn btn-outline-secondary"
              :class="{ 'active': viewMode === 'list' }"
              @click="viewMode = 'list'"
            >
              <i class="bi bi-list"></i>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- New Shoot Button -->
    <div class="d-flex justify-content-end mb-3">
      <button class="btn btn-orange" @click="$emit('open-new-shoot-tab')">
        <i class="bi bi-plus-circle me-2"></i>
        New Shoot
      </button>
    </div>

    <!-- Shoots Display -->
    <div v-if="filteredShoots.length === 0" class="empty-state">
      <div class="empty-icon">
        <i class="bi bi-camera"></i>
      </div>
      <h5>No shoots found</h5>
      <p>No shoots match your current filter. Try selecting a different type or upload new images.</p>
    </div>

    <!-- Grid View -->
    <div v-else-if="viewMode === 'grid'" class="shoots-grid">
      <div class="row g-3 g-md-4">
        <div
          v-for="shoot in filteredShoots"
          :key="shoot.id"
          class="col-12 col-sm-6 col-lg-4 col-xl-3"
        >
          <div class="shoot-card">
            <!-- Shoot Header -->
            <div class="shoot-header">
              <div class="shoot-type">
                <i :class="getShootTypeIcon(shoot.type)"></i>
                <span>{{ shoot.type }}</span>
              </div>
              <div class="shoot-status" :class="getStatusClass(shoot.status)">
                {{ getStatusText(shoot.status) }}
              </div>
            </div>

            <!-- Shoot Info -->
            <div class="shoot-info">
              <h6 class="shoot-client">{{ shoot.client }}</h6>
              <div class="shoot-meta">
                <div class="meta-item">
                  <i class="bi bi-calendar3"></i>
                  <span>{{ formatDate(shoot.date) }}</span>
                </div>
                <div class="meta-item">
                  <i class="bi bi-images"></i>
                  <span>{{ shoot.images }} images</span>
                </div>
                <div class="meta-item">
                  <i class="bi bi-clock"></i>
                  <span>{{ shoot.lastActivity }}</span>
                </div>
              </div>
            </div>

            <!-- Shoot Actions -->
            <div class="shoot-actions">
              <button
                class="action-btn primary"
                @click="$emit('copy-gallery-link', shoot.client)"
                title="Copy Gallery Link"
              >
                <i class="bi bi-link-45deg"></i>
                <span>Share</span>
              </button>
              <button
                class="action-btn secondary"
                @click="viewShoot(shoot)"
                title="View Images"
              >
                <i class="bi bi-eye"></i>
                <span>View</span>
              </button>
              <button
                class="action-btn success"
                @click="downloadShoot(shoot)"
                title="Download Selected"
                :disabled="shoot.status === 'uploaded'"
              >
                <i class="bi bi-download"></i>
                <span>Download</span>
              </button>
            </div>

            <!-- Progress Bar for Uploads -->
            <div v-if="shoot.status === 'uploading'" class="upload-progress">
              <div class="progress">
                <div
                  class="progress-bar bg-warning"
                  :style="{ width: (shoot.uploadProgress || 0) + '%' }"
                ></div>
              </div>
              <small class="text-muted">{{ shoot.uploadProgress || 0 }}% uploaded</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- List View -->
    <div v-else class="shoots-list">
      <div class="list-header d-none d-md-flex">
        <div class="col-header" style="flex: 2;">Client & Type</div>
        <div class="col-header" style="flex: 1;">Date</div>
        <div class="col-header" style="flex: 1;">Images</div>
        <div class="col-header" style="flex: 1;">Status</div>
        <div class="col-header" style="flex: 1;">Actions</div>
      </div>

      <div class="list-items">
        <div
          v-for="shoot in filteredShoots"
          :key="shoot.id"
          class="list-item"
        >
          <div class="list-content">
            <div class="list-main">
              <div class="list-client">
                <div class="client-info">
                  <div class="client-name">{{ shoot.client }}</div>
                  <div class="client-type">
                    <i :class="getShootTypeIcon(shoot.type)"></i>
                    {{ shoot.type }}
                  </div>
                </div>
              </div>

              <div class="list-details d-none d-md-flex">
                <div class="detail-item">{{ formatDate(shoot.date) }}</div>
                <div class="detail-item">{{ shoot.images }} images</div>
                <div class="detail-item">
                  <span class="status-badge" :class="getStatusClass(shoot.status)">
                    {{ getStatusText(shoot.status) }}
                  </span>
                </div>
              </div>
            </div>

            <div class="list-actions">
              <div class="action-buttons">
                <button
                  class="btn btn-sm btn-outline-warning"
                  @click="$emit('copy-gallery-link', shoot.client)"
                  title="Copy Gallery Link"
                >
                  <i class="bi bi-link-45deg"></i>
                </button>
                <button
                  class="btn btn-sm btn-outline-info"
                  @click="viewShoot(shoot)"
                  title="View Images"
                >
                  <i class="bi bi-eye"></i>
                </button>
                <button
                  class="btn btn-sm btn-outline-success"
                  @click="downloadShoot(shoot)"
                  title="Download Selected"
                  :disabled="shoot.status === 'uploaded'"
                >
                  <i class="bi bi-download"></i>
                </button>
              </div>
            </div>
          </div>

          <!-- Mobile Details -->
          <div class="mobile-details d-md-none">
            <div class="mobile-meta">
              <span class="meta-badge">{{ formatDate(shoot.date) }}</span>
              <span class="meta-badge">{{ shoot.images }} images</span>
              <span class="status-badge" :class="getStatusClass(shoot.status)">
                {{ getStatusText(shoot.status) }}
              </span>
            </div>
            <div class="last-activity">
              <i class="bi bi-clock"></i>
              {{ shoot.lastActivity }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  shootTypes: Array,
  activeShootType: String,
  filteredShoots: Array,
  getTypeIcon: Function,
  getStatusText: Function
})

const emit = defineEmits(['update:activeShootType', 'trigger-file-input', 'copy-gallery-link'])

const viewMode = ref('grid')

// Computed statistics
const totalShoots = computed(() => props.filteredShoots.length)
const pendingShoots = computed(() =>
  props.filteredShoots.filter(shoot => shoot.status === 'pending_review').length
)
const completedShoots = computed(() =>
  props.filteredShoots.filter(shoot => shoot.status === 'completed').length
)
const totalImages = computed(() =>
  props.filteredShoots.reduce((total, shoot) => total + shoot.images, 0)
)

// Helper functions
function getTypeCount(typeId) {
  if (typeId === 'All') return props.filteredShoots.length
  return props.filteredShoots.filter(shoot => shoot.type === typeId).length
}

function getShootTypeIcon(type) {
  const icons = {
    'Wedding': 'bi bi-heart-fill',
    'Birthday': 'bi bi-gift-fill',
    'Model': 'bi bi-person-bounding-box',
    'Baby': 'bi bi-emoji-smile-fill',
    'Puberty': 'bi bi-stars',
    'Events': 'bi bi-briefcase-fill',
    'Videography': 'bi bi-camera-reels-fill'
  }
  return icons[type] || 'bi bi-camera-fill'
}

function getStatusClass(status) {
  const classes = {
    'uploaded': 'status-uploaded',
    'pending_review': 'status-pending',
    'album_ready': 'status-ready',
    'completed': 'status-completed',
    'uploading': 'status-uploading'
  }
  return classes[status] || 'status-default'
}

function formatDate(dateString) {
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric'
  })
}

function viewShoot(shoot) {
  // Navigate to shoot detail view
  console.log('Viewing shoot:', shoot.id)
}

function downloadShoot(shoot) {
  // Handle download selected images
  console.log('Downloading shoot:', shoot.id)
}
</script>

<style scoped>
.shoots-tab {
  color: white;
}

/* Statistics Overview */
.stats-overview {
  margin-bottom: 2rem;
}

.stat-card {
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 107, 53, 0.2);
  border-radius: 12px;
  padding: 1.5rem 1rem;
  text-align: center;
  transition: all 0.3s ease;
}

.stat-card:hover {
  background: rgba(255, 107, 53, 0.1);
  transform: translateY(-2px);
}

.stat-icon {
  font-size: 2rem;
  margin-bottom: 0.5rem;
}

.stat-value {
  font-size: 1.5rem;
  font-weight: bold;
  color: #ff6b35;
  margin-bottom: 0.25rem;
}

.stat-label {
  font-size: 0.85rem;
  color: rgba(255, 255, 255, 0.7);
}

/* Upload Zone */
.upload-zone {
  background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(255, 107, 53, 0.05));
  border: 2px dashed rgba(255, 107, 53, 0.3);
  border-radius: 16px;
  padding: 3rem 2rem;
  text-align: center;
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.upload-zone::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 107, 53, 0.1), transparent);
  transition: left 0.5s ease;
}

.upload-zone:hover::before {
  left: 100%;
}

.upload-zone:hover {
  border-color: #ff6b35;
  background: rgba(255, 107, 53, 0.15);
  transform: translateY(-2px);
}

.upload-content {
  position: relative;
  z-index: 1;
}

.upload-icon {
  font-size: 3rem;
  color: #ff6b35;
  margin-bottom: 1rem;
}

.upload-title {
  color: white;
  margin-bottom: 0.5rem;
}

.upload-description {
  color: rgba(255, 255, 255, 0.7);
  margin-bottom: 1.5rem;
}

.upload-specs {
  display: flex;
  justify-content: center;
  gap: 2rem;
  margin-bottom: 1.5rem;
  flex-wrap: wrap;
}

.spec-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.85rem;
  color: rgba(255, 255, 255, 0.6);
}

.spec-item i {
  color: #ff6b35;
}

/* Filter Section */
.filter-section {
  background: rgba(255, 255, 255, 0.05);
  border-radius: 12px;
  padding: 1.5rem;
  border: 1px solid rgba(255, 107, 53, 0.1);
}

.filter-title {
  color: white;
  margin-bottom: 1rem;
  font-size: 0.9rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.filter-buttons {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
}

.filter-btn {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 107, 53, 0.2);
  border-radius: 8px;
  color: rgba(255, 255, 255, 0.7);
  transition: all 0.3s ease;
  cursor: pointer;
  position: relative;
}

.filter-btn:hover {
  background: rgba(255, 107, 53, 0.1);
  color: #ff6b35;
  transform: translateY(-1px);
}

.filter-btn.active {
  background: #ff6b35;
  color: #000;
  border-color: #ff6b35;
}

.filter-count {
  background: rgba(255, 255, 255, 0.2);
  border-radius: 12px;
  padding: 0.125rem 0.5rem;
  font-size: 0.75rem;
  margin-left: 0.5rem;
}

.filter-btn.active .filter-count {
  background: rgba(0, 0, 0, 0.2);
}

.view-controls .btn {
  border-color: rgba(255, 107, 53, 0.3);
  color: rgba(255, 255, 255, 0.7);
}

.view-controls .btn.active,
.view-controls .btn:hover {
  background: #ff6b35;
  color: #000;
  border-color: #ff6b35;
}

/* Empty State */
.empty-state {
  text-align: center;
  padding: 4rem 2rem;
  color: rgba(255, 255, 255, 0.6);
}

.empty-icon {
  font-size: 4rem;
  margin-bottom: 1rem;
  opacity: 0.5;
}

/* Shoot Cards */
.shoots-grid {
  margin-top: 1rem;
}

.shoot-card {
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 107, 53, 0.2);
  border-radius: 12px;
  padding: 1.5rem;
  height: 100%;
  transition: all 0.3s ease;
  display: flex;
  flex-direction: column;
}

.shoot-card:hover {
  background: rgba(255, 107, 53, 0.1);
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(255, 107, 53, 0.2);
}

.shoot-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.shoot-type {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.85rem;
  color: rgba(255, 255, 255, 0.7);
}

.shoot-type i {
  color: #ff6b35;
}

.shoot-status {
  padding: 0.25rem 0.75rem;
  border-radius: 12px;
  font-size: 0.75rem;
  font-weight: 500;
}

.status-uploaded { background: rgba(108, 117, 125, 0.2); color: #6c757d; }
.status-pending { background: rgba(255, 193, 7, 0.2); color: #ffc107; }
.status-ready { background: rgba(13, 202, 240, 0.2); color: #0dcaf0; }
.status-completed { background: rgba(25, 135, 84, 0.2); color: #198754; }
.status-uploading { background: rgba(255, 107, 53, 0.2); color: #ff6b35; }

.shoot-info {
  flex: 1;
  margin-bottom: 1rem;
}

.shoot-client {
  color: white;
  margin-bottom: 0.75rem;
  font-weight: 600;
}

.shoot-meta {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.meta-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.85rem;
  color: rgba(255, 255, 255, 0.6);
}

.meta-item i {
  color: #ff6b35;
  width: 12px;
}

.shoot-actions {
  display: flex;
  gap: 0.5rem;
}

.action-btn {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 0.25rem;
  padding: 0.75rem 0.5rem;
  border: 1px solid transparent;
  border-radius: 8px;
  background: rgba(255, 255, 255, 0.05);
  color: rgba(255, 255, 255, 0.7);
  transition: all 0.3s ease;
  cursor: pointer;
  font-size: 0.75rem;
}

.action-btn:hover {
  transform: translateY(-1px);
}

.action-btn.primary {
  border-color: rgba(255, 107, 53, 0.3);
}

.action-btn.primary:hover {
  background: #ff6b35;
  color: #000;
}

.action-btn.secondary {
  border-color: rgba(13, 202, 240, 0.3);
}

.action-btn.secondary:hover {
  background: #0dcaf0;
  color: #000;
}

.action-btn.success {
  border-color: rgba(25, 135, 84, 0.3);
}

.action-btn.success:hover {
  background: #198754;
  color: white;
}

.action-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.upload-progress {
  margin-top: 1rem;
  padding-top: 1rem;
  border-top: 1px solid rgba(255, 107, 53, 0.2);
}

.progress {
  height: 4px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 2px;
  margin-bottom: 0.5rem;
}

.progress-bar {
  border-radius: 2px;
}

/* List View */
.shoots-list {
  background: rgba(255, 255, 255, 0.05);
  border-radius: 12px;
  overflow: hidden;
  border: 1px solid rgba(255, 107, 53, 0.1);
}

.list-header {
  background: rgba(255, 107, 53, 0.1);
  padding: 1rem 1.5rem;
  font-weight: 600;
  font-size: 0.85rem;
  color: #ff6b35;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.col-header {
  flex: 1;
}

.list-items {
  max-height: 600px;
  overflow-y: auto;
}

.list-item {
  border-bottom: 1px solid rgba(255, 107, 53, 0.1);
  transition: background 0.3s ease;
}

.list-item:hover {
  background: rgba(255, 107, 53, 0.05);
}

.list-item:last-child {
  border-bottom: none;
}

.list-content {
  display: flex;
  align-items: center;
  padding: 1rem 1.5rem;
}

.list-main {
  display: flex;
  flex: 1;
  align-items: center;
}

.list-client {
  flex: 2;
}

.client-info {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}

.client-name {
  font-weight: 600;
  color: white;
}

.client-type {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.85rem;
  color: rgba(255, 255, 255, 0.6);
}

.client-type i {
  color: #ff6b35;
}

.list-details {
  flex: 3;
  display: flex;
  align-items: center;
}

.detail-item {
  flex: 1;
  font-size: 0.9rem;
  color: rgba(255, 255, 255, 0.7);
}

.status-badge {
  padding: 0.25rem 0.75rem;
  border-radius: 12px;
  font-size: 0.75rem;
  font-weight: 500;
}

.list-actions {
  flex-shrink: 0;
}

.action-buttons {
  display: flex;
  gap: 0.5rem;
}

.mobile-details {
  padding: 0 1.5rem 1rem;
}

.mobile-meta {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  margin-bottom: 0.5rem;
}

.meta-badge {
  padding: 0.25rem 0.5rem;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 8px;
  font-size: 0.75rem;
  color: rgba(255, 255, 255, 0.7);
}

.last-activity {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.85rem;
  color: rgba(255, 255, 255, 0.6);
}

.last-activity i {
  color: #ff6b35;
}

/* New Shoot Button */
.btn-orange {
  background: linear-gradient(90deg, #ff6b35 60%, #f7931e 100%);
  color: #fff;
  border: none;
  font-weight: 600;
  border-radius: 8px;
  transition: background 0.2s;
}

.btn-orange:hover {
  background: #ff6b35;
  color: #fff;
}

/* Responsive Design */
@media (max-width: 768px) {
  .upload-zone {
    padding: 2rem 1rem;
  }

  .upload-specs {
    flex-direction: column;
    gap: 0.5rem;
  }

  .filter-section {
    padding: 1rem;
  }

  .filter-buttons {
    gap: 0.25rem;
  }

  .filter-btn {
    padding: 0.4rem 0.8rem;
    font-size: 0.85rem;
  }

  .shoot-card {
    padding: 1rem;
  }

  .action-btn {
    padding: 0.5rem 0.25rem;
    font-size: 0.7rem;
  }
}

@media (max-width: 576px) {
  .stats-overview .stat-card {
    padding: 1rem 0.5rem;
  }

  .stat-value {
    font-size: 1.25rem;
  }

  .upload-zone {
    padding: 1.5rem 1rem;
  }

  .upload-icon {
    font-size: 2.5rem;
  }

  .shoot-actions {
    flex-direction: column;
    gap: 0.25rem;
  }

  .action-btn {
    flex-direction: row;
    justify-content: center;
    padding: 0.5rem;
  }
}
</style>
