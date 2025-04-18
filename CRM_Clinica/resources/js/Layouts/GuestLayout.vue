<script setup>
//import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import ClinicLogo from '@/Components/ClinicLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="min-h-screen flex flex-col sm:justify-start items-center pt-0 sm:pt-0 bg-mi-azul-claro"
    >
        <div class=" flex justify-center">
            <ClinicLogo src="/img/rblogo.png" alt="Logo de Clínica RB" class="h-60 w-60" />
        </div>

        <div
            class="mt-0 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
