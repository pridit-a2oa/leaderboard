<script setup>
import { UserSettings } from '@/Components/features/user';
import { Head } from '@inertiajs/vue3';
import {
    CategoryScale,
    Chart as ChartJS,
    Legend,
    LinearScale,
    LineElement,
    PointElement,
    Title,
    Tooltip,
} from 'chart.js';
import { Line } from 'vue-chartjs';

const props = defineProps({
    labels: {
        type: Array,
    },
    data: {
        type: Array,
    },
});

const noDataPlugin = {
    id: 'noData',
    afterDraw(chart) {
        if (!chart.data.datasets.some((ds) => ds.data.length > 0)) {
            const { ctx, width, height } = chart;
            ctx.save();
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.font = '16px sans-serif';
            ctx.fillStyle = '#999';
            ctx.fillText('No data available', width / 2, height / 2 - 10);
            ctx.restore();
        }
    },
};

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend,
    noDataPlugin,
);

const data = {
    labels: props.labels,
    datasets: [
        {
            ...props.data[0],
            backgroundColor: 'oklch(50% 0.134 242.749)',
            borderColor: 'oklch(50% 0.134 242.749)',
            borderWidth: 3,
        },
        {
            ...props.data[1],
            backgroundColor: 'oklch(52.7% 0.154 150.069)',
            borderColor: 'oklch(52.7% 0.154 150.069)',
            borderWidth: 3,
        },
    ],
};

const options = {
    animation: false,
    responsive: true,
    maintainAspectRatio: false,
    interaction: {
        mode: 'nearest',
        intersect: false,
        axis: 'x',
    },
    plugins: {
        legend: {
            display: props.data.length !== 0,
        },
        tooltip: {
            enabled: true,
            callbacks: {
                footer: (tooltipItems) => {
                    let total = tooltipItems.reduce(
                        (a, e) => a + parseInt(e.raw),
                        0,
                    );
                    return 'Total: ' + total;
                },
            },
        },
    },
    scales: {
        y: {
            beginAtZero: true,
            ticks: {
                display: props.data.length !== 0,
                precision: 0,
                callback: function (value) {
                    return Number.isInteger(value) ? value : null;
                },
                stepSize: 1,
            },
        },
    },
};
</script>

<template>
    <Head title="Settings &dash; Dashboard" />

    <UserSettings title="Dashboard">
        <div class="bg-base-200 rounded-md p-4 [&:not(:last-child)]:mb-4">
            <Line :data="data" :options="options" />
        </div>
    </UserSettings>
</template>
