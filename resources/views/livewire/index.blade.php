<div x-data="{ showNotif: @entangle('showNotif') }">
    <!-- ===== Preloader Start ===== -->

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
            <livewire:dashboard.header />
            <!-- ===== Header End ===== -->
            <x-dashboard.notification showNotif="showNotif" message="test" />
            <!-- ===== Main Content Start ===== -->
            <main>
                <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    @if ($idPage)
                        @livewire('dashboard.progres-detail', ['id' => $idPage], key($idPage))
                    @else
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
                        <template x-if="page == 'Progres' && subPage == 'Pertanian' ">
                            <livewire:dashboard.progres-pertanian />
                        </template>
                        <template x-if="page == 'Progres' && subPage == 'IPEK' ">
                            <livewire:dashboard.progres-ipek />
                        </template>
                    @endif

                </div>
            </main>
            <!-- ===== Main Content End ===== -->
        </div>
        <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->
</div>
