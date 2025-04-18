<template>
    <img :src="logoSrc" :alt="altText" :class="classes">
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
    /** Ruta de la imagen del logo */
    src: {
        type: String,
        required: true,
    },
    /** Texto alternativo para la imagen */
    alt: {
        type: String,
        default: 'Logo de la Clínica',
    },
    /** Clases CSS adicionales para la imagen */
    classes: {
        type: String,
        default: '',
    },
});

const logoSrc = ref(props.src);
const altText = ref(props.alt);
const classes = ref(props.classes);
</script>