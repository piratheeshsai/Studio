<!-- Shoots Tab -->

<template>
  <div>
    <div class="card bg-dark border-secondary text-white mb-4">
      <div class="card-body">
        <h5 class="card-title mb-3">Filter by Shoot Type</h5>
        <div class="d-flex flex-wrap gap-2">
          <button
            v-for="type in shootTypes"
            :key="type.id"
            class="btn"
            :class="activeShootType === type.id ? 'btn-warning text-dark' : 'btn-outline-secondary'"
            @click="$emit('update:activeShootType', type.id)"
          >
            <i :class="type.icon"></i> {{ type.name }}
          </button>
        </div>
      </div>
    </div>
    <!-- Upload Zone -->
    <div class="card bg-dark border-secondary text-white mb-4">
      <div class="card-body text-center" style="cursor:pointer" @click="$emit('trigger-file-input')">
        <div class="fs-1 mb-2 text-warning"><i class="bi bi-cloud-arrow-up"></i></div>
        <h5>Upload New Shoot Images</h5>
        <div class="text-secondary mb-2">Drag and drop your images here or click to browse</div>
        <div class="text-secondary small">Supports: RAW, JPG, PNG • Max 50MB per image • Up to 500 images</div>
      </div>
    </div>
    <!-- Shoots Grid -->
    <div class="row g-4">
      <div
        v-for="shoot in filteredShoots"
        :key="shoot.id"
        class="col-md-4"
      >
        <div class="card bg-dark border-secondary text-white h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <div class="fs-4">{{ getTypeIcon(shoot.type) }}</div>
              <span class="badge bg-warning text-dark">{{ getStatusText(shoot.status) }}</span>
            </div>
            <div class="fw-bold">{{ shoot.client }}</div>
            <div class="text-secondary small mb-2">{{ shoot.type }} • {{ shoot.date }}</div>
            <div class="text-secondary small mb-2">{{ shoot.images }} images • Last activity: {{ shoot.lastActivity }}</div>
            <div class="d-flex gap-2">
              <button class="btn btn-outline-info btn-sm" @click="$emit('copy-gallery-link', shoot.client)">
                <i class="bi bi-link-45deg"></i>
              </button>
              <button class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-eye"></i>
              </button>
              <button class="btn btn-outline-success btn-sm">
                <i class="bi bi-download"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div v-if="filteredShoots.length === 0" class="col-12 text-center text-secondary">
        No shoots found for this type.
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  shootTypes: Array,
  activeShootType: String,
  filteredShoots: Array,
  getTypeIcon: Function,
  getStatusText: Function
});
</script>
