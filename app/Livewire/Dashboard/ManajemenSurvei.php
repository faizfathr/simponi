<?php

    namespace App\Livewire\Dashboard;

    use App\Models\KegiatanSurvei;
    use Carbon\Carbon;
    use Livewire\Component;
    use App\Models\ListKegiatan;
    use Livewire\WithPagination;
    use App\Models\KegiatanSurvei as KegiatanSurveiModel;
    use Illuminate\Validation\Rule;
    use Livewire\WithoutUrlPagination;
    use Illuminate\Support\Facades\Validator;

    class ManajemenSurvei extends Component
    {
        use WithPagination, WithoutUrlPagination;
    public $id, $kegiatan;
        public bool $showNotif = FALSE;
        public string $id_kegiatan, $periode = "", $action = 'Tambah', $ketWaktu = '', $message = '', $status = '', $qSearch = '', $querySearchKegiatan = '';
        public $tanggal_mulai = null, $tanggal_selesai = null;
        public int $tahun = 2025, $waktu, $target = 0, $perPage = 10;
        public bool $openForm = FALSE, $openWarningDelete = FALSE;
        public array $listBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        public array $ketPeriode = ['Bulan', 'Triwulan', 'Subround', 'Tahun'];

        public array $romawiFont = ["I", "II", "III", "IV"];
        public $kegiatanSurvei;
        
        
        
        public function mount()
    {
        $this->kegiatanSurvei = \App\Models\KegiatanSurvei::all(); // ambil data dari model Survei
    }
    public function submitForm()
        {
            if ($this->action === 'Tambah') $this->insert();
            else $this->update();
        }
        public function insert()
        {

            $validator = Validator::make([
                'tahun' => $this->tahun,
                'target' => $this->target,
                'id_kegiatan' => $this->id_kegiatan ?? 'NULL',
            ], [
                'tahun' => 'required|integer',
                'target' => 'required|integer|min:1',
                'id_kegiatan' => [
                    'required',
                    'exists:kegiatan_survei,id',
                    Rule::unique('list_kegiatan', 'id_kegiatan')
                        ->where(fn($query) => $query->where('tahun', $this->tahun ?? 'NULL')),
                ],
            ], [
                'tahun.required' => 'Tahun harus diisi',
                'target.required' => 'Target harus diisi',
                'target.min' => 'Target harus lebih dari 0',
                'id_kegiatan.required' => 'Kegiatan harus dipilih',
                'id_kegiatan.exists' => 'Kegiatan tidak ditemukan',
                'id_kegiatan.unique' => 'Target untuk kegiatan ini sudah ada pada tahun yang sama',
            ]);

            $validator->validate();
            $surveiTarget = KegiatanSurvei::where('id', $this->id_kegiatan)->first();
            $this->periode = $surveiTarget->periode;
            if ($this->periode == 1) {
                $this->loopTask(12);
            } elseif ($this->periode == 2) {
                $this->loopTask(4);
            } elseif ($this->periode == 3) {
                $this->loopTask(3);
            } else {
                $this->loopTask(1);
            }
            $this->openForm = FALSE;
            $this->message = "Target berhasil ditambahkan";
            $this->status = "Berhasil";
            $this->showNotif =  TRUE;
        }

    private function loopTask($intervalTask)
        {
            $time = 1;
            while ($time <= $intervalTask) {
                ListKegiatan::create([
                    'id_kegiatan' => $this->id_kegiatan,
                    'tahun' => $this->tahun,
                    'waktu' => $time,
                    'target' => $this->target,
                    'tanggal_mulai' => Carbon::make($this->tanggal_mulai),
                    'tanggal_selesai' => Carbon::make($this->tanggal_selesai),
                    'created_at' => Carbon::now(),
                    'udpated_at' => Carbon::now(),
                ]);
                $time++;
            }
        }

        public function tambahForm()
{
    $this->reset([
        'id', 'kegiatan', 'id_kegiatan', 'periode', 'tanggal_mulai',
        'tanggal_selesai', 'target', 'openWarningDelete', 'action', 'openForm'
    ]);
    
    $this->resetValidation();
    $this->openForm = true;

    // Ambil ulang data kegiatan survei
    $this->kegiatanSurvei = \App\Models\KegiatanSurvei::all();
}





        public function render()
        {
            return view('livewire.dashboard.manajemen-survei');
        }

    }
