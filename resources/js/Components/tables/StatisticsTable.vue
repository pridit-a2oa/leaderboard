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
            class="odd:bg-base-200 bg-base-100 text-xs"
        >
            <td class="text-right font-bold">
                {{ statistic.pivot.formatted_value }}
            </td>

            <td dir="ltr" class="text-left font-light tracking-wide">
                <FontAwesomeIcon
                    v-if="icon[statistic.icon]"
                    class="pr-3 text-neutral-500"
                    :icon="icon[statistic.icon]"
                />{{ statistic.name }}
            </td>

            <td class="bg-base-100 table-cell md:hidden"></td>
        </tr>
    </BaseTable>
</template>
