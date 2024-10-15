<script setup>
import { LMap, LTileLayer } from '@vue-leaflet/vue-leaflet';
import 'leaflet/dist/leaflet.css';
</script>

<template>
    <div class="mt-6 h-[24rem] rounded-lg bg-base-200 p-4 opacity-80">
        <l-map :useGlobalLeaflet="false" zoom="4" :center="[0, 0]">
            <l-tile-layer
                url="/images/takistan/{z}/{x}/{y}.png"
                attribution='&copy; <a href="https://forums.bohemia.net/forums/topic/101769-takistan-map-high-resolution-14883x14884/" target="_blank">Janne Aartolahti</a>'
                :tms="true"
                :min-zoom="3"
                :max-zoom="6"
                :noWrap="true"
            ></l-tile-layer>
        </l-map>
    </div>
</template>
