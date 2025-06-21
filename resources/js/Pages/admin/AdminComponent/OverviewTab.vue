<template>
  <div>
    <!-- Key Metrics Dashboard -->
    <div class="row g-4 mb-5">
      <div class="col-lg-3 col-md-6" v-for="metric in keyMetrics" :key="metric.title">
        <div class="metric-card">
          <div class="metric-icon">
            <i :class="metric.icon"></i>
          </div>
          <div class="metric-content">
            <h3 class="metric-value">{{ metric.value }}</h3>
            <p class="metric-title">{{ metric.title }}</p>
            <div class="metric-change" :class="metric.changeType">
              <i :class="metric.changeIcon"></i>
              {{ metric.change }}
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <!-- Left Column -->
      <div class="col-lg-8">
        <!-- Workflow Status Section -->
        <div class="workflow-section mb-4">
          <div class="section-header">
            <h5 class="section-title">
              <i class="bi bi-diagram-3-fill me-2"></i>
              Active Workflow Status
            </h5>
            <span class="status-indicator">{{ activeWorkflows }} Active</span>
          </div>

          <div class="workflow-grid">
            <div
              v-for="workflow in workflowStages"
              :key="workflow.stage"
              class="workflow-card"
              :class="workflow.status"
            >
              <div class="workflow-header">
                <div class="workflow-icon">
                  <i :class="workflow.icon"></i>
                </div>
                <span class="workflow-count">{{ workflow.count }}</span>
              </div>
              <h6 class="workflow-title">{{ workflow.title }}</h6>
              <p class="workflow-description">{{ workflow.description }}</p>
              <div class="workflow-actions">
                <button
                  class="btn btn-sm workflow-btn"
                  :class="workflow.buttonClass"
                  @click="handleWorkflowAction(workflow.stage)"
                >
                  {{ workflow.actionText }}
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Client Activities -->
        <div class="activity-section">
          <div class="section-header">
            <h5 class="section-title">
              <i class="bi bi-clock-history me-2"></i>
              Recent Client Activities
            </h5>
            <button class="btn btn-sm btn-outline-light">View All</button>
          </div>

          <div class="activity-list">
            <div
              v-for="activity in recentActivities"
              :key="activity.id"
              class="activity-item"
            >
              <div class="activity-avatar">
                <i :class="activity.icon"></i>
              </div>
              <div class="activity-content">
                <div class="activity-main">
                  <span class="activity-client">{{ activity.client }}</span>
                  <span class="activity-action">{{ activity.action }}</span>
                </div>
                <div class="activity-meta">
                  <span class="activity-type">{{ activity.type }}</span>
                  <span class="activity-time">{{ activity.time }}</span>
                </div>
              </div>
              <div class="activity-status">
                <span class="status-badge" :class="activity.statusClass">
                  {{ activity.status }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column -->
      <div class="col-lg-4">
        <!-- Quick Actions Panel -->
        <div class="quick-actions-section mb-4">
          <div class="section-header">
            <h5 class="section-title">
              <i class="bi bi-lightning-fill me-2"></i>
              Quick Actions
            </h5>
          </div>

          <div class="quick-actions-grid">
            <button
              v-for="action in quickActions"
              :key="action.id"
              class="quick-action-btn"
              :class="action.class"
              @click="handleQuickAction(action.id)"
            >
              <div class="action-icon">
                <i :class="action.icon"></i>
              </div>
              <span class="action-text">{{ action.text }}</span>
            </button>
          </div>
        </div>

        <!-- Pending Verifications -->
        <div class="verification-section mb-4">
          <div class="section-header">
            <h5 class="section-title">
              <i class="bi bi-shield-check me-2"></i>
              Pending Verifications
            </h5>
            <span class="verification-count">{{ pendingVerifications.length }}</span>
          </div>

          <div class="verification-list">
            <div
              v-for="verification in pendingVerifications"
              :key="verification.id"
              class="verification-item"
            >
              <div class="verification-content">
                <h6 class="verification-client">{{ verification.client }}</h6>
                <p class="verification-method">
                  <i :class="verification.methodIcon"></i>
                  {{ verification.method }}
                </p>
              </div>
              <div class="verification-actions">
                <button
                  class="btn btn-sm btn-success"
                  @click="approveVerification(verification.id)"
                >
                  <i class="bi bi-check-lg"></i>
                </button>
                <button
                  class="btn btn-sm btn-outline-danger"
                  @click="resendVerification(verification.id)"
                >
                  <i class="bi bi-arrow-clockwise"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Storage & Performance -->
        <div class="storage-section">
          <div class="section-header">
            <h5 class="section-title">
              <i class="bi bi-hdd-stack me-2"></i>
              Storage & Performance
            </h5>
          </div>

          <div class="storage-metrics">
            <div class="storage-item">
              <div class="storage-info">
                <span class="storage-label">Total Storage</span>
                <span class="storage-value">{{ storageInfo.used }} / {{ storageInfo.total }}</span>
              </div>
              <div class="storage-bar">
                <div
                  class="storage-fill"
                  :style="{ width: storageInfo.percentage + '%' }"
                ></div>
              </div>
            </div>

            <div class="performance-grid">
              <div class="performance-item">
                <i class="bi bi-upload"></i>
                <div>
                  <span class="performance-value">{{ performanceInfo.avgUpload }}</span>
                  <span class="performance-label">Avg Upload</span>
                </div>
              </div>
              <div class="performance-item">
                <i class="bi bi-download"></i>
                <div>
                  <span class="performance-value">{{ performanceInfo.avgDownload }}</span>
                  <span class="performance-label">Avg Download</span>
                </div>
              </div>
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
  statCards: Array,
  recentShoots: Array,
  getStatusText: Function
})

const emit = defineEmits(['trigger-file-input'])

// Key Metrics
const keyMetrics = ref([
  {
    title: 'Active Shoots',
    value: '12',
    icon: 'bi bi-camera-fill',
    change: '+3 this week',
    changeType: 'positive',
    changeIcon: 'bi bi-arrow-up'
  },
  {
    title: 'Pending Selection',
    value: '2,340',
    icon: 'bi bi-images',
    change: '+156 today',
    changeType: 'positive',
    changeIcon: 'bi bi-arrow-up'
  },
  {
    title: 'Client Verifications',
    value: '8',
    icon: 'bi bi-shield-check',
    change: '3 pending',
    changeType: 'warning',
    changeIcon: 'bi bi-clock'
  },
  {
    title: 'Albums Ready',
    value: '5',
    icon: 'bi bi-collection-fill',
    change: '2 delivered',
    changeType: 'positive',
    changeIcon: 'bi bi-check-circle'
  }
])

// Workflow Stages
const workflowStages = ref([
  {
    stage: 'upload',
    title: 'Image Upload',
    description: 'RAW images uploaded to cloud storage',
    count: 3,
    status: 'active',
    icon: 'bi bi-cloud-upload-fill',
    actionText: 'Upload New',
    buttonClass: 'btn-primary'
  },
  {
    stage: 'sharing',
    title: 'Share Selection Link',
    description: 'Send secure link to client for selection (with verification)',
    count: 7,
    status: 'pending',
    icon: 'bi bi-link-45deg',
    actionText: 'Send Link',
    buttonClass: 'btn-warning'
  },
  {
    stage: 'selection',
    title: 'Client Selection',
    description: 'Client selects images after verification',
    count: 12,
    status: 'active',
    icon: 'bi bi-images',
    actionText: 'View Selections',
    buttonClass: 'btn-info'
  },
  {
    stage: 'editing',
    title: 'Download & Edit',
    description: 'Download selected images for editing and album creation',
    count: 4,
    status: 'in-progress',
    icon: 'bi bi-download',
    actionText: 'Download Selected',
    buttonClass: 'btn-success'
  }
])

const activeWorkflows = computed(() => {
  return workflowStages.value.reduce((sum, stage) => sum + stage.count, 0)
})

// Recent Activities
const recentActivities = ref([
  {
    id: 1,
    client: 'Sarah & John',
    action: 'completed image selection',
    type: 'Wedding',
    time: '2 hours ago',
    status: 'Ready for editing',
    statusClass: 'status-success',
    icon: 'bi bi-heart-fill'
  },
  {
    id: 2,
    client: 'Emma Thompson',
    action: 'verified phone number',
    type: 'Birthday',
    time: '4 hours ago',
    status: 'Verified',
    statusClass: 'status-verified',
    icon: 'bi bi-gift-fill'
  },
  {
    id: 3,
    client: 'Isabella M.',
    action: 'accessed gallery link',
    type: 'Model',
    time: '6 hours ago',
    status: 'In selection',
    statusClass: 'status-warning',
    icon: 'bi bi-person-bounding-box'
  },
  {
    id: 4,
    client: 'Baby Oliver',
    action: 'album downloaded',
    type: 'Baby Shoot',
    time: '1 day ago',
    status: 'Completed',
    statusClass: 'status-completed',
    icon: 'bi bi-emoji-smile-fill'
  }
])

// Quick Actions
const quickActions = ref([
  {
    id: 'upload',
    text: 'Upload Images',
    icon: 'bi bi-cloud-upload-fill',
    class: 'action-primary'
  },
  {
    id: 'gallery',
    text: 'Create Gallery',
    icon: 'bi bi-images',
    class: 'action-secondary'
  },
  {
    id: 'send-link',
    text: 'Send Client Link',
    icon: 'bi bi-send-fill',
    class: 'action-info'
  },
  {
    id: 'album',
    text: 'Create Album',
    icon: 'bi bi-collection-fill',
    class: 'action-success'
  }
])

// Pending Verifications
const pendingVerifications = ref([
  {
    id: 1,
    client: 'Maya Patel',
    method: '+1 (555) 123-4567',
    methodIcon: 'bi bi-telephone-fill'
  },
  {
    id: 2,
    client: 'David Wilson',
    method: 'david@email.com',
    methodIcon: 'bi bi-envelope-fill'
  },
  {
    id: 3,
    client: 'Lisa Chen',
    method: '+1 (555) 987-6543',
    methodIcon: 'bi bi-telephone-fill'
  }
])

// Storage Information
const storageInfo = ref({
  used: '2.8 TB',
  total: '5.0 TB',
  percentage: 56
})

const performanceInfo = ref({
  avgUpload: '45 MB/s',
  avgDownload: '78 MB/s'
})

// Methods
const handleWorkflowAction = (stage) => {
  if (stage === 'upload') {
    emit('trigger-file-input')
  }
  console.log(`Handling action for stage: ${stage}`)
}

const handleQuickAction = (actionId) => {
  if (actionId === 'upload') {
    emit('trigger-file-input')
  }
  console.log(`Quick action: ${actionId}`)
}

const approveVerification = (id) => {
  console.log(`Approving verification: ${id}`)
}

const resendVerification = (id) => {
  console.log(`Resending verification: ${id}`)
}
</script>

<style scoped>
/* Metric Cards */
.metric-card {
  background: linear-gradient(120deg, rgba(30,41,59,0.96) 60%, #181824 100%);
  border-radius: 16px;
  box-shadow: 0 4px 18px 0 rgba(255,107,53,0.10), 0 1.5px 8px 0 #ff6b3533;
  border: 1.5px solid rgba(255,255,255,0.06);
  padding: 1.2rem 1rem 1rem 1rem;
  position: relative;
  overflow: hidden;
  min-height: 120px;
  display: flex;
  flex-direction: row;
  align-items: center;
  gap: 1rem;
  transition: transform 0.16s cubic-bezier(.4,2,.6,1), box-shadow 0.16s;
}

.metric-card::before {
  content: '';
  position: absolute;
  top: -30px;
  right: -30px;
  width: 70px;
  height: 70px;
  background: radial-gradient(circle, #ff6b35 0%, #f7931e 80%, transparent 100%);
  opacity: 0.13;
  z-index: 0;
}

.metric-card:hover {
  transform: translateY(-4px) scale(1.025);
  box-shadow: 0 8px 32px 0 rgba(255,107,53,0.18), 0 2px 16px 0 #ff6b3533;
  border-color: #ff6b35;
}

.metric-icon {
  font-size: 2rem;
  color: #fff;
  background: linear-gradient(135deg, #ff6b35 60%, #f7931e 100%);
  border-radius: 12px;
  width: 44px;
  height: 44px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 2px 8px 0 #ff6b3533;
  z-index: 1;
}

.metric-content {
  flex: 1;
  z-index: 1;
}

.metric-value {
  font-size: 1.5rem;
  font-weight: 800;
  margin: 0;
  color: #fff;
  letter-spacing: -0.5px;
}

.metric-title {
  color: #f7931e;
  font-size: 0.98rem;
  margin: 2px 0 6px;
  font-weight: 600;
  letter-spacing: 0.2px;
}

.metric-change {
  font-size: 0.85rem;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 5px;
  margin-top: 1px;
}

.metric-change.positive { color: #10b981; }
.metric-change.warning { color: #f59e0b; }
.metric-change.negative { color: #ef4444; }

@media (max-width: 991px) {
  .metric-card {
    min-height: 100px;
    padding: 1rem 0.7rem;
    gap: 0.7rem;
  }
  .metric-icon {
    font-size: 1.5rem;
    width: 36px;
    height: 36px;
  }
  .metric-value {
    font-size: 1.1rem;
  }
}

/* Section Headers */
.section-header {
  display: flex;
  justify-content: between;
  align-items: center;
  margin-bottom: 20px;
}

.section-title {
  color: white;
  font-weight: 600;
  margin: 0;
  display: flex;
  align-items: center;
}

.status-indicator {
  background: rgba(16, 185, 129, 0.2);
  color: #10b981;
  font-size: 0.8rem;
  padding: 4px 12px;
  border-radius: 20px;
  font-weight: 600;
}

.verification-count {
  background: rgba(245, 158, 11, 0.2);
  color: #f59e0b;
  font-size: 0.8rem;
  padding: 4px 10px;
  border-radius: 12px;
  font-weight: 600;
}

/* Workflow Section */
.workflow-section {
  background: rgba(15, 23, 42, 0.6);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 16px;
  padding: 24px;
}

.workflow-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 16px;
}

.workflow-card {
  background: rgba(30, 41, 59, 0.8);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 12px;
  padding: 20px;
  transition: all 0.3s ease;
}

.workflow-card:hover {
  transform: translateY(-2px);
  border-color: #ff6b35;
}

.workflow-card.active {
  border-color: #10b981;
  background: rgba(16, 185, 129, 0.05);
}

.workflow-card.pending {
  border-color: #f59e0b;
  background: rgba(245, 158, 11, 0.05);
}

.workflow-card.in-progress {
  border-color: #3b82f6;
  background: rgba(59, 130, 246, 0.05);
}

.workflow-header {
  display: flex;
  justify-content: between;
  align-items: center;
  margin-bottom: 12px;
}

.workflow-icon {
  font-size: 1.5rem;
  color: #ff6b35;
}

.workflow-count {
  background: #ff6b35;
  color: white;
  font-size: 0.9rem;
  font-weight: 700;
  padding: 4px 10px;
  border-radius: 20px;
}

.workflow-title {
  color: white;
  font-weight: 600;
  margin: 0 0 8px;
}

.workflow-description {
  color: #94a3b8;
  font-size: 0.9rem;
  margin: 0 0 16px;
}

.workflow-actions {
  margin-top: auto;
}

.workflow-btn {
  width: 100%;
  font-size: 0.85rem;
  font-weight: 600;
  padding: 8px 16px;
  border-radius: 8px;
}

/* Activity Section */
.activity-section {
  background: rgba(15, 23, 42, 0.6);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 16px;
  padding: 24px;
}

.activity-list {
  space-y: 12px;
}

.activity-item {
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 16px;
  background: rgba(30, 41, 59, 0.4);
  border: 1px solid rgba(255, 255, 255, 0.05);
  border-radius: 12px;
  transition: all 0.3s ease;
  margin-bottom: 12px;
}

.activity-item:hover {
  background: rgba(30, 41, 59, 0.6);
  border-color: rgba(255, 255, 255, 0.1);
}

.activity-avatar {
  width: 40px;
  height: 40px;
  background: rgba(255, 107, 53, 0.2);
  color: #ff6b35;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.1rem;
}

.activity-content {
  flex: 1;
}

.activity-main {
  color: white;
  font-size: 0.95rem;
  margin-bottom: 4px;
}

.activity-client {
  font-weight: 600;
  margin-right: 8px;
}

.activity-meta {
  display: flex;
  gap: 12px;
  font-size: 0.8rem;
  color: #94a3b8;
}

.status-badge {
  font-size: 0.8rem;
  font-weight: 600;
  padding: 4px 12px;
  border-radius: 20px;
}

.status-success {
  background: rgba(16, 185, 129, 0.2);
  color: #10b981;
}

.status-verified {
  background: rgba(59, 130, 246, 0.2);
  color: #3b82f6;
}

.status-warning {
  background: rgba(245, 158, 11, 0.2);
  color: #f59e0b;
}

.status-completed {
  background: rgba(139, 92, 246, 0.2);
  color: #8b5cf6;
}

/* Quick Actions */
.quick-actions-section {
  background: rgba(15, 23, 42, 0.6);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 16px;
  padding: 24px;
}

.quick-actions-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
}

.quick-action-btn {
  background: rgba(30, 41, 59, 0.8);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 12px;
  padding: 16px;
  color: white;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  transition: all 0.3s ease;
  cursor: pointer;
}

.quick-action-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}

.action-primary:hover {
  border-color: #3b82f6;
  background: rgba(59, 130, 246, 0.1);
}

.action-secondary:hover {
  border-color: #8b5cf6;
  background: rgba(139, 92, 246, 0.1);
}

.action-info:hover {
  border-color: #06b6d4;
  background: rgba(6, 182, 212, 0.1);
}

.action-success:hover {
  border-color: #10b981;
  background: rgba(16, 185, 129, 0.1);
}

.action-icon {
  font-size: 1.5rem;
  color: #ff6b35;
}

.action-text {
  font-size: 0.85rem;
  font-weight: 600;
  text-align: center;
}

/* Verification Section */
.verification-section {
  background: rgba(15, 23, 42, 0.6);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 16px;
  padding: 24px;
}

.verification-list {
  space-y: 12px;
}

.verification-item {
  display: flex;
  justify-content: between;
  align-items: center;
  padding: 16px;
  background: rgba(30, 41, 59, 0.4);
  border: 1px solid rgba(255, 255, 255, 0.05);
  border-radius: 12px;
  margin-bottom: 12px;
}

.verification-content h6 {
  color: white;
  font-weight: 600;
  margin: 0 0 4px;
}

.verification-content p {
  color: #94a3b8;
  font-size: 0.85rem;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 8px;
}

.verification-actions {
  display: flex;
  gap: 8px;
}

/* Storage Section */
.storage-section {
  background: rgba(15, 23, 42, 0.6);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 16px;
  padding: 24px;
}

.storage-metrics {
  space-y: 20px;
}

.storage-item {
  margin-bottom: 20px;
}

.storage-info {
  display: flex;
  justify-content: between;
  align-items: center;
  margin-bottom: 8px;
}

.storage-label {
  color: #94a3b8;
  font-size: 0.9rem;
}

.storage-value {
  color: white;
  font-weight: 600;
}

.storage-bar {
  height: 8px;
  background: rgba(30, 41, 59, 0.8);
  border-radius: 4px;
  overflow: hidden;
}

.storage-fill {
  height: 100%;
  background: linear-gradient(90deg, #ff6b35, #f7931e);
  border-radius: 4px;
  transition: width 0.3s ease;
}

.performance-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

.performance-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px;
  background: rgba(30, 41, 59, 0.4);
  border-radius: 8px;
}

.performance-item i {
  font-size: 1.2rem;
  color: #ff6b35;
}

.performance-value {
  display: block;
  color: white;
  font-weight: 600;
  font-size: 0.9rem;
}

.performance-label {
  display: block;
  color: #94a3b8;
  font-size: 0.75rem;
}

/* Responsive Design */
@media (max-width: 768px) {
  .workflow-grid {
    grid-template-columns: 1fr;
  }

  .quick-actions-grid {
    grid-template-columns: 1fr;
  }

  .performance-grid {
    grid-template-columns: 1fr;
  }
}
</style>
