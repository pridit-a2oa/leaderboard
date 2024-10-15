<script setup>
import { BaseTable } from '@/Components/base';
import {
    faBomb,
    faCarBurst,
    faFileLines,
    faHeartPulse,
    faLandMineOn,
    faParachuteBox,
    faPlane,
    faScrewdriverWrench,
    faSyringe,
    faTents,
} from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const props = defineProps({
    statistics: {
        type: Array,
        required: true,
    },
});

const icon = {
    bomb: faBomb,
    'car-burst': faCarBurst,
    'file-lines': faFileLines,
    'heart-pulse': faHeartPulse,
    'land-mine-on': faLandMineOn,
    'parachute-box': faParachuteBox,
    plane: faPlane,
    'screwdriver-wrench': faScrewdriverWrench,
    syringe: faSyringe,
    tents: faTents,
};
</script>

<template>
    <BaseTable>
        <tr
            v-for="statistic in statistics.sort((a, b) =>
                a.name > b.name ? 1 : -1,
            )"
            class="bg-base-200 text-xs odd:bg-base-100"
        >
            <td class="text-right">
                {{ statistic.pivot.formatted_value }}
            </td>

            <td dir="ltr" class="text-left">
                <FontAwesomeIcon
                    v-if="icon[statistic.icon]"
                    class="pr-2 text-neutral-500"
                    :icon="icon[statistic.icon]"
                    fixed-width
                />{{ statistic.name }}
            </td>
        </tr>
    </BaseTable>
</template>
