<?php

namespace App\Livewire\Administrasi;

use App\Models\Mitra;
use App\Models\SuratTugas as ModelsSuratTugas;
use Carbon\Carbon;
use Livewire\Component;

class SuratTugas extends Component
{

    public bool $openModal = false, $showNotif = false, $openDeleteModal = false;
    public $petugas;
    public $noSuratTerakhir;
    public string $nomorSuratTarget = '';
    public array $alfabet= ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
    public string $pembebanan = '',
        $selectedSuratSelipan = '',
        $tempat = 'SINGKAWANG',
        $tujuanTugas = '',
        $kegiatan = '',
        $noSuratRujukan = '',
        $kepalaSuratRujukan = '',
        $perihalRujukan = '',
        $noSurat = '',
        $pesan = '',
        $statusNotif = '';
    public $tanggalMulai = '', $tanggalSelesai = '', $tanggalSurat = '';
    public array $selectedPetugas = [];
    public int $penandatangan = 0, $subtim = 0;
    public $idSuratTugas;

    public function render()
    {
        $this->petugas = Mitra::select('id', 'nama')->get()->toArray();
        $this->noSuratTerakhir = $this->getLatestNoSurat();
        $listSuratTugas = ModelsSuratTugas::orderBy('created_at', 'desc')->get();
        return view('livewire.administrasi.surat-tugas', compact('listSuratTugas'));
    }

    private function getLatestNoSurat(): int
    {
        $this->noSuratTerakhir = ModelsSuratTugas::latest()->first();
        if ($this->noSuratTerakhir) {
            $jumlahPetugas = count(explode(',', $this->noSuratTerakhir->id_petugas));
            $this->noSuratTerakhir = (int) substr($this->noSuratTerakhir->nomor_surat, 2, 3) + $jumlahPetugas - 1;
            return $this->noSuratTerakhir;
        } else {
            return 0; // Mulai dari nomor 1 jika belum ada surat
        }
    }

    public function simpanSurat()
    {

        // Simpan data ke database
        ModelsSuratTugas::create([
            'nomor_surat' => $this->noSurat,
            'nomor_surat_rujukan' => $this->noSuratRujukan,
            'perihal' => $this->perihalRujukan,
            'kepala_surat_rujukan' => $this->kepalaSuratRujukan,
            'subtim' => $this->subtim,
            'tanggal_penandatanganan' => $this->tanggalSurat,
            'id_petugas' => implode(',', $this->selectedPetugas),
            'tujuan_tugas' => $this->tujuanTugas,
            'tempat' => $this->tempat,
            'waktu_pelaksanaan' => $this->reformatTanggalSurat($this->tanggalMulai, $this->tanggalSelesai),
            'penandatangan' => $this->penandatangan,
            'kegiatan' => $this->kegiatan,
            'pembebanan' => $this->pembebanan,
            'created_at' => now(),
            'updated_at' => now(),
            // Tambahkan field lain sesuai kebutuhan
        ]);

        // Reset form dan tutup modal
        $this->resetForm();
        $this->openModal = false;
        $this->pesan = 'Surat tugas berhasil disimpan!';
        $this->statusNotif = 'Berhasil';
        $this->showNotif = true;
    }

    private function reformatTanggalSurat($tanggalMulai, $tanggalSelesai): string
    {
        $tanggalMulai = Carbon::parse($tanggalMulai);
        $tanggalSelesai = Carbon::parse($tanggalSelesai);

        if ($tanggalMulai->isSameDay($tanggalSelesai)) {
            return $tanggalMulai->locale('id')->translatedFormat('d F Y');
        } elseif ($tanggalMulai->isSameMonth($tanggalSelesai)) {
            return $tanggalMulai->locale('id')->translatedFormat('d') . ' - ' . $tanggalSelesai->locale('id')->translatedFormat('d F Y');
        } else {
            return $tanggalMulai->locale('id')->translatedFormat('d F') . ' - ' . $tanggalSelesai->locale('id')->translatedFormat('d F Y');
        }
    }

    private function resetForm()
    {
        $this->noSuratTerakhir = $this->getLatestNoSurat();
        $this->tujuanTugas = '';
        $this->tempat = 'SINGKAWANG';
        $this->kegiatan = '';
        $this->noSuratRujukan = '';
        $this->kepalaSuratRujukan = '';
        $this->perihalRujukan = '';
        $this->noSurat = '';
        $this->tanggalMulai = '';
        $this->tanggalSelesai = '';
        $this->tanggalSurat = '';
        $this->penandatangan = 0;
        $this->pembebanan = '';
        $this->subtim = 0;
        $this->selectedPetugas = [];
        // Reset field lain sesuai kebutuhan
    }

    public function generateSuratTugas($target)
    {
        // $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('template/template_surat_tugas.docx'));

        $templateProcessor->cloneBlock('blok_surtus', count(explode(',', $target->id_petugas)), true, true);

        foreach (explode(',', $target->id_petugas) as $index => $idPetugas) {

            $i = $index + 1; // Karena cloneBlock dimulai dari 1
            $newNoSurat = $this->incNoSurat(substr($target->nomor_surat, 2, 3), $index);

            $petugas = Mitra::find($idPetugas);
            if ($i == 1) {
                $templateProcessor->setValue('nomor_surat#' . $i, $target->nomor_surat);
            } else {
                $templateProcessor->setValue('nomor_surat#' . $i, $newNoSurat);
                $target->nomor_surat = $this->selectedSuratSelipan ? $target->nomor_surat : $newNoSurat; // Update nomor surat untuk petugas berikutnya
            }
            $templateProcessor->setValue('nomor_surat_rujukan#' . $i, $target->nomor_surat_rujukan);
            $templateProcessor->setValue('kepala_surat_rujukan#' . $i, $target->kepala_surat_rujukan);
            $templateProcessor->setValue('perihal#' . $i, $target->perihal);
            $templateProcessor->setValue('petugas#' . $i, $petugas ? $petugas->nama : 'N/A');
            $templateProcessor->setValue('nip#' . $i, is_null($petugas->nip) ? '-' : $petugas->nip);
            $templateProcessor->setValue('jabatan#' . $i, is_null($petugas->jabatan) ? 'Mitra Statistik' : $petugas->getJabatan->nama_jabatan);
            $templateProcessor->setValue('pangkat#' . $i, is_null($petugas->golongan) ? '-' : $petugas->getGolongan->nama_golongan);
            $templateProcessor->setValue('tujuan_tugas#' . $i, $target->tujuan_tugas);
            $templateProcessor->setValue('tempat#' . $i, $target->tempat);
            $templateProcessor->setValue('tanggal_pelaksanaan#' . $i, $target->waktu_pelaksanaan);
            $templateProcessor->setValue('tanggal_surat#' . $i, Carbon::parse($target->tanggal_penandatanganan)->locale('id')->translatedFormat('d F Y'));
            $templateProcessor->setValue('penandatanganan#' . $i, $target->penandatangan ?  'IRWAN AGUSTIAN' : 'YANUAR LESTARIATI');
            $templateProcessor->setValue('kegiatan#' . $i, $target->kegiatan);
            $templateProcessor->setValue('pembebanan#' . $i, $target->pembebanan);
        }
        // Ganti placeholder dengan data yang sesuai
        // Simpan file yang dihasilkan
        $filePath = public_path('output_surat_tugas/' . 'Surat Tugas_' . substr($target->nomor_surat, 0, 5) . '.docx');
        $templateProcessor->saveAs($filePath);
        return $filePath;
    }

    public function download($idSurtus)
    {
        $target = ModelsSuratTugas::find($idSurtus);
        $docxPath = $this->generateSuratTugas($target);
        
        return response()->download($docxPath)->deleteFileAfterSend(true);
    }

    private function incNoSurat($noSuratTerakhir, $index = 0): string
    {
        $prefix = 'B-';
        $endfix = '/61723/kp.650/' . date('Y');
        if ((int) $noSuratTerakhir <= 9) {
            $number = '00' . ((int) $noSuratTerakhir + 1);
            $number = $this->selectedSuratSelipan ? $number . $this->alfabet[$index] : $number;
        } elseif ((int) $noSuratTerakhir <= 99) {
            $number = '0' . ((int) $noSuratTerakhir + 1);
            $number = $this->selectedSuratSelipan ? $number . $this->alfabet[$index] : $number;
        } else {
            $number = (string) ((int) $noSuratTerakhir + 1);
            $number = $this->selectedSuratSelipan ? $number . $this->alfabet[$index] : $number;
        }
        return $prefix . $number . $endfix;
    }
    public function confirmDelete($idSurtus)
    {
        $target = ModelsSuratTugas::find($idSurtus);
        $this->idSuratTugas = $target->id;
        $this->nomorSuratTarget = $target->nomor_surat;
        $this->openDeleteModal = !$this->openDeleteModal;
    }

    public function deleteSurat()
    {
        ModelsSuratTugas::find($this->idSuratTugas)->delete();
        $this->openDeleteModal = false;
        $this->pesan = 'Surat tugas berhasil dihapus!';
        $this->statusNotif = 'Berhasil';
        $this->showNotif = true;
    }
}
