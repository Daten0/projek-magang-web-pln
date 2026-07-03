public function store(Request $request, $id)
    {
        $p = $this->pesertaBimbingan()->findOrFail($id);

        // 1. Validasi 5 komponen baru
        $data = $request->validate([
            'keterampilan_teknis' => 'required|integer|min:0|max:100',
            'pemecahan_masalah'   => 'required|integer|min:0|max:100',
            'kedisiplinan'        => 'required|integer|min:0|max:100',
            'kerjasama'           => 'required|integer|min:0|max:100',
            'kehadiran'           => 'required|integer|min:0|max:100',
            'catatan'             => 'nullable|string',
        ]);

        // 2. Hitung rata-rata dibagi 5
        $totalNilai = $data['keterampilan_teknis'] + $data['pemecahan_masalah'] + $data['kedisiplinan'] + $data['kerjasama'] + $data['kehadiran'];
        $nilaiAkhir = round($totalNilai / 5);
        $status     = $nilaiAkhir >= 70 ? 'Lulus' : 'Tidak Lulus';

        // 3. Simpan ke database dengan nama kolom yang baru
        PenilaianAkhir::updateOrCreate(
            ['peserta_id' => $p->id],
            [
                'mentor_id'                   => Auth::user()->id,
                'nilai_keterampilan_teknis'   => $data['keterampilan_teknis'],
                'nilai_pemecahan_masalah'     => $data['pemecahan_masalah'],
                'nilai_kedisiplinan'          => $data['kedisiplinan'],
                'nilai_kerjasama'             => $data['kerjasama'],
                'nilai_kehadiran'             => $data['kehadiran'],
                'nilai_akhir'                 => $nilaiAkhir,
                'status_kelulusan'            => $status,
                'catatan'                     => $data['catatan'],
                'dinilai_pada'                => \Carbon\Carbon::now(),
            ]
        );

        return redirect()->route('mentor.penilaian-akhir')->with('success', 'Penilaian berhasil disimpan!');
    }