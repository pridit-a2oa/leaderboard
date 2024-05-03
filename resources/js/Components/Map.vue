<script setup>
import { ref, onMounted } from 'vue';

import 'leaflet/dist/leaflet.css';
import { LMap, LTileLayer } from '@vue-leaflet/vue-leaflet';
</script>

<template>
    <div class="mt-6 h-[24rem]">
        <l-map :useGlobalLeaflet="false" zoom="4" :center="[0, 0]">
            <l-tile-layer
                url="/images/map/{z}/{x}/{y}.png"
                attribution='&copy; <a href="https://forums.bohemia.net/forums/topic/101769-takistan-map-high-resolution-14883x14884/" target="_blank">Janne Aartolahti</a>'
                :tms="true"
                :min-zoom="3"
                :max-zoom="6"
                :noWrap="true"
            ></l-tile-layer>
        </l-map>
    </div>
</template>
