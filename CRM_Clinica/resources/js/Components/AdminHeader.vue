<!-- AdminHeader.vue -->
 
<script setup>
import { ref } from 'vue'
import { Head, Link, usePage } from '@inertiajs/vue3'

const dropdownOpen = ref(false)
const user = usePage().props.auth.user

const toggleDropdown = () => {
  dropdownOpen.value = !dropdownOpen.value
}
</script>

<template>
  <header class="admin-header">
    <div class="container">
      <div class="user-info" @click="toggleDropdown">
        {{ user.name }} {{ user.surname }}
        <span class="arrow">▼</span>
      </div>

      <div v-if="dropdownOpen" class="dropdown">
        <Link :href="`/admin/users/${user.id}/edit`">Editar perfil de usuario</Link>
        <Link :href="`/admin/professionals/${user.id}/edit`">Editar perfil de profesional</Link>
        <Link href="/logout" method="post" as="button">Cerrar sesión</Link>
      </div>
    </div>
  </header>
</template>

