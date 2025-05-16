@extends('layouts.home-layout')
@section('contents')
    <div class="container flex flex-col border justify-center">
        <div class="flex justify-between">
            <div class="w-[100px]">
                <img src="/img/bps.png" alt="logo bps">
            </div>
            <div class="border border-slate-400 items-center justify-center flex p-1">
                <div class="border border-slate-500 h-[100%] p-1">
                    <p class="font-bold text-sm">DAFTAR PP-TPI</p>
                </div>
            </div>
        </div>
        <div class="text-center">
            <h1 class="uppercase">
                Republik Indonesia
            </h1>
            <p>Badan Pusat Statistik</p>
        </div>
        <div class="border-2 border-slate-900 uppercase font-semibold text-center py-4 px-2 mt-5 w-max-content">
            <p>laporan triwulanan</p>
            <p>pelabuhan perikanan (PPS/ppn/ppp/ppi) & tempat pelelangan ikan (tpi)</p>
        </div>
        <div class="flex gap-x-4">
            <div class="w-1/4">
                <x-survei.pp-tpi.side-nav blok="Blok I-II" keterangan="Keterangan Umum" :active="true" />
                <x-survei.pp-tpi.side-nav blok="Blok III" keterangan="Keterangan Pendaratan Ikan" :active="false" />
                <x-survei.pp-tpi.side-nav blok="Blok IV" keterangan="Hasil Tangkapan" :active="false" />
                <x-survei.pp-tpi.side-nav blok="Blok V"
                    keterangan="RATA RATA BANYAKNYA PERAHU/KAPAL YANG MENDARATKAN IKAN, JENIS ALAT TANGKAP DAN KONDISI HASIL TANGKAPAN"
                    :active="false" />
                <x-survei.pp-tpi.side-nav blok="Blok VI-VII" keterangan="Akhir" :active="false" />
            </div>
            <div class="w-3/4 border">
                <div class="grid grid-cols-3 px-4 py-2">
                    <div class="inline-flex items-center text-slate-600">
                        <span class="mr-2">1. </span>
                        <p class="font-semibold text-base">Provinsi</p>
                    </div>
                    <div class="">
                        <input type="text" value="Kalimantan Barat"
                            class="input input-bordered w-full max-w-xs text-slate-600" />
                    </div>
                    <input type="text" value="61" class="input input-bordered input-sm  text-slate-600" />
                </div>
            </div>
        </div>
    </div>
@endsection
