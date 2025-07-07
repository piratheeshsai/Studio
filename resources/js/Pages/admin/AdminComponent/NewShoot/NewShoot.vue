<template>
  <div class="shoot-management p-4">
    <!-- Create New Shoot Form -->
     <NewShootForm
      :editMode="editMode"
      :editShoot="editShoot"
      @shoot-created="handleShootCreated"
      @shoot-updated="handleShootUpdated"
      @cancel-edit="cancelEdit"
    />



     <!-- Existing Shoots Management -->
    <ShootsList
      :shoots="shoots"
      @edit-shoot="handleEditShoot"
      @shoot-deleted="handleShootDeleted"
    />


    <!-- Customer Gallery Modal (Preview) -->
    <div v-if="showCustomerGallery" class="modal fade show d-block" style="background: rgba(0,0,0,0.8);">
      <div class="modal-dialog modal-xl">
        <div class="modal-content bg-dark">
          <div class="modal-header border-secondary">
            <h5 class="modal-title text-white">Customer Gallery Preview</h5>
            <button type="button" class="btn-close btn-close-white" @click="showCustomerGallery = false"></button>
          </div>
          <div class="modal-body">
            <!-- Customer Verification Form -->
            <div v-if="!customerVerified" class="verification-form text-center">
              <h6 class="text-orange mb-4">Please verify your contact details</h6>
              <div class="row justify-content-center">
                <div class="col-md-6">
                  <div class="mb-3">
                    <input
                      type="email"
                      class="form-control bg-dark text-light border-secondary"
                      placeholder="Enter your email"
                      v-model="customerVerification.email"
                    >
                  </div>
                  <div class="mb-3">
                    <input
                      type="tel"
                      class="form-control bg-dark text-light border-secondary"
                      placeholder="Enter your phone number"
                      v-model="customerVerification.phone"
                    >
                  </div>
                  <button class="btn btn-orange" @click="verifyCustomer">
                    <i class="fas fa-check me-2"></i>Verify & Continue
                  </button>
                </div>
              </div>
            </div>

            <!-- Customer Image Gallery -->
            <div v-if="customerVerified" class="customer-gallery">
              <div class="text-center mb-4">
                <h6 class="text-orange">Select images for your album</h6>
                <p class="text-light">{{ selectedImages.length }} images selected</p>
              </div>
              <div class="row">
                <div v-for="image in galleryImages" :key="image.id" class="col-md-3 col-sm-4 col-6 mb-3">
                  <div
                    class="gallery-image-card position-relative"
                    :class="{ 'selected': selectedImages.includes(image.id) }"
                    @click="toggleImageSelection(image.id)"
                  >
                    <img
                      :src="image.preview"
                      :alt="image.name"
                      class="img-fluid rounded"
                      style="height: 150px; width: 100%; object-fit: cover; cursor: pointer;"
                    >
                    <div v-if="selectedImages.includes(image.id)" class="selection-overlay">
                      <i class="fas fa-check-circle fa-2x text-orange"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="text-center mt-4">
                <button
                  class="btn btn-orange"
                  @click="submitSelectedImages"
                  :disabled="selectedImages.length === 0"
                >
                  <i class="fas fa-download me-2"></i>Submit Selection ({{ selectedImages.length }} images)
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div>
      <button>
        Click me
      </button>
    </div>
  </div>
</template>

<script>
import NewShootForm from './NewShootForm.vue'
import ShootsList from './ShootsList.vue'

export default {
  components: {
    NewShootForm,
    ShootsList
  },
  data() {
    return {
      newShoot: {
        clientName: '',
        shootType: '',
        date: '',
        clientEmail: '',
        description: ''
      },
      shoots: [
        {
          id: 1,
          clientName: 'John & Sarah Wedding',
          shootType: 'Wedding',
          date: '2024-06-15',
          clientEmail: 'john.sarah@email.com',
          description: 'Beautiful outdoor wedding ceremony and reception',
          status: 'Active',
          subcategories: [
            { id: 1, name: 'Couple Shoot', imageCount: 45 },
            { id: 2, name: 'Mehendi', imageCount: 67 },
            { id: 3, name: 'Reception', imageCount: 89 }
          ],
          shareLink: 'https://yourdomain.com/gallery/abc123',
          uploadedImages: []
        }
      ],
      expandedShoot: null,
      addingSubcategoryFor: null,
      newSubcategory: { name: '' },
      selectedSubcategoryForUpload: {},
      dragOver: {},
      uploadProgress: {},
      showCustomerGallery: false,
      customerVerified: false,
      customerVerification: {
        email: '',
        phone: ''
      },
      galleryImages: [],
      selectedImages: []
    }
  },
  methods: {
    createShoot() {
      const shoot = {
        id: Date.now(), // In real app, this would come from backend
        ...this.newShoot,
        status: 'Active',
        subcategories: [],
        uploadedImages: []
      };

      this.shoots.push(shoot);

      // Reset form
      this.newShoot = {
        clientName: '',
        shootType: '',
        date: '',
        clientEmail: '',
        description: ''
      };

      // Show success message (you can integrate with your notification system)
      alert('Shoot created successfully!');
    },

    toggleShootDetails(shootId) {
      this.expandedShoot = this.expandedShoot === shootId ? null : shootId;
    },

    showAddSubcategory(shootId) {
      this.addingSubcategoryFor = shootId;
      this.newSubcategory.name = '';
    },

    addSubcategory(shootId) {
      if (!this.newSubcategory.name.trim()) return;

      const shoot = this.shoots.find(s => s.id === shootId);
      if (shoot) {
        shoot.subcategories.push({
          id: Date.now(),
          name: this.newSubcategory.name.trim(),
          imageCount: 0
        });
      }

      this.cancelAddSubcategory();
    },

    cancelAddSubcategory() {
      this.addingSubcategoryFor = null;
      this.newSubcategory.name = '';
    },

    removeSubcategory(shootId, subcategoryId) {
      const shoot = this.shoots.find(s => s.id === shootId);
      if (shoot) {
        shoot.subcategories = shoot.subcategories.filter(sc => sc.id !== subcategoryId);
      }
    },

    triggerFileInput(shootId) {
      const fileInput = this.$refs[`fileInput-${shootId}`];
      if (fileInput && fileInput[0]) {
        fileInput[0].click();
      }
    },

    handleFileSelect(event, shootId) {
      const files = Array.from(event.target.files);
      this.processFiles(files, shootId);
    },

    handleDrop(event, shootId) {
      this.dragOver[shootId] = false;
      const files = Array.from(event.dataTransfer.files);
      this.processFiles(files, shootId);
    },

    processFiles(files, shootId) {
      if (!this.selectedSubcategoryForUpload[shootId]) {
        alert('Please select a subcategory first');
        return;
      }

      const shoot = this.shoots.find(s => s.id === shootId);
      if (!shoot) return;

      // Simulate upload progress
      this.uploadProgress[shootId] = 0;
      const progressInterval = setInterval(() => {
        this.uploadProgress[shootId] += 10;
        if (this.uploadProgress[shootId] >= 100) {
          clearInterval(progressInterval);
          setTimeout(() => {
            this.uploadProgress[shootId] = null;
            this.addUploadedImages(files, shootId);
          }, 500);
        }
      }, 200);
    },

    addUploadedImages(files, shootId) {
      const shoot = this.shoots.find(s => s.id === shootId);
      if (!shoot) return;

      if (!shoot.uploadedImages) {
        shoot.uploadedImages = [];
      }

      files.forEach(file => {
        const imageObj = {
          id: Date.now() + Math.random(),
          name: file.name,
          size: file.size,
          type: file.name.split('.').pop().toLowerCase(),
          subcategoryId: this.selectedSubcategoryForUpload[shootId],
          preview: this.createImagePreview(file)
        };

        shoot.uploadedImages.push(imageObj);
      });

      // Update subcategory count
      const subcategory = shoot.subcategories.find(sc => sc.id === this.selectedSubcategoryForUpload[shootId]);
      if (subcategory) {
        subcategory.imageCount += files.length;
      }
    },

    createImagePreview(file) {
      // In real implementation, you'd create actual preview URLs
      return `https://via.placeholder.com/300x200?text=${encodeURIComponent(file.name)}`;
    },

    removeUploadedImage(shootId, imageId) {
      const shoot = this.shoots.find(s => s.id === shootId);
      if (shoot && shoot.uploadedImages) {
        const imageIndex = shoot.uploadedImages.findIndex(img => img.id === imageId);
        if (imageIndex > -1) {
          const image = shoot.uploadedImages[imageIndex];
          shoot.uploadedImages.splice(imageIndex, 1);

          // Update subcategory count
          const subcategory = shoot.subcategories.find(sc => sc.id === image.subcategoryId);
          if (subcategory) {
            subcategory.imageCount = Math.max(0, subcategory.imageCount - 1);
          }
        }
      }
    },

    generateShareLink(shoot) {
      // In real implementation, you'd call your backend API
      const linkId = Math.random().toString(36).substr(2, 9);
      shoot.shareLink = `https://yourdomain.com/gallery/${linkId}`;
      alert(`Share link generated: ${shoot.shareLink}`);
    },

    copyShareLink(link) {
      navigator.clipboard.writeText(link).then(() => {
        alert('Link copied to clipboard!');
      });
    },

    // Customer Gallery Methods
    verifyCustomer() {
      if (this.customerVerification.email && this.customerVerification.phone) {
        this.customerVerified = true;
        // Load gallery images (mock data)
        this.galleryImages = [
          { id: 1, name: 'IMG_001.jpg', preview: 'https://via.placeholder.com/300x200?text=Image+1' },
          { id: 2, name: 'IMG_002.jpg', preview: 'https://via.placeholder.com/300x200?text=Image+2' },
          { id: 3, name: 'IMG_003.jpg', preview: 'https://via.placeholder.com/300x200?text=Image+3' },
          { id: 4, name: 'IMG_004.jpg', preview: 'https://via.placeholder.com/300x200?text=Image+4' },
          { id: 5, name: 'IMG_005.jpg', preview: 'https://via.placeholder.com/300x200?text=Image+5' },
          { id: 6, name: 'IMG_006.jpg', preview: 'https://via.placeholder.com/300x200?text=Image+6' }
        ];
      }
    },

    toggleImageSelection(imageId) {
      const index = this.selectedImages.indexOf(imageId);
      if (index > -1) {
        this.selectedImages.splice(index, 1);
      } else {
        this.selectedImages.push(imageId);
      }
    },

    submitSelectedImages() {
      // In real implementation, you'd send selected images to backend
      alert(`${this.selectedImages.length} images selected and submitted for album creation!`);
      this.showCustomerGallery = false;
      this.customerVerified = false;
      this.selectedImages = [];
      this.customerVerification = { email: '', phone: '' };
    },

    formatDate(dateString) {
      return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
    },

    formatFileSize(bytes) {
      if (bytes === 0) return '0 Bytes';
      const k = 1024;
      const sizes = ['Bytes', 'KB', 'MB', 'GB'];
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
  }
}
</script>

<style scoped>
:root {
  --primary-orange: #ff6b35;
  --secondary-orange: #f7931e;
}

body {
  background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
  color: #fff;
  min-height: 100vh;
}

.card, .badge-card, .image-card, .gallery-image-card {
  background: rgba(30,41,59,0.92);
  border-radius: 16px;
  box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18), 0 1.5px 8px 0 #ff6b3533;
  border: none;
  transition: transform 0.18s cubic-bezier(.4,2,.6,1), box-shadow 0.18s;
}

.card:hover, .badge-card:hover, .image-card:hover, .gallery-image-card:hover {
  transform: translateY(-4px) scale(1.03);
  box-shadow: 0 16px 40px 0 rgba(255,107,53,0.18), 0 2px 16px 0 #ff6b3533;
}

.btn-orange {
  background: linear-gradient(90deg, #ff6b35 60%, #f7931e 100%);
  color: #fff;
  border: none;
  font-weight: 700;
  border-radius: 10px;
  box-shadow: 0 2px 8px 0 #ff6b3533;
  padding: 0.7rem 1.5rem;
  font-size: 1.1rem;
  transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
}
.btn-orange:hover {
  background: #ff6b35;
  color: #fff;
  box-shadow: 0 6px 24px rgba(255, 107, 53, 0.25);
  transform: translateY(-2px) scale(1.03);
}

.gallery-image-card.selected .selection-overlay {
  background: rgba(255, 255, 255, 0.25);
  backdrop-filter: blur(2px);
  border: 2px solid #ff6b35;
}

.upload-dropzone {
  transition: all 0.3s ease;
  min-height: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.upload-dropzone.dragover {
  border-color: var(--primary-orange) !important;
  background: rgba(255, 107, 53, 0.1);
}

.form-control:focus,
.form-select:focus {
  border-color: var(--primary-orange);
  box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
}

.card {
  transition: all 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

@media (max-width: 768px) {
  .image-card,
  .gallery-image-card {
    margin-bottom: 1rem;
  }

  .badge-card {
    margin-bottom: 0.5rem;
  }
}
</style>
