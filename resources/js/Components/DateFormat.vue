<template>
    <span>{{ formattedDate }}</span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    date: {
        type: [String, Date],
        required: true
    },
    format: {
        type: String,
        default: 'long' // 'short', 'long', 'time', 'datetime'
    }
});

const formattedDate = computed(() => {
    const dateObj = new Date(props.date);
    
    if (props.format === 'short') {
        return dateObj.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    }
    
    if (props.format === 'long') {
        return dateObj.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }
    
    if (props.format === 'time') {
        return dateObj.toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit'
        });
    }
    
    if (props.format === 'datetime') {
        return dateObj.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }
    
    return dateObj.toLocaleDateString();
});
</script>
