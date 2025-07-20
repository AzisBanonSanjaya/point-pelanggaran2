<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Penolakan Poin Pelanggaran</title>
  <style>
    body {
      background-color: #eef2f7;
      margin: 0;
      padding: 30px 10px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #2c3e50;
    }

    .container {
      max-width: 650px;
      margin: auto;
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      overflow: hidden;
    }

    .header {
      background: linear-gradient(to right, #1e3c72, #2a5298);
      color: white;
      padding: 30px;
      text-align: center;
    }

    .header h1 {
      margin: 0;
      font-size: 22px;
    }

    .body {
      padding: 30px;
    }

    .body p {
      line-height: 1.7;
      margin: 0 0 15px;
      font-size: 16px;
    }

    .info-box {
      background-color: #f0f5fc;
      border-left: 6px solid #3498db;
      padding: 15px 20px;
      margin: 20px 0;
      border-radius: 8px;
    }

    .info-box ul {
      margin: 0;
      padding-left: 20px;
    }

    .info-box li {
      margin-bottom: 8px;
    }

    .note-box {
      background-color: #fff4f4;
      border-left: 6px solid #e74c3c;
      padding: 15px 20px;
      border-radius: 8px;
      margin-top: 20px;
    }

    .btn {
      display: inline-block;
      background-color: #2a5298;
      color: #ffffff;
      text-decoration: none;
      padding: 12px 24px;
      border-radius: 8px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .btn:hover {
      background-color: #1e3c72;
    }

    .footer {
      background-color: #f4f6fa;
      text-align: center;
      padding: 20px;
      font-size: 13px;
      color: #7f8c8d;
    }

    @media (max-width: 600px) {
      .body, .header, .footer {
        padding: 20px;
      }

      .btn {
        width: 100%;
        text-align: center;
        box-sizing: border-box;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="header">
      <h1>Penolakan Poin Pelanggaran oleh Guru BK</h1>
    </div>
    <div class="body">
      <p>Yth. <strong>Bapak/Ibu Guru BK,</strong></p>

      <p>Berikut ini kami informasikan bahwa poin pelanggaran yang diajukan oleh pihak Kesiswaan telah ditolak oleh Bapak/Ibu Guru BK. Berikut adalah detail pengajuannya:</p>

      <div class="info-box">
        <ul>
          <li><strong>Nama Siswa:</strong> {{$data->student?->name}}</li>
          <li><strong>Kelas:</strong> {{$data->student?->classRoom?->code}}</li>
          <li><strong>Total Poin Pelanggaran:</strong> {{ $data->total_point }} poin</li>
          <li><strong>Kode Laporan:</strong> {{ $data->code }}</li>
          <li><strong>Tgl Laporan:</strong> {{ $data->report_date }}</li>
        </ul>
      </div>

      <div class="note-box">
        <strong>Alasan Penolakan:</strong>
        <p>
         {{ $data->reason_reject }}
        </p>
      </div>

      <p>Silakan lakukan pembaruan pada data pelanggaran jika diperlukan. Terima kasih atas perhatian dan kerja samanya.</p>

      <p style="margin-top: 25px;">
         <a href="{{ route('penentuan-sanksi.index') }}" class="btn">Lihat Pengajuan</a>
      </p>

      <p style="margin-top: 30px;">Salam hormat,<br><strong>Tim Kesiswaan<br>SMAN 1 Banjaran</strong></p>
    </div>
    <div class="footer">
      Email ini dikirim otomatis oleh sistem pelaporan pelanggaran siswa. Mohon tidak membalas email ini.
    </div>
  </div>

</body>
</html>
