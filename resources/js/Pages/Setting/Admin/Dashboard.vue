<script setup>
import { UserSettings } from '@/Components/features/user';
import { Head, router } from '@inertiajs/vue3';
import {
    computed,
    defineAsyncComponent,
    h,
    onBeforeUnmount,
    onMounted,
    ref,
    watch,
} from 'vue';

const props = defineProps({
    labels: Array,
    data: Array,
    period: Number,
});

const period = ref(Number(props.period) || undefined);

watch(period, (days) => {
    router.reload({
        data: { period: days },
        only: ['labels', 'data', 'period'],
        preserveScroll: true,
    });
});

const apexchart = defineAsyncComponent({
    loader: () => import('vue3-apexcharts'),
    loadingComponent: {
        render: () => h('div', { class: 'h-[190px] skeleton bg-base-200' }),
    },
    delay: 0,
});

function getMaxScale(seriesList) {
    let max = 0;

    if (!seriesList.length || !seriesList[0].data.length) return max;

    const numPoints = seriesList[0].data.length;

    for (let i = 0; i < numPoints; i++) {
        const total = seriesList.reduce(
            (sum, s) => sum + (Number(s.data[i]?.y) || 0),
            0,
        );

        if (total > max) max = total;
    }

    return Math.ceil((max + 10) / 10) * 10;
}

const chartSeries = computed(() =>
    props.data.slice(0, 2).map(({ label, data }) => ({
        name: label,
        data: props.labels.map((x, i) => ({ x, y: data?.[i] ?? 0 })),
    })),
);

const chartOptions = ref({
    chart: {
        animations: { enabled: false },
        toolbar: { show: false },
        zoom: { enabled: false },
    },
    colors: ['#0069a8', '#00a63e'],
    dataLabels: {
        enabled: true,
        formatter: (_val, { seriesIndex, dataPointIndex, w }) => {
            const values = w.globals.series.map(
                (s) => Number(s?.[dataPointIndex]) || 0,
            );
            const total = values.reduce((a, b) => a + b, 0);
            if (total === 0) return '';
            return seriesIndex === values.indexOf(Math.max(...values))
                ? total
                : '';
        },
        offsetY: -7,
        background: {
            enabled: true,
            foreColor: '#ccc',
            borderColor: '#111',
            borderWidth: 1,
            borderRadius: 4,
            padding: 6,
        },
        style: {
            fontWeight: 500,
            colors: ['#111'],
            strokeWidth: 0,
        },
        dropShadow: {
            enabled: false,
        },
    },
    grid: {
        show: true,
        borderColor: '#333',
        strokeDashArray: 2,
        xaxis: { lines: { show: true } },
        yaxis: { lines: { show: false } },
        padding: { bottom: 6 },
    },
    legend: {
        showForSingleSeries: true,
        floating: true,
        position: 'top',
        offsetY: -5,
        labels: { colors: '#666' },
        markers: {
            strokeWidth: 0,
            size: 7,
            offsetX: -5,
            offsetY: 0,
        },
        itemMargin: { horizontal: 12, vertical: 4 },
        onItemHover: { highlightDataSeries: false },
    },
    markers: {
        hover: { size: 4 },
        discrete: [],
    },
    noData: {
        text: 'No metrics available',
        align: 'center',
        verticalAlign: 'middle',
        offsetY: -10,
        style: { color: '#999', fontSize: '16px' },
    },
    stroke: { curve: 'straight', width: 3 },
    tooltip: {
        cssClass: '!invisible min-h-20',
        custom: ({ series: s, dataPointIndex, w }) => {
            const rows = s
                .map((_, i) => {
                    const value = s[i]?.[dataPointIndex];
                    if (value === undefined) return '';
                    return `
                        <div class="flex items-center gap-1">
                            <span class="w-2 h-2 rounded-sm" style="background:${w.globals.colors[i]}"></span>
                            <span>${w.globals.seriesNames[i]}: ${value}</span>
                        </div>
                    `;
                })
                .join('');

            const total = s.reduce(
                (sum, v) => sum + (Number(v?.[dataPointIndex]) || 0),
                0,
            );

            const label =
                w.globals.categoryLabels[dataPointIndex] ??
                w.globals.labels[dataPointIndex];

            return `
                <div class="${total === 0 ? '' : 'bg-neutral-950/90 text-neutral-200 rounded-sm p-3 !visible'}">
                    <div class="font-semibold mb-1">${label}</div>
                    ${rows}
                </div>
            `;
        },
    },
    xaxis: {
        categories: props.labels,
        labels: {
            rotate: 0,
            hideOverlappingLabels: true,
            style: { colors: '#666' },
            maxHeight: 20,
            offsetY: 2,
        },
        axisTicks: { show: true },
    },
    yaxis: {
        tickAmount: 2,
        min: 0,
        max: getMaxScale(chartSeries.value),
        forceNiceScale: true,
        labels: {
            offsetX: -8,
            style: { colors: '#666', fontSize: '12px' },
            formatter: (v) => (Number.isInteger(v) ? v : ''),
        },
    },
});

const chartKey = ref(0);

const remount = () => {
    chartKey.value++;
};

const onVisibility = () => {
    if (!document.hidden) remount();
};

onMounted(() => {
    document.addEventListener('visibilitychange', onVisibility);
    window.addEventListener('focus', remount);
});
onBeforeUnmount(() => {
    document.removeEventListener('visibilitychange', onVisibility);
    window.removeEventListener('focus', remount);
});
</script>

<template>
    <Head title="Settings &dash; Dashboard" />

    <UserSettings heading="Dashboard">
        <template #header>
            <select
                v-if="data.length"
                class="select h-7 !w-auto bg-base-300 bg-none px-2 text-center select-sm"
                title="Select a time period"
                v-model.number="period"
            >
                <option :value="undefined">7 Days</option>
                <option :value="14">14 Days</option>
            </select>
        </template>

        <apexchart
            :key="chartKey"
            class="rounded-md bg-base-200 py-5 [&:not(:last-child)]:mb-4"
            type="line"
            height="150"
            :options="chartOptions"
            :series="chartSeries"
        />
    </UserSettings>
</template>
