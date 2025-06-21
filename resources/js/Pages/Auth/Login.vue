<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="login-page">
        <Head title="Log in" />

        <!-- Header -->
        <div class="navbar-wrapper">
            <nav class="navbar">
                <div class="navbar-brand">
                    <img src="@/assets/img/logo.png" alt="Logo" class="brand-logo" />
                </div>
                <Link :href="route('home')" @click="closeMenu" class="btn-home">HOME</Link>
            </nav>
        </div>

        <!-- Main Content Split Layout -->
        <div class="main-content">
            <!-- Left Side - Login Form -->
            <div class="login-section">
                <div class="login-form-wrapper">
                    <div class="card login-card">
                        <div class="card-body p-5">
                            <h2 class="text-center mb-4 login-title">Login</h2>

                            <div v-if="status" class="alert alert-success text-center">
                                {{ status }}
                            </div>

                            <form @submit.prevent="submit">
                                <div class="mb-4">
                                    <InputLabel for="email" value="Username" class="form-label" />
                                    <TextInput
                                        id="email"
                                        type="email"
                                        class="form-control login-input"
                                        v-model="form.email"
                                        required
                                        autofocus
                                        autocomplete="username"
                                        placeholder="Enter your username"
                                    />
                                    <InputError class="text-danger mt-2" :message="form.errors.email" />
                                </div>

                                <div class="mb-4">
                                    <InputLabel for="password" value="Password" class="form-label" />
                                    <TextInput
                                        id="password"
                                        type="password"
                                        class="form-control login-input"
                                        v-model="form.password"
                                        required
                                        autocomplete="current-password"
                                        placeholder="Enter your password"
                                    />
                                    <InputError class="text-danger mt-2" :message="form.errors.password" />
                                </div>

                                <div class="mb-4 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <Checkbox name="remember" v-model:checked="form.remember" class="form-check-input" />
                                        <label class="form-check-label text-muted">
                                            Remember me
                                        </label>
                                    </div>

                                    <Link
                                        v-if="canResetPassword"
                                        :href="route('password.request')"
                                        class="text-muted text-decoration-none forgot-link"
                                    >
                                        Forgot password?
                                    </Link>
                                </div>

                                <button
                                    type="submit"
                                    class="btn btn-login w-100"
                                    :class="{ 'disabled': form.processing }"
                                    :disabled="form.processing"
                                >
                                    {{ form.processing ? 'Logging in...' : 'Login' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Image -->
            <div class="image-section">
                <div class="login-image">
                    <!-- Replace this src with your actual image path -->
                    <img src="@/assets/img/logo-w.png" alt="Login Background" class="side-image" />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.login-page {
    background-color: #000;
    min-height: 100vh;
    position: relative;
    overflow: hidden;
}

/* Header/Navbar */
.navbar-wrapper {
    padding-left: 24px;
    padding-right: 24px;
    margin-top: 24px;
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(30, 30, 30, 0.85);
    border: 1px solid #444;
    border-radius: 18px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.10);
    backdrop-filter: blur(4px);
    padding: 1rem 2rem;
}

.navbar-brand {
    display: flex;
    align-items: center;
    color: white;
}

.brand-logo {
    height: 4rem;
    margin-left: 1rem;
}

.btn-home {
    background-color: #df8f33;
    color: white;
    border: none;
    padding: 0.5rem 1.5rem;
    border-radius: 6px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-home:hover {
    background-color: #e55a2b;
    transform: translateY(-2px);
}

/* Main Content Split Layout */
.main-content {
    display: flex;
    min-height: calc(100vh - 120px); /* Adjust based on navbar height */
    margin-top: 2rem;
}

/* Left Side - Login Section */
.login-section {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.login-form-wrapper {
    position: relative;
    z-index: 10;
    width: 100%;
    max-width: 400px;
}

.login-card {
    background: white;
    border: none;
    border-radius: 24px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    width: 100%;
}

.login-title {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 2rem;
}

/* Right Side - Image Section */
.image-section {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}

.login-image {
    width: 100%;
    max-width: 600px; /* Increased from 500px */
    display: flex;
    align-items: center;
    justify-content: center;
}

.side-image {
    width: 100%;
    height: auto;
    max-width: 500px;   /* Increased from 400px */
    max-height: 520px;  /* Increased from 430px */
    object-fit: contain;
    border-radius: 24px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.18);
}

/* Form styling */
.form-label {
    color: #555;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.login-input {
    background-color: #f5f5f5;
    border: none;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.login-input:focus {
    background-color: #e9e9e9;
    box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.3);
    border: none;
    outline: none;
}

.form-check-label {
    font-size: 0.9rem;
}

.forgot-link {
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.forgot-link:hover {
    color: #333 !important;
}

.btn-login {
    background-color: #f5982f;
    color: white;
    border: none;
    border-radius: 12px;
    padding: 0.75rem;
    font-size: 1.1rem;
    font-weight: 600;
    transition: all 0.3s ease;
    margin-top: 1rem;
}

.btn-login:hover:not(.disabled) {
    background-color: #e55a2b;
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(255, 107, 53, 0.3);
}

.btn-login.disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Responsive design */
@media (max-width: 768px) {
    .navbar {
        padding: 1rem;
    }

    /* Hide home button on small devices */
    .btn-home {
        display: none;
    }

    /* Stack layout vertically and hide image on small devices */
    .main-content {
        flex-direction: column;
        margin-top: 0;
        min-height: calc(100vh - 120px);
        justify-content: center;
        align-items: center;
    }

    .image-section {
        display: none;
    }

    .login-section {
        flex: none;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        min-height: auto;
    }

    .login-form-wrapper {
        width: 100%;
        max-width: 350px;
        margin: 0 auto;
    }

    .login-card {
        width: 100%;
        margin: 0 auto;
    }
}

@media (max-width: 480px) {
    .login-form-wrapper {
        max-width: 300px;
    }

    .login-section {
        padding: 0.5rem;
    }

    .navbar-wrapper {
        padding-left: 12px;
        padding-right: 12px;
        margin-top: 12px;
    }

    .main-content {
        min-height: calc(100vh - 100px);
    }
}
</style>
