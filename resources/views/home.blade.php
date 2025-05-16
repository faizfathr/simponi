@extends('layouts.home-layout')
@section('contents')

    <body class="font-sans antialiased dark:bg-black dark:text-white/50 m-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2">
            <x-survei-box title="SP PADI" link="#" />
            <x-survei-box title="SPH SBS" link="#" />
            <x-survei-box title="KPPT BULANAN" link="#" />
            <x-survei-box title="PPTPI" link="/survei/pp-tpi" />
            <x-survei-box title="SP PALAWIJA" link="#" />
            <x-survei-box title="SPH BST" link="#" />
            <x-survei-box title="RUMAH POTONG HEWAN (RPH)" link="#" />
            <x-survei-box title="SP ALSINTAN TP" link="#" />
            <x-survei-box title="SPH TH" link="#" />
            <x-survei-box title="SP BENIH TP" link="#" />
            <x-survei-box title="SPH BN" link="#" />
            <a href="login_sso">Login</a>
        </div>
    @endsection
