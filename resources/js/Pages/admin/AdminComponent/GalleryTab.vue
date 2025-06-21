<template>
  <div>
    <div class="card bg-dark border-secondary text-white mb-4">
      <div class="card-body">
        <h5 class="card-title mb-3">Create Client Gallery</h5>
        <form class="row g-3">
          <div class="col-md-3">
            <input type="text" class="form-control" placeholder="Client Name" />
          </div>
          <div class="col-md-3">
            <input type="email" class="form-control" placeholder="Client Email" />
          </div>
          <div class="col-md-3">
            <input type="tel" class="form-control" placeholder="Client Phone" />
          </div>
          <div class="col-md-3">
            <select class="form-select">
              <option>Select Shoot Type</option>
              <option v-for="type in shootTypes.slice(1)" :key="type.id" :value="type.id">{{ type.name }}</option>
            </select>
          </div>
          <div class="col-12 d-flex gap-3 flex-wrap">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="emailVerify" checked />
              <label class="form-check-label" for="emailVerify">📧 Require email verification</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="phoneVerify" checked />
              <label class="form-check-label" for="phoneVerify">📱 Require phone verification (SMS)</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="allowDownload" />
              <label class="form-check-label" for="allowDownload">⬇️ Allow client download</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="setExpiry" />
              <label class="form-check-label" for="setExpiry">⏰ Set expiry date</label>
            </div>
            <input type="date" class="form-control w-auto" />
            <button class="btn btn-warning ms-auto" type="button">
              🔗 Generate Secure Gallery Link
            </button>
          </div>
        </form>
      </div>
    </div>
    <!-- Active Galleries -->
    <div class="row g-4">
      <div
        v-for="shoot in recentShoots"
        :key="shoot.id"
        class="col-md-4"
      >
        <div class="card bg-dark border-secondary text-white h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <div class="fw-bold">{{ shoot.client }}</div>
              <span class="badge bg-warning text-dark">{{ getStatusText(shoot.status) }}</span>
            </div>
            <div class="text-secondary small mb-2">{{ shoot.type }}</div>
            <div class="text-secondary small mb-2">{{ shoot.images }} images</div>
            <div class="text-secondary small mb-2">Last activity: {{ shoot.lastActivity }}</div>
            <div>
              <span v-if="shoot.verified" class="badge bg-success">✓ Verified</span>
              <span v-else class="badge bg-warning text-dark">⚠ Pending</span>
            </div>
            <div class="d-flex gap-2 mt-2">
              <button class="btn btn-outline-info btn-sm" @click="$emit('copy-gallery-link', shoot.client)">
                <i class="bi bi-link-45deg"></i>
              </button>
              <button class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div v-if="recentShoots.length === 0" class="col-12 text-center text-secondary">
        No galleries found.
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  shootTypes: Array,
  recentShoots: Array,
  getStatusText: Function
});
const emit = defineEmits(['copy-gallery-link']);
</script>
