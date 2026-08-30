<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Cetak Rapor KHS - {{ $student->name }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Font Resmi Dokumen */
        @import url('https://fonts.googleapis.com/css2?family=Times+New+Roman:wght@400;700&display=swap');

        /* ======================================= */
        /* CSS UNTUK TAMPILAN DI LAYAR MONITOR/HP  */
        /* ======================================= */
        body {
            font-family: 'Times New Roman', serif;
            background-color: #e2e8f0;
            color: #000;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .viewport-wrapper {
            display: flex;
            justify-content: center;
            padding: 40px 20px;
            min-height: 100vh;
        }

        /* Simulator Kertas A4 */
        .a4-container {
            width: 210mm;
            min-height: 297mm;
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            padding: 15mm 20mm; /* Jarak Teks ke Ujung Kertas */
            position: relative;
            box-sizing: border-box;
        }

        /* Skalasi HP */
        @media screen and (max-width: 850px) {
            .viewport-wrapper {
                display: block;
                padding: 15px;
                padding-bottom: 120px;
                overflow-x: hidden;
            }
            .a4-container {
                transform-origin: top left;
                transform: scale(calc((100vw - 30px) / 794));
                margin-bottom: calc(-1123px * (1 - ((100vw - 30px) / 794)));
            }
        }

        /* Floating UI Button */
        .floating-ui {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 50;
        }

        @media screen and (max-width: 640px) {
            .floating-ui {
                top: auto;
                bottom: 20px;
                right: 15px;
                left: 15px;
                flex-direction: row;
                justify-content: center;
            }
            .floating-ui button, .floating-ui a {
                flex: 1;
                text-align: center;
                justify-content: center;
            }
        }

        /* ======================================= */
        /* CSS KHUSUS MESIN PRINTER (Print Mode)   */
        /* ======================================= */
        @media print {
            @page {
                size: A4 portrait;
                margin: 0mm; /* Matikan margin default browser agar URL/Tanggal di pojok hilang */
            }
            body {
                background: white;
                padding: 0;
                margin: 0;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            .floating-ui { display: none !important; }

            .viewport-wrapper {
                padding: 0 !important;
                margin: 0 !important;
                display: block !important;
            }

            .a4-container {
                width: 210mm !important;
                min-height: 297mm !important;
                padding: 15mm 20mm !important; /* Pertahankan padding kertas asli saat di-print */
                box-shadow: none !important;
                border: none !important;
                margin: 0 auto !important;
                transform: none !important;
                zoom: 1 !important;
            }

            .page-break { page-break-before: always; }
            .no-break { page-break-inside: avoid; }
        }

        /* ======================================= */
        /* GAYA ELEMEN DOKUMEN (KOP, TABEL, TTD)   */
        /* ======================================= */
        .kop-surat {
            border-bottom: 4px double #000;
            margin-bottom: 25px;
            padding-bottom: 15px;
            text-align: center;
        }

        .info-table {
            width: 100%;
            font-size: 11pt;
            line-height: 1.6;
        }
        .info-table td {
            vertical-align: top;
            padding: 2px 5px;
        }

        .table-official {
            width: 100%;
            border-collapse: collapse;
            font-size: 11pt;
            margin-bottom: 25px;
            border: 1px solid #000;
        }
        .table-official th, .table-official td {
            border: 1px solid #000;
            padding: 8px 10px;
            text-align: left;
        }
        .table-official th {
            background-color: #f1f5f9;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Tombol Khusus Layar UI (Sembunyi saat Print) -->
    <div class="floating-ui">
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3.5 rounded-xl text-xs sm:text-sm font-bold shadow-2xl transition-all cursor-pointer flex items-center gap-2 border border-blue-400">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            <span class="hidden sm:inline">Cetak PDF / Print</span>
            <span class="sm:hidden">Cetak KHS</span>
        </button>
        <a href="{{ route('admin.reports.index') }}" class="bg-slate-800 hover:bg-slate-900 text-white px-6 py-3.5 rounded-xl text-xs sm:text-sm font-bold shadow-2xl transition-all cursor-pointer flex justify-center border border-slate-700">
            Kembali
        </a>
    </div>

    <!-- WRAPPER VIRTUAL UNTUK SKALASI -->
    <div class="viewport-wrapper">

        <!-- KERTAS A4 -->
        <div class="a4-container">

            <!-- KOP SURAT FORMAL TANPA LOGO -->
            <div class="kop-surat">
                <div style="font-size: 14pt; font-weight: bold; letter-spacing: 0.5px; white-space: nowrap;">KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</div>
                <div style="font-size: 16pt; font-weight: bold; margin: 2px 0;">PLATFORM SMART-ECO E-LEARNING</div>
                <div style="font-size: 13pt; font-weight: bold;">PROGRAM STUDI PENDIDIKAN FISIKA</div>
                <div style="font-size: 13pt; font-weight: bold;">UNIVERSITAS SRIWIJAYA</div>
                <div style="font-size: 10pt; font-style: normal; margin-top: 4px;">Jalan Raya Palembang - Prabumulih Km. 32 Indralaya, Ogan Ilir 30662</div>
            </div>

            <div style="text-align: center; margin-bottom: 30px;">
                <h3 style="font-size: 14pt; font-weight: bold; text-decoration: underline; margin: 0; letter-spacing: 1px;">KARTU HASIL STUDI (KHS) / RAPOR</h3>
                <p style="font-size: 11pt; margin-top: 5px;">Tahun Akademik: {{ date('Y') }} / {{ date('Y', strtotime('+1 year')) }}</p>
            </div>

            <!-- IDENTITAS MAHASISWA & FOTO -->
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 35px;">

                <!-- Menggunakan Table Murni agar spasi titik dua (:) sejajar rapi -->
                <table class="info-table" style="width: 75%;">
                    <tr><td style="width: 25%;">Nama Lengkap</td> <td style="width: 2%;">:</td> <td><strong>{{ strtoupper($student->name) }}</strong></td></tr>
                    <tr><td>NIM</td> <td>:</td> <td>{{ $student->nim ?? '-' }}</td></tr>
                    <tr><td>Email Akun</td> <td>:</td> <td>{{ $student->email }}</td></tr>
                    <tr><td>Jenis Kelamin</td> <td>:</td> <td>{{ $student->jenis_kelamin == 'L' || $student->jenis_kelamin == 'Laki-Laki' ? 'Laki-laki' : ($student->jenis_kelamin == 'P' || $student->jenis_kelamin == 'Perempuan' ? 'Perempuan' : '-') }}</td></tr>
                    <tr>
                        <td>Kelas</td>
                        <td>:</td>
                        <td>
                            @if($student->classrooms && $student->classrooms->count() > 0)
                                {{ $student->classrooms->first()->name }}
                            @else
                                {{ $student->kode_kelas ?? 'Umum / Belum Masuk Kelas' }}
                            @endif
                        </td>
                    </tr>
                </table>

                <!-- FOTO 3x4 DARI PROFIL MAHASISWA -->
                <div style="width: 3cm; height: 4cm; border: 1px solid #000; display: flex; align-items: center; justify-content: center; overflow: hidden; background: #f8fafc; flex-shrink: 0;">
                    @if($student->avatar || $student->foto)
                        <img src="{{ asset('storage/' . ($student->avatar ?? $student->foto)) }}" alt="Foto 3x4" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <span style="font-size: 10pt; font-weight: bold; color: #94a3b8; text-align: center;">FOTO<br>3x4</span>
                    @endif
                </div>
            </div>

            <!-- TABEL 1: PROGRESS MODUL -->
            <div class="no-break">
                <h4 style="font-size: 11pt; font-weight: bold; margin-bottom: 8px;">A. HASIL PEMBELAJARAN MODUL TEORI</h4>
                <table class="table-official">
                    <thead>
                        <tr>
                            <th style="width: 8%;">No.</th>
                            <th style="width: 47%;">Nama Modul Pembelajaran</th>
                            <th style="width: 20%;">Penyelesaian (%)</th>
                            <th style="width: 25%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($student->userProgresses ?? [] as $index => $progress)
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td>{{ $progress->module->title ?? 'Modul Telah Dihapus' }}</td>
                            <td style="text-align: center;">{{ $progress->progress_percentage }}%</td>
                            <td style="text-align: center; font-weight: bold;">
                                @if($progress->progress_percentage >= 50)
                                    TUNTAS
                                @else
                                    BELUM TUNTAS
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; font-style: italic; color: #475569;">Belum ada riwayat pembelajaran modul teori.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- TABEL 2: EVALUASI / TUGAS -->
            <div class="no-break" style="margin-top: 25px;">
                <h4 style="font-size: 11pt; font-weight: bold; margin-bottom: 8px;">B. HASIL EVALUASI & PENUGASAN</h4>
                <table class="table-official">
                    <thead>
                        <tr>
                            <th style="width: 8%;">No.</th>
                            <th style="width: 47%;">Topik Penugasan / Evaluasi Kuis</th>
                            <th style="width: 20%;">Nilai Akhir (0-100)</th>
                            <th style="width: 25%;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $kkm = 70; @endphp <!-- Default KKM -->
                        @forelse($student->examAttempts ?? [] as $index => $exam)
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td>{{ $exam->assessment->title ?? 'Tugas Telah Dihapus' }}</td>
                            <td style="text-align: center; font-weight: bold; font-size: 12pt;">{{ $exam->total_score ?? '0' }}</td>
                            <td style="text-align: center; font-weight: bold;">
                                @if(($exam->total_score ?? 0) >= $kkm)
                                    LULUS
                                @else
                                    <span style="text-decoration: underline;">MENGULANG</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; font-style: italic; color: #475569;">Belum ada riwayat pengerjaan evaluasi maupun tugas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- TANDA TANGAN -->
            <div class="no-break" style="margin-top: 60px; margin-left: auto; width: 220px;">
                <div style="width: 100%; text-align: left;">
                    <p style="margin: 0 0 5px 0; font-size: 11pt;">Indralaya, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                    <p style="margin: 0 0 0 0; font-size: 11pt;">Dosen Pengampu Mata Kuliah,</p>

                    <!-- Ruang Kosong untuk Tanda Tangan Pulpen -->
                    <div style="height: 80px;"></div>

                    <p style="margin: 0 0 0 0; font-size: 11pt; font-weight: bold">Evelina Astra Patriot, M.Pd.</p>
                    <p style="margin: 0; font-size: 11pt;">NIP. 199301142022032011</p>
                </div>
            </div>

        </div> <!-- End of A4 Container -->

    </div> <!-- End of Viewport Wrapper -->

</body>
</html>
