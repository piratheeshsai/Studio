<template>
  <div class="card bg-dark border-secondary text-white">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="card-title mb-0">Website Customization</h5>
        <div>
          <button class="btn btn-info me-2" @click="$emit('preview')">
            <i class="bi bi-eye"></i> Preview
          </button>
          <button class="btn btn-warning" @click="$emit('publish')">
            <i class="bi bi-gear"></i> Publish
          </button>
        </div>
      </div>
      <form class="row g-3" @submit.prevent="$emit('save', websiteSettings)">
        <div class="col-md-6">
          <input type="text" class="form-control mb-2" placeholder="Studio Name" v-model="websiteSettings.studioName" />
        </div>
        <div class="col-md-6">
          <input type="text" class="form-control mb-2" placeholder="Tagline" v-model="websiteSettings.tagline" />
        </div>
        <div class="col-md-6">
          <label class="form-label">Primary Color</label>
          <input type="color" class="form-control form-control-color" v-model="websiteSettings.primaryColor" />
        </div>
        <div class="col-md-6">
          <label class="form-label">Secondary Color</label>
          <input type="color" class="form-control form-control-color" v-model="websiteSettings.secondaryColor" />
        </div>
        <div class="col-md-12">
          <textarea class="form-control mb-2" placeholder="About Text" v-model="websiteSettings.aboutText"></textarea>
        </div>
        <div class="col-md-4">
          <input type="tel" class="form-control mb-2" placeholder="Phone Number" v-model="websiteSettings.phone" />
        </div>
        <div class="col-md-4">
          <input type="email" class="form-control mb-2" placeholder="Email Address" v-model="websiteSettings.email" />
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control mb-2" placeholder="Address" v-model="websiteSettings.address" />
        </div>
        <div class="col-md-12">
          <input type="text" class="form-control mb-2" placeholder="Social Media Links" v-model="websiteSettings.socialLinks" />
        </div>
        <div class="col-md-12">
          <textarea class="form-control mb-2" placeholder="Hero Message" v-model="websiteSettings.heroMessage"></textarea>
        </div>
        <div class="col-12 text-end">
          <button class="btn btn-warning" type="submit">Save Settings</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  websiteSettings: {
    type: Object,
    required: true
  }
});
</script>
