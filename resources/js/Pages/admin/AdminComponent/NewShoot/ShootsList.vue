<template>
  <div class="shoots-list">
    <h4 class="mb-3 text-white">
      <i class="fas fa-list me-2"></i>Manage Shoots
    </h4>
    <div v-if="shoots.length === 0" class="text-center text-muted py-5">
      <i class="fas fa-camera fa-2x mb-3"></i>
      <div>No shoots found. Create a new shoot to get started.</div>
    </div>
    <div v-else class="row">
      <div class="col-12 mb-4" v-for="shoot in shoots" :key="shoot.id">
        <div class="card bg-dark border-secondary">
          <div class="card-header bg-gradient-orange text-white d-flex justify-content-between align-items-center">
            <div>
              <h5 class="mb-0">{{ shoot.clientName }}</h5>
              <small>{{ shoot.shootType }} - {{ shoot.date }}</small>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-sm btn-outline-light" @click="toggleShootDetails(shoot.id)">
                <i class="fas fa-eye"></i>
              </button>
              <button class="btn btn-sm btn-outline-light" @click="shareShoot(shoot)">
                <i class="fas fa-share"></i>
              </button>
              <button class="btn btn-sm btn-outline-danger" @click="deleteShoot(shoot.id)">
                <i class="fas fa-trash-alt"></i>
              </button>
            </div>
          </div>
          <div v-if="expandedShootId === shoot.id" class="card-body">
            <div class="row mb-4">
              <div class="col-md-8">
                <p class="text-light mb-2">
                  <strong>Description:</strong> {{ shoot.description || 'No description' }}
                </p>
                <p class="text-light mb-2">
                  <strong>Client Email:</strong> {{ shoot.clientEmail }}
                </p>
                <p class="text-light mb-0">
                  <strong>Status:</strong>
                  <span class="badge bg-success ms-2">{{ shoot.status }}</span>
                </p>
              </div>
              <div class="col-md-4 text-end">
                <div class="mb-2">
                  <small class="text-muted">Share Link:</small>
                  <div class="input-group input-group-sm">
                    <input
                      type="text"
                      class="form-control bg-dark text-light border-secondary"
                      :value="shoot.shareLink || 'https://yourdomain.com/gallery/abc123'"
                      readonly
                    >
                    <button class="btn btn-outline-orange btn-sm" @click="copyLink(shoot)">
                      <i class="fas fa-copy"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Subcategories Section -->
            <div class="subcategories-section mb-4">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="text-orange mb-0">
                  <i class="fas fa-tags me-2"></i>Subcategories
                </h6>
                <button class="btn btn-sm btn-outline-orange">
                  <i class="fas fa-plus me-1"></i>Add Subcategory
                </button>
              </div>
              <div class="row">
                <div class="col-md-4 col-sm-6 mb-2">
                  <div class="badge-card bg-secondary p-2 rounded d-flex justify-content-between align-items-center">
                    <div>
                      <span class="text-light">Subcategory Name</span>
                      <small class="text-muted d-block">0 images</small>
                    </div>
                    <button class="btn btn-sm btn-outline-danger">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Image Upload Section -->
            <div class="upload-section">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="text-orange mb-0">
                  <i class="fas fa-upload me-2"></i>Upload Images
                </h6>
              </div>
              <div class="row mb-3">
                <div class="col-md-6">
                  <label class="form-label text-light">Select Subcategory for Upload</label>
                  <select class="form-select bg-dark text-light border-secondary">
                    <option value="">Choose subcategory...</option>
                    <option>Subcategory Name</option>
                  </select>
                </div>
              </div>
              <div class="upload-dropzone border border-dashed border-secondary rounded p-4 text-center mb-3">
                <i class="fas fa-cloud-upload-alt fa-3x text-orange mb-3"></i>
                <p class="text-light mb-2">Drag & drop images here or</p>
                <button class="btn btn-outline-orange">
                  <i class="fas fa-folder-open me-2"></i>Browse Files
                </button>
                <input
                  type="file"
                  style="display: none;"
                >
                <small class="text-muted d-block mt-2">
                  Supported formats: JPG, PNG, RAW (.cr2, .nef, .arw)
                </small>
              </div>
              <div class="uploaded-images">
                <h6 class="text-light mb-3">
                  <i class="fas fa-images me-2"></i>Uploaded Images (0)
                </h6>
                <div class="row">
                  <div class="col-md-2 col-sm-3 col-4 mb-3">
                    <div class="image-card bg-secondary rounded p-2">
                      <div class="image-thumbnail mb-2">
                        <img
                          src="https://via.placeholder.com/300x200?text=Image"
                          alt="Image"
                          class="img-fluid rounded"
                          style="height: 80px; width: 100%; object-fit: cover;"
                        >
                      </div>
                      <small class="text-light d-block text-truncate">Image Name</small>
                      <small class="text-muted">0 MB</small>
                      <div class="mt-1">
                        <button class="btn btn-sm btn-outline-danger">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div v-if="expandedShootId === shoot.id" class="card-body">
              <!-- all details here -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

// Example shoots data for prototype/demo
const shoots = ref([
  {
    id: 1,
    clientName: 'John Doe',
    shootType: 'Wedding',
    date: '2025-06-22',
    clientEmail: 'john@example.com',
    description: 'Outdoor wedding shoot at the park.',
    status: 'Active',
    shareLink: 'https://yourdomain.com/gallery/abc123'
  },
  {
    id: 2,
    clientName: 'Jane Smith',
    shootType: 'Birthday',
    date: '2025-06-15',
    clientEmail: 'jane@example.com',
    description: 'Birthday party shoot.',
    status: 'Active',
    shareLink: 'https://yourdomain.com/gallery/def456'
  }
])

const expandedShootId = ref(null)

function toggleShootDetails(id) {
  expandedShootId.value = expandedShootId.value === id ? null : id
}

function viewShoot(shoot) {
  alert(`Viewing shoot for ${shoot.clientName}`)
}

function shareShoot(shoot) {
  alert(`Share link: ${shoot.shareLink}`)
}

function deleteShoot(id) {
  if (confirm('Are you sure you want to delete this shoot?')) {
    const idx = shoots.value.findIndex(s => s.id === id)
    if (idx !== -1) shoots.value.splice(idx, 1)
  }
}

function copyLink(shoot) {
  navigator.clipboard.writeText(shoot.shareLink || '')
  alert('Link copied to clipboard!')
}
</script>

<style scoped>
.card {
  background: rgba(30,41,59,0.92);
  border-radius: 16px;
  box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18), 0 1.5px 8px 0 #ff6b3533;
  border: none;
  transition: transform 0.18s cubic-bezier(.4,2,.6,1), box-shadow 0.18s;
}
.card:hover {
  transform: translateY(-4px) scale(1.03);
  box-shadow: 0 16px 40px 0 rgba(255,107,53,0.18), 0 2px 16px 0 #ff6b3533;
}
.bg-gradient-orange {
  background: linear-gradient(90deg, #ff6b35 60%, #f7931e 100%);
}
.btn-orange, .btn-outline-orange {
  background: linear-gradient(90deg, #ff6b35 60%, #f7931e 100%);
  color: #fff;
  border: none;
  font-weight: 700;
  border-radius: 10px;
  box-shadow: 0 2px 8px 0 #ff6b3533;
  padding: 0.5rem 1.2rem;
  font-size: 1rem;
  transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
}
.btn-outline-orange {
  background: transparent;
  color: #ff6b35;
  border: 2px solid #ff6b35;
}
.btn-outline-orange:hover, .btn-orange:hover {
  background: #ff6b35;
  color: #fff;
  box-shadow: 0 6px 24px rgba(255, 107, 53, 0.25);
  transform: translateY(-2px) scale(1.03);
}
.input-group .form-control:focus {
  border-color: #ff6b35;
  box-shadow: 0 0 0 0.2rem rgba(255,107,53,0.25);
}
</style>
