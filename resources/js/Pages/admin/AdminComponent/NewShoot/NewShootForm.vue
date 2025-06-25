<template>
  <div class="new-shoot-form mb-5">
    <h4 class="mb-3 text-white">
      <i class="fas fa-camera me-2"></i>Create New Shoot
    </h4>
    <form class="bg-dark p-4 rounded-3 border border-secondary" @submit.prevent="submitForm">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label text-light">Client Name</label>
          <input
            v-model="form.clientName"
            type="text"
            class="form-control bg-dark text-light border-secondary"
            placeholder="Enter client name"
            required
          />
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label text-light">Shoot Type</label>
          <select
            v-model="form.shootType"
            class="form-select bg-dark text-light border-secondary"
            required
          >
            <option value="">Select Shoot Type</option>
            <option>Wedding</option>
            <option>Birthday</option>
            <option>Model</option>
            <option>Baby Shoot</option>
            <option>Puberty Ceremony</option>
            <option>Events</option>
            <option>Videography</option>
          </select>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label text-light">Date</label>
          <input
            v-model="form.date"
            type="date"
            class="form-control bg-dark text-light border-secondary"
            required
          />
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label text-light">Client Email</label>
          <input
            v-model="form.clientEmail"
            type="email"
            class="form-control bg-dark text-light border-secondary"
            placeholder="client@example.com"
            required
          />
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label text-light">Client Phone</label>
          <input
            v-model="form.clientPhone"
            type="tel"
            class="form-control bg-dark text-light border-secondary"
            placeholder="Enter client phone"
            required
          />
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label text-light">Package Selection</label>
          <select
  v-model="form.package"
  class="form-select bg-dark text-light border-secondary"
  required
>
  <option value="">Select Package</option>
  <option v-for="pkg in packages" :key="pkg.id" :value="pkg.id">
    {{ pkg.name }} ({{ pkg.price }} USD, {{ pkg.image_limit }} images)
  </option>
</select>
        </div>
      </div>
      <button type="submit" class="btn btn-orange" :disabled="loading">
        <span v-if="loading" class="spinner"></span>
        <span v-else>
          <i class="fas fa-plus me-2"></i>Create Shoot
        </span>
      </button>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue'
import axios from 'axios'

const form = reactive({
  clientName: '',
  shootType: '',
  date: '',
  clientEmail: '',
  clientPhone: '',
  package: ''
})

const packages = ref([])

onMounted(async () => {

    const res = await axios.get('/api/packages')
    packages.value = res.data
})

const loading = ref(false)

function submitForm() {
  loading.value = true
  // Simulate async operation (e.g., API call)
  setTimeout(() => {
    console.log('Form submitted:', { ...form })
    // Optionally reset form
    form.clientName = ''
    form.shootType = ''
    form.date = ''
    form.clientEmail = ''
    form.clientPhone = ''
    form.package = ''
    loading.value = false
  }, 1500)
}
</script>

<style scoped>
/* Premium Orange Button Styles */
.btn-orange {
  background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
  color: #ffffff;
  border: none;
  font-weight: 600;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
  padding: 0.75rem 1.5rem;
  font-size: 1rem;
  transition: all 0.25s ease;
  position: relative;
  overflow: hidden;
}

.btn-orange:hover {
  background: linear-gradient(135deg, #e55a2e 0%, #e0861a 100%);
  color: #ffffff;
  box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
  transform: translateY(-2px);
}

.btn-orange:active {
  transform: translateY(0);
  box-shadow: 0 2px 8px rgba(255, 107, 53, 0.3);
}

/* Modern 2025 Premium Glassy Input Styles */
.form-control,
.form-select {
  background: rgba(34, 38, 44, 0.85);
  border: 1.5px solid #23272b;
  color: #fff;
  border-radius: 12px;
  padding: 1rem 1.15rem;
  font-size: 1.08rem;
  font-weight: 500;
  box-shadow: 0 4px 24px 0 rgba(255, 107, 53, 0.06), 0 1.5px 8px 0 #ff6b3533;
  transition:
    border-color 0.22s cubic-bezier(.4,2,.6,1),
    box-shadow 0.22s cubic-bezier(.4,2,.6,1),
    background 0.22s cubic-bezier(.4,2,.6,1);
  backdrop-filter: blur(3px);
}

.form-control:focus,
.form-select:focus {
  border-color: #ff6b35;
  background: rgba(34, 38, 44, 0.98);
  box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.18), 0 2px 16px rgba(255, 107, 53, 0.10);
  outline: none;
}

.form-control:hover:not(:focus),
.form-select:hover:not(:focus) {
  border-color: #f7931e;
  background: rgba(34, 38, 44, 0.93);
}

.form-control::placeholder {
  color: #ffb98a;
  opacity: 0.8;
  font-weight: 400;
  letter-spacing: 0.02em;
}

.form-select option {
  background: #23272b;
  color: #fff;
}

/* Label styling */
.form-label {
  color: #ff6b35;
  font-weight: 600;
  font-size: 1rem;
  margin-bottom: 0.35rem;
  letter-spacing: 0.01em;
}

/* Validation states */
.form-control:valid {
  border-color: #28a745;
}

.form-control:invalid:not(:placeholder-shown) {
  border-color: #dc3545;
}

/* Clean Form Control Styles */
.form-control, .form-select {
  background: #212529 !important;
  border: 1px solid #495057 !important;
  color: #ffffff !important;
  border-radius: 6px;
  padding: 0.75rem 1rem;
  font-size: 0.95rem;
  transition: all 0.2s ease;
}

.form-control:focus, .form-select:focus {
  border-color: #ff6b35 !important;
  box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25) !important;
  background: #2c3034 !important;
  color: #ffffff !important;
  outline: none;
}

.form-control:hover:not(:focus), .form-select:hover:not(:focus) {
  border-color: #6c757d !important;
  background: #2c3034 !important;
}

.form-control::placeholder {
  color: #adb5bd !important;
  opacity: 0.7;
}

.form-select option {
  background: #212529 !important;
  color: #ffffff !important;
}

/* Clean Form Labels */
.form-label {
  color: #f8f9fa !important;
  font-weight: 500;
  font-size: 0.9rem;
  margin-bottom: 0.5rem;
}

/* Modern Container Design */
.new-shoot-form {
  background: #1a1d23;
  border-radius: 12px;
  padding: 2rem;
  box-shadow:
    0 8px 32px rgba(0, 0, 0, 0.3),
    0 2px 16px rgba(0, 0, 0, 0.15);
  border: 1px solid #343a40;
  position: relative;
}

.new-shoot-form::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 2px;
  background: linear-gradient(90deg, #ff6b35, #f7931e);
  border-radius: 12px 12px 0 0;
}

.new-shoot-form h4 {
  color: #ffffff;
  font-size: 1.4rem;
  font-weight: 600;
  margin-bottom: 1.5rem;
  display: flex;
  align-items: center;
}

.new-shoot-form h4 i {
  color: #ff6b35;
  margin-right: 0.5rem;
}

/* Clean spacing */
.row {
  margin-bottom: 0.25rem;
}

.mb-3 {
  margin-bottom: 1rem !important;
}

/* Responsive Design */
@media (max-width: 768px) {
  .new-shoot-form {
    padding: 1.5rem;
    margin: 0.5rem;
    border-radius: 8px;
  }

  .btn-orange {
    width: 100%;
    padding: 0.875rem;
    font-size: 1.05rem;
  }

  .form-control, .form-select {
    font-size: 1rem;
    padding: 0.875rem 1rem;
  }
}

/* Subtle animations */
.new-shoot-form {
  animation: fadeInUp 0.4s ease-out;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Better accessibility */
.form-control:focus-visible, .form-select:focus-visible {
  outline: 2px solid #ff6b35;
  outline-offset: 2px;
}

/* Spinner Animation */
.spinner {
  display: inline-block;
  width: 1.4em;
  height: 1.4em;
  border: 3px solid #fff;
  border-radius: 50%;
  border-top: 3px solid #ff6b35;
  animation: spin 0.7s linear infinite;
  vertical-align: middle;
  margin-right: 0.5em;
  box-sizing: border-box;
}

@keyframes spin {
  0% { transform: rotate(0deg);}
  100% { transform: rotate(360deg);}
}
</style>
