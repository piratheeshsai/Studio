<template>
  <div class="modern-header">
    <div class="container-xl">
      <div class="header-content">
        <!-- Left: Logo -->
        <div class="brand-section">
          <div class="brand-logo">
            <img src="@/assets/img/logo.png" alt="Studio Logo" class="logo-image" />
          </div>
        </div>

        <!-- Right: Notification Bell -->
        <div class="notification-wrapper ms-auto me-3">
          <button class="btn notification-btn" @click="toggleNotifications">
            <i class="fa-solid fa-bell"></i>
            <span class="notification-badge" v-if="notificationCount > 0">
              {{ notificationCount > 99 ? '99+' : notificationCount }}
            </span>
          </button>
          <!-- Notification Dropdown -->
          <div class="notification-dropdown" v-if="showNotifications" @click.stop>
            <div class="notification-header">
              <h6>Notifications</h6>
              <button class="btn btn-sm mark-all-read" @click="markAllRead">
                Mark all read
              </button>
            </div>
            <div class="notification-list">
              <div
                v-for="notification in notifications"
                :key="notification.id"
                class="notification-item"
                :class="{ 'unread': !notification.read }"
              >
                <div class="notification-icon" :class="notification.typeClass">
                  <i :class="notification.icon"></i>
                </div>
                <div class="notification-content">
                  <p class="notification-text">{{ notification.message }}</p>
                  <span class="notification-time">{{ notification.time }}</span>
                </div>
              </div>
            </div>
            <div class="notification-footer">
              <button class="btn btn-sm btn-outline-light w-100">
                View All Notifications
              </button>
            </div>
          </div>
        </div>

        <!-- Right: Profile Menu -->
        <div class="actions-section">
          <div class="dropdown">
            <button
              class="btn profile-btn dropdown-toggle"
              type="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <div class="profile-avatar">
                <img :src="userAvatar" alt="Profile" v-if="userAvatar" />
                <i class="fa-solid fa-user" v-else></i>
              </div>
              <span class="profile-name">{{ userName }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end profile-menu">
              <li class="profile-info">
                <div class="profile-details">
                  <strong>{{ userName }}</strong>
                  <small>{{ userRole }}</small>
                </div>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item" href="#" @click="editProfile">
                  <i class="fa-solid fa-user-gear"></i> Edit Profile
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="#" @click="studioSettings">
                  <i class="fa-solid fa-gear"></i> Studio Settings
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="#" @click="viewSubscription">
                  <i class="fa-solid fa-credit-card"></i> Subscription
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item text-danger" href="#" @click="logout">
                  <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- File Input (Hidden) -->
    <input
      ref="fileInput"
      type="file"
      multiple
      accept="image/*,video/*"
      class="d-none"
      @change="handleFileUpload"
    />
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  stats: { type: Object, required: true },
  logo: { type: String, default: '/assets/img/logo.png' },
  userName: { type: String, default: 'John Photographer' },
  userRole: { type: String, default: 'Studio Owner' },
  userAvatar: { type: String, default: '' }
})

const emit = defineEmits(['file-upload'])

const fileInput = ref(null)
const showNotifications = ref(false)

const notifications = ref([
  {
    id: 1,
    message: 'Sarah & John completed image selection',
    time: '2 hours ago',
    read: false,
    icon: 'fa-solid fa-circle-check',
    typeClass: 'notification-success'
  },
  {
    id: 2,
    message: 'New client verification pending',
    time: '4 hours ago',
    read: false,
    icon: 'bi bi-shield-exclamation',
    typeClass: 'notification-warning'
  },
  {
    id: 3,
    message: 'Album ready for Emma Thompson',
    time: '6 hours ago',
    read: true,
    icon: 'bi bi-collection-fill',
    typeClass: 'notification-info'
  }
])

const notificationCount = computed(() => {
  return notifications.value.filter(n => !n.read).length
})

const handleFileUpload = (e) => {
  emit('file-upload', e)
}

const toggleNotifications = () => {
  showNotifications.value = !showNotifications.value
}

const markAllRead = () => {
  notifications.value.forEach(n => n.read = true)
}

const editProfile = () => {}
const studioSettings = () => {}
const viewSubscription = () => {}
const logout = () => {}

const handleClickOutside = (event) => {
  if (showNotifications.value && !event.target.closest('.notification-wrapper')) {
    showNotifications.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
.modern-header {
  background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  padding: 16px 0;
  position: relative;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.modern-header::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 2px;
  background: linear-gradient(90deg, #ff6b35, #f7931e, #ff6b35);
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 32px;
}

/* Brand Section */
.brand-section {
  display: flex;
  align-items: center;
  gap: 16px;
  flex-shrink: 0;
}

.brand-logo {
  position: relative;
}

.logo-image {
  max-height: 50px;
  width: auto;
  border-radius: 8px;
  box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
}

/* Notification Wrapper */
.notification-wrapper {
  position: relative;
}

.notification-btn {
  background: rgba(59, 130, 246, 0.1);
  border: 1px solid rgba(59, 130, 246, 0.3);
  color: #3b82f6;
  border-radius: 12px;
  padding: 12px;
  position: relative;
  transition: all 0.3s ease;
}

.notification-btn:hover {
  background: rgba(59, 130, 246, 0.2);
  border-color: #3b82f6;
  color: #3b82f6;
}

.notification-badge {
  position: absolute;
  top: -4px;
  right: -4px;
  background: #ef4444;
  color: white;
  font-size: 0.7rem;
  font-weight: 700;
  padding: 2px 6px;
  border-radius: 10px;
  min-width: 18px;
  text-align: center;
}

.notification-dropdown {
  position: absolute;
  top: 100%;
  right: 0;
  margin-top: 8px;
  background: rgba(15, 23, 42, 0.95);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 16px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
  width: 360px;
  z-index: 1000;
}

.notification-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px 20px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.notification-header h6 {
  color: white;
  margin: 0;
  font-weight: 600;
}

.mark-all-read {
  color: #3b82f6;
  font-size: 0.8rem;
}

.notification-list {
  max-height: 300px;
  overflow-y: auto;
}

.notification-item {
  display: flex;
  gap: 12px;
  padding: 16px 20px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.05);
  transition: all 0.3s ease;
}

.notification-item:hover {
  background: rgba(255, 255, 255, 0.02);
}

.notification-item.unread {
  background: rgba(59, 130, 246, 0.05);
}

.notification-icon {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.9rem;
  flex-shrink: 0;
}

.notification-success {
  background: rgba(16, 185, 129, 0.2);
  color: #10b981;
}

.notification-warning {
  background: rgba(245, 158, 11, 0.2);
  color: #f59e0b;
}

.notification-info {
  background: rgba(59, 130, 246, 0.2);
  color: #3b82f6;
}

.notification-content {
  flex: 1;
}

.notification-text {
  color: white;
  font-size: 0.9rem;
  margin: 0 0 4px;
}

.notification-time {
  color: #94a3b8;
  font-size: 0.8rem;
}

.notification-footer {
  padding: 16px 20px;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}

/* Profile Section */
.profile-btn {
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.1);
  color: white;
  border-radius: 12px;
  padding: 8px 16px;
  display: flex;
  align-items: center;
  gap: 12px;
  transition: all 0.3s ease;
}

.profile-btn:hover {
  background: rgba(255, 255, 255, 0.08);
  color: white;
}

.profile-avatar {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: rgba(255, 107, 53, 0.2);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.profile-avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.profile-avatar i {
  color: #ff6b35;
  font-size: 1.1rem;
}

.profile-name {
  font-weight: 600;
  font-size: 0.9rem;
}

.profile-menu {
  background: rgba(15, 23, 42, 0.95);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 16px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
  padding: 8px;
  min-width: 220px;
}

.profile-info {
  padding: 16px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.profile-details strong {
  color: white;
  display: block;
  font-size: 0.9rem;
}

.profile-details small {
  color: #94a3b8;
  font-size: 0.8rem;
}

.profile-menu .dropdown-item {
  color: white;
  padding: 12px 16px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  gap: 12px;
  transition: all 0.3s ease;
}

.profile-menu .dropdown-item:hover {
  background: rgba(255, 255, 255, 0.05);
  color: white;
}

.profile-menu .dropdown-item.text-danger:hover {
  background: rgba(239, 68, 68, 0.1);
  color: #ef4444;
}

.profile-menu .dropdown-item i {
  width: 16px;
  text-align: center;
}

/* Responsive Design */
@media (max-width: 992px) {
  .header-content {
    gap: 20px;
  }
  .notification-dropdown {
    width: 300px;
  }
}

@media (max-width: 768px) {
  .brand-section {
    gap: 12px;
  }
  .actions-section {
    gap: 12px;
  }
  .profile-name {
    display: none;
  }
  .notification-dropdown {
    width: 240px;
  }
}
</style>
