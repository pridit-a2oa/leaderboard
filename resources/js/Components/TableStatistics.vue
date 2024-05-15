<script setup>
import { library } from '@fortawesome/fontawesome-svg-core';
import {
    faParachuteBox,
    faTents,
    faPlane,
    faLandMineOn,
    faHeartPulse,
    faFileLines,
    faSyringe,
    faBomb,
    faScrewdriverWrench,
    faCarBurst,
} from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(
    faParachuteBox,
    faTents,
    faPlane,
    faLandMineOn,
    faHeartPulse,
    faFileLines,
    faSyringe,
    faBomb,
    faScrewdriverWrench,
    faCarBurst,
);

const props = defineProps({
    data: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <table class="table border-collapse">
        <tr
            v-for="statistic in data.sort((a, b) => (a.name > b.name ? 1 : -1))"
            class="bg-base-200 text-xs odd:bg-base-100"
        >
            <td class="w-14"></td>

            <td>
                <FontAwesomeIcon
                    class="mr-2 text-neutral-500"
                    :icon="statistic.icon"
                    fixed-width
                />{{ statistic.name }}
            </td>

            <td class="hidden md:table-cell"></td>

            <td class="text-right">
                {{ statistic.pivot.formatted_value }}
            </td>

            <td class="hidden w-14 md:table-cell"></td>
        </tr>
    </table>
</template>
