   <!-- dashboard Header -->

<template>
  <div class="bg-dark border-bottom border-secondary py-4 px-3">
    <div class="container-xl d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center gap-2">
        <div>
          <img src="@/assets/img/logo.png" alt="Logo" class="brand-logo" style="max-height:50px;" />
        </div>
      </div>
      <div class="d-flex align-items-center gap-3">
        <div class="bg-warning bg-opacity-25 border border-warning rounded-pill px-3 py-1 d-flex align-items-center">
          <i class="bi bi-bell-fill text-warning me-2"></i>
          <span class="fw-bold text-warning">{{ stats.pendingReviews }}</span>
          <span class="text-secondary ms-1 small">Pending</span>
        </div>
        <div class="bg-info bg-opacity-25 border border-info rounded-pill px-3 py-1 d-flex align-items-center">
          <i class="bi bi-eye-fill text-info me-2"></i>
          <span class="fw-bold text-info">{{ stats.activeGalleries }}</span>
          <span class="text-secondary ms-1 small">Active</span>
        </div>
        <button class="btn btn-warning d-flex align-items-center" @click="triggerFileInput">
          <i class="bi bi-upload me-2"></i> Quick Upload
        </button>
        <input ref="fileInput" type="file" multiple class="d-none" @change="handleFileUpload" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
  stats: { type: Object, required: true },
  logo: { type: String, default: '/assets/img/logo.png' }
});

const emit = defineEmits(['file-upload']);

const fileInput = ref(null);

function triggerFileInput() {
  fileInput.value && fileInput.value.click();
}
function handleFileUpload(e) {
  emit('file-upload', e);
}
</script>
