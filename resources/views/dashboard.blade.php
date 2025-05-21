@extends('layouts.dashboard-layout')
@section('contents')
    <!-- ===== Preloader Start ===== -->
    <x-preloader />

    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
        <!-- ===== Sidebar Start ===== -->
        <livewire:dashboard.sidebar />
        <!-- ===== Sidebar End ===== -->

        <!-- ===== Content Area Start ===== -->
        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
            <!-- Small Device Overlay Start -->
            <div @click="sidebarToggle = false" :class="sidebarToggle ? 'block lg:hidden' : 'hidden'"
                class="fixed w-full h-screen z-9 bg-gray-900/50"></div>

            <!-- Small Device Overlay End -->

            <!-- ===== Header Start ===== -->
            <x-dashboard.header />
            <!-- ===== Header End ===== -->

            <!-- ===== Main Content Start ===== -->
            <main>
                <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <template x-if="page == 'Dashboard'">
                        <livewire:dashboard.main>
                    </template>
                    <template x-if="page == 'Monitoring' && subPage =='Pertanian'">
                        <livewire:dashboard.monitoring-pertanian>
                    </template>
                    <template x-if="page == 'Kalender'">
                        <livewire:dashboard.kalender>
                    </template>
                    <template x-if="page == 'Target'">
                        <livewire:dashboard.target />
                    </template>
                    <template x-if="page == 'Progres' && subPage == 'Pertanian' && detail == 'false'" >
                        <livewire:dashboard.progres-pertanian />
                    </template>
                    <template x-if="page == 'Progres' && subPage == 'IPEK' && detail == 'false'" >
                        <livewire:dashboard.progres-ipek />
                    </template>
                    <template x-if="page == 'Progres' && subPage == 'Pertanian' && detail == 'true'">
                        @livewire('dashboard.progres-detail', ['id' => $idPage], key($idPage))
                    </template>
                </div>
            </main>
            <!-- ===== Main Content End ===== -->
        </div>
        <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->
@endsection
