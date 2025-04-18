<!-- Admin layout que va para todas las paginas que este logueado un usuario admin, engloba los componentes hechos -->
<script setup>
import AdminNavigation from '@/Components/AdminNavigation.vue';
import AdminHeader from '@/Components/AdminHeader.vue'
import { Head, usePage } from '@inertiajs/vue3';

defineProps({
    title: {
        type: String,
        default: 'Panel de Administración',
    },
});

const page = usePage();
const user = page.props.auth.user; // Ajusta esto según la estructura de tus props
</script>

<template>
    <div class="admin-layout">
        <Head :title="title" />

        <aside class="admin-sidebar">
            <div class="user-info">
                <img src="/img/rblogo.png" alt="Avatar" class="user-avatar">
                <p class="user-name">{{ user.name }}</p>
                <p class="user-role">{{ user.role }}</p>
            </div>
            <AdminNavigation />
        </aside>

        <main class="admin-content">
            <AdminHeader />

        <header class="admin-page-header">
            <slot name="header">
                <h1>{{ title }}</h1>
            </slot>
        </header>

        <div class="admin-page-content">
            <slot />
        </div>
    </main>

    </div>
</template>

