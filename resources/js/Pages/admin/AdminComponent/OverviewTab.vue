<template>
  <div>
    <div class="row g-4 mb-4">
      <div class="col-md-3" v-for="stat in statCards" :key="stat.title">
        <div class="card bg-dark border-secondary text-white text-center h-100">
          <div class="card-body">
            <div class="mb-2 fs-2">{{ stat.icon }}</div>
            <h3 class="mb-0">{{ stat.value }}</h3>
            <div class="text-secondary small">{{ stat.title }}</div>
            <div class="text-success small mt-1">{{ stat.change }}</div>
          </div>
        </div>
      </div>
    </div>
    <!-- Quick Actions -->
    <div class="card bg-dark border-secondary text-white mb-4">
      <div class="card-body">
        <h5 class="card-title mb-3">Quick Actions</h5>
        <div class="row g-3">
          <div class="col-md-4">
            <button class="btn btn-warning w-100 d-flex align-items-center justify-content-center gap-2" @click="$emit('trigger-file-input')">
              <i class="bi bi-upload"></i> Upload Images
            </button>
          </div>
          <div class="col-md-4">
            <button class="btn btn-info w-100 d-flex align-items-center justify-content-center gap-2">
              <i class="bi bi-share-fill"></i> Create Gallery
            </button>
          </div>
          <div class="col-md-4">
            <button class="btn btn-secondary w-100 d-flex align-items-center justify-content-center gap-2">
              <i class="bi bi-gear-fill"></i> Website Settings
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- Recent Shoots -->
    <div class="card bg-dark border-secondary text-white">
      <div class="card-body">
        <h5 class="card-title mb-3">Recent Shoots</h5>
        <div class="list-group">
          <div
            v-for="shoot in recentShoots.slice(0, 5)"
            :key="shoot.id"
            class="list-group-item bg-dark border-secondary d-flex justify-content-between align-items-center"
          >
            <div>
              <div class="fw-bold">{{ shoot.client }}</div>
              <div class="text-secondary small">{{ shoot.type }} • {{ shoot.images }} images</div>
            </div>
            <div class="text-end">
              <span class="badge bg-warning text-dark me-2">{{ getStatusText(shoot.status) }}</span>
              <span class="text-secondary small">{{ shoot.lastActivity }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  statCards: Array,
  recentShoots: Array,
  getStatusText: Function
});
</script>
