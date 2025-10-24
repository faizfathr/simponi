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
            @if (session('unauthorized'))
                <x-dashboard.notification showNotif="showNotif" message="{{ session('unauthorized') }}"
                    status="Invalid Role" />
            @endif
            <!-- ===== Main Content Start ===== -->
            <main>
                <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6  dark:bg-gray-900">
                    @if (request()->routeIs('detail-monitoring'))
                        @livewire('dashboard.progres-detail', ['id' => $idPage], key($idPage))
                    @endif
                    @if (request()->routeIs('home'))
                        <livewire:dashboard.main />
                    @endif
                    @if (request()->routeIs('monitoring-pertanian'))
                        <livewire:dashboard.monitoring-pertanian>
                    @endif
                    @if (request()->routeIs('monitoring-ipek'))
                        <livewire:dashboard.monitoring-ipek>
                    @endif
                    @if (request()->routeIs('kalender'))
                        <livewire:dashboard.kalender />
                    @endif
                    @if (request()->routeIs('target'))
                        <livewire:dashboard.target />
                    @endif
                    @if (request()->routeIs('progres-pertanian'))
                        <livewire:dashboard.progres-pertanian>
                    @endif
                    @if (request()->routeIs('progres-ipek'))
                        <livewire:dashboard.progres-ipek>
                    @endif

                    @if (request()->routeIs('reminder'))
                        <livewire:whatsapp-reminder.reminder />
                    @endif
                    @if (request()->routeIs('manajemen-survei'))
                        <livewire:dashboard.manajemen-survei />
                    @endif
                    @if (request()->routeIs('manajemen-petugas'))
                        <livewire:dashboard.petugas />
                    @endif
                    @if (request()->routeIs('about'))
                        <livewire:dashboard.about />
                    @endif
                    @if (request()->routeIs('manajemen-administrasi'))
                        <x-underconstruction />
                    @endif
                    @if (request()->routeIs('resume-detail'))
                        @livewire('monitoring.resume-detail', ['id' => $idPage, 'year' => $tahun, 'waktu' => $waktu], key($idPage))
                    @endif
                    @if (request()->routeIs('manajemen-survei.struktur-tabel'))
                        @livewire('manajemen.struktur-tabel', ['id' => $idPage], key($idPage))
                    @endif
                </div>
            </main>
            <!-- ===== Main Content End ===== -->
        </div>
        <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->
</div>
