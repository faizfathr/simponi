<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PuppeteerController extends Controller
{
    public function run()
    {
        $output = shell_exec('node ' . base_path('public/js/puppeteer-script.js'));
        dd($output);
        return response()->json(['message' => 'Puppeteer berhasil dijalankan!', 'output' => $output]);
    }
}
