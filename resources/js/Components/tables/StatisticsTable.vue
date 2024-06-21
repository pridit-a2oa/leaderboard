<script setup>
import { BaseTable } from '@/Components/base';
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

const props = defineProps({
    statistics: {
        type: Array,
        required: true,
    },
});

const icon = {
    'parachute-box': faParachuteBox,
    tents: faTents,
    plane: faPlane,
    'land-mine-on': faLandMineOn,
    'heart-pulse': faHeartPulse,
    'file-lines': faFileLines,
    syringe: faSyringe,
    bomb: faBomb,
    'screwdriver-wrench': faScrewdriverWrench,
    'car-burst': faCarBurst,
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
            <td class="hidden w-[2.35rem] bg-base-100 md:table-cell"></td>

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
