<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pemberitahuan Pelanggaran - {{ $sanctionDecision->student->name }}</title>
    <style>
        @page {
            margin: 20mm 25mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000000;
        }

        /* --- KOP SURAT --- */
        .header-table {
            width: 100%;
            border-bottom: 3px solid #000;
            padding-bottom: 8px;
        }

        .logo {
            width: 90px;
            height: 90px;
            text-align: center;
        }

        .logo img {
            width: 85px;
            height: auto;
        }

        .school-info {
            text-align: center;
            line-height: 1.3;
        }

        .school-name {
            font-size: 18pt;
            font-weight: bold;
        }
        
        .department-name {
            font-size: 16pt;
            font-weight: bold;
        }

        .school-address, .contact-info {
            font-size: 11pt;
        }

        /* --- JUDUL SURAT --- */
        .letter-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 30px;
            margin-bottom: 5px;
        }

        .letter-number {
            text-align: center;
            font-size: 12pt;
            margin-bottom: 30px;
        }

        /* --- KONTEN --- */
        .content {
            line-height: 1.6;
            text-align: justify;
        }

        .content p {
            margin-top: 0;
            margin-bottom: 15px;
        }

        /* Tabel untuk data (Siswa, Jadwal, dll) */
        .data-table {
            width: 100%;
            margin: 15px 0 25px 30px; /* menjorok ke dalam */
            border-collapse: collapse;
        }

        .data-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .data-label {
            width: 150px;
        }

        .data-separator {
            width: 15px;
            text-align: center;
        }

        /* --- TABEL PELANGGARAN --- */
        .violations-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 11pt;
        }

        .violations-table th, .violations-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            vertical-align: middle;
        }
        
        .violations-table td:nth-child(2),
        .violations-table td:nth-child(5) {
            text-align: left;
        }


        .violations-table thead th {
            background-color: #e9ecef;
            font-weight: bold;
        }

        .violations-table tfoot td {
            font-weight: bold;
            background-color: #f8f9fa;
        }

        /* --- TANDA TANGAN --- */
        .signature-section {
            margin-top: 40px;
            width: 100%;
        }

        .signature-box {
            width: 50%;
            text-align: center;
            line-height: 1.4;
        }

        .signature-space {
            height: 70px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }

        b { font-weight: bold; }
    </style>
</head>
<body>

    @php
        // Menghitung total poin untuk ditampilkan di footer tabel
        $totalPoin = $sanctionDecision->sanctionDecisionDetail->sum(function($detail) {
            return $detail->category?->point ?? 0;
        });
    @endphp

    <table class="header-table">
        <tr>
            <td class="logo">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Logo Sekolah">
                @endif
            </td>
            <td class="school-info">
                <div class="department-name">PEMERINTAH DAERAH PROVINSI JAWA BARAT</div>
                <div class="department-name">DINAS PENDIDIKAN</div>
                <div class="school-name">SMA NEGERI 1 BANJARAN</div>
                <div class="school-address">Jalan Ciapus No.7, Banjaran, Kabupaten Bandung, Jawa Barat 40377</div>
                <div class="contact-info">Telepon: (022) 5940642 | Website: www.sman1banjaran.sch.id</div>
            </td>
        </tr>
    </table>

    <div class="letter-title">SURAT PEMBERITAHUAN PELANGGARAN SISWA</div>
    <div class="letter-number">Nomor: {{ $sanctionDecision->code ?? '421.3/___/SMAN1-BJR' }}</div>

    <div class="content">
        <p>
            Kepada Yth.<br>
            <b>Bapak/Ibu Orang Tua/Wali Siswa</b><br>
            di Tempat
        </p>

        <p>Dengan hormat,</p>
        <p>
            Berdasarkan catatan dari Bimbingan Konseling (BK) dan Wali Kelas, dengan ini kami memberitahukan bahwa siswa yang merupakan putra/putri Bapak/Ibu:
        </p>
        
        <table class="data-table">
            <tr>
                <td class="data-label">Nama Lengkap</td>
                <td class="data-separator">:</td>
                <td><b>{{ $sanctionDecision->student->name }}</b></td>
            </tr>
            <tr>
                <td class="data-label">NISN</td>
                <td class="data-separator">:</td>
                <td>{{ $sanctionDecision->student->username }}</td>
            </tr>
            <tr>
                <td class="data-label">Kelas</td>
                <td class="data-separator">:</td>
                <td>{{ $sanctionDecision->student->classRoom->code }}</td>
            </tr>
        </table>
        
        <p>
            Telah melakukan pelanggaran tata tertib sekolah dengan rincian sebagai berikut:
        </p>

        <table class="violations-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama Pelanggaran</th>
                    <th style="width: 15%;">Tgl. Kejadian</th>
                    <th style="width: 8%;">Poin</th>
                    <th>Keterangan</th>
                    <th style="width: 20%;">Rekomendasi Sanksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sanctionDecision->sanctionDecisionDetail as $index => $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->category?->name ?? 'N/A' }}</td>
                        <td>{{ $detail->incident_date ? \Carbon\Carbon::parse($detail->incident_date)->translatedFormat('d F Y') : '-' }}</td>
                        <td>{{ $detail->category?->point ?? 0 }}</td>
                        <td>{{ $detail->comment ?? '-' }}</td>
                        <td>{{ $detail->category?->formatted_rekomendasi ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;"><b>TOTAL POIN PELANGGARAN</b></td>
                    <td><b>{{ $totalPoin }}</b></td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>

        <p>
            Menindaklanjuti hal tersebut, kami sangat mengharapkan kerja sama dari Bapak/Ibu untuk dapat memberikan bimbingan dan pengawasan yang lebih intensif kepada putra/putri Bapak/Ibu demi kemajuan prestasi dan perbaikan perilaku di masa mendatang.
        </p>

        <p>
            Demikian surat pemberitahuan ini kami sampaikan. Atas perhatian dan kerja sama Bapak/Ibu, kami ucapkan terima kasih.
        </p>
    </div>

    {{-- <table class="signature-section">
        <tr>
            <td class="signature-box">
                Mengetahui,<br>
                Kepala Sekolah
                <div class="signature-space"></div>
                <div class="signature-name">(...........................................)</div>
                NIP. ...................................
            </td>
            <td class="signature-box">
                Banjaran, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                Guru BK / Wali Kelas
                <div class="signature-space"></div>
                <div class="signature-name">(...........................................)</div>
                NIP. ...................................
            </td>
        </tr>
    </table> --}}

</body>
</html>