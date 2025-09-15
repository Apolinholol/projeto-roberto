<script setup lang="ts">
import App from '@/pages/App.vue'
import StatCard from '@/components/StatCard.vue'
import { onMounted, ref } from 'vue'
import { Chart, registerables } from 'chart.js'
import { Link } from '@inertiajs/vue3'
import { type NavItem } from '@/types';
import { ShieldCheck, BarChart3, Users, Package, Tag } from 'lucide-vue-next'

defineOptions({ layout: App })

const props = defineProps<{
    metrics: {
        adsCreatedToday: number
        usersCreatedToday: number
        adsByCategory: Array<{ name: string; count: number }>
        adsStatusData: Array<{ status: string; count: number }>
        totalAds: number
        totalCategories: number
        totalUsers: number
    }
}>()

// Definindo a navegação principal
const mainNavItems = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: ShieldCheck,
    },
    {
        title: 'Métricas',
        href: '/admin/metrics',
        icon: BarChart3,
    },
    {
        title: 'Usuários',
        href: '/admin/users',
        icon: Users,
    },
    {
        title: 'Anúncios',
        href: '/admin/ads',
        icon: Package,
    },
    {
        title: 'Categorias',
        href: '/admin/categories',
        icon: Tag,
    },
];

Chart.register(...registerables)

const categoryChartRef = ref<HTMLCanvasElement>()
const statusChartRef = ref<HTMLCanvasElement>()

onMounted(() => {
    if (categoryChartRef.value) {
        new Chart(categoryChartRef.value, {
            type: 'bar',
            data: {
                labels: props.metrics.adsByCategory.map(item => item.name),
                datasets: [{
                    label: 'Quantidade de Anúncios',
                    data: props.metrics.adsByCategory.map(item => item.count),
                    backgroundColor: [
                        'rgb(0, 45, 23)',
                        'rgb(0, 45, 23)',
                        'rgb(0, 45, 23)',
                        'rgb(0, 45, 23)',
                        'rgb(0, 45, 23)',
                        'rgb(0, 45, 23)'
                    ],
                    borderColor: [
                        'rgb(0, 45, 23)',
                        'rgb(0, 45, 23)',
                        'rgb(0, 45, 23)',
                        'rgb(0, 45, 23)',
                        'rgb(0, 45, 23)',
                        'rgb(0, 45, 23)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Anúncios por Categoria'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        })
    }

    if (statusChartRef.value) {
        new Chart(statusChartRef.value, {
            type: 'doughnut',
            data: {
                labels: props.metrics.adsStatusData.map(item => item.status),
                datasets: [{
                    data: props.metrics.adsStatusData.map(item => item.count),
                    backgroundColor: [
                        'rgb(0, 45, 23)',
                        'rgb(25, 135, 84)'
                    ],
                    borderColor: [
                        'rgb(0, 45, 23)',
                        'rgb(25, 135, 84)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Status dos Anúncios'
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        })
    }
})
</script>

<template>
    <div class="bg-white">
        <div class="container py-4">
            <!-- Admin Navigation -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Menu de navegação</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <Link v-for="item in mainNavItems" :key="item.title" :href="item.href" class="btn btn-success d-flex align-items-center gap-2">
                            <component :is="item.icon" :size="20" />
                            <span>{{ item.title }}</span>
                        </Link>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Métricas do Dashboard</h1>
                <small class="text-muted">Dados atualizados em tempo real</small>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <h5 class="card-title text-success">Anúncios Criados Hoje</h5>
                            <h2 class="display-4 text-success mb-0">{{ metrics.adsCreatedToday }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <h5 class="card-title text-success">Usuários Criados Hoje</h5>
                            <h2 class="display-4 text-success mb-0">{{ metrics.usersCreatedToday }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cards de totais gerais -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <StatCard title="Total de Usuários" :value="metrics.totalUsers" icon="Users" />
                </div>
                <div class="col-md-4 mb-3">
                    <StatCard title="Total de Anúncios" :value="metrics.totalAds" icon="Package" />
                </div>
                <div class="col-md-4 mb-3">
                    <StatCard title="Total de Categorias" :value="metrics.totalCategories" icon="Folder" />
                </div>
            </div>

            <!-- Gráficos -->
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Anúncios por Categoria</h5>
                        </div>
                        <div class="card-body">
                            <canvas ref="categoryChartRef" style="max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Status dos Anúncios</h5>
                        </div>
                        <div class="card-body">
                            <canvas ref="statusChartRef" style="max-height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabela de detalhes por categoria -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Detalhes por Categoria</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Categoria</th>
                                    <th>Quantidade de Anúncios</th>
                                    <th>Percentual</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="category in metrics.adsByCategory" :key="category.name">
                                    <td>{{ category.name }}</td>
                                    <td>{{ category.count }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ metrics.totalAds > 0 ? Math.round((category.count / metrics.totalAds) * 100) : 0 }}%
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.display-4 {
    font-size: 2.5rem;
    font-weight: 300;
}

.border-primary {
    border-color: #0d6efd !important;
}

.border-success {
    border-color: #198754 !important;
}
</style>