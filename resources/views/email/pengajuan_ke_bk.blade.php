<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pengajuan Pelanggaran Siswa</title>
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
      background-color: #eaf0f9;
      border-left: 6px solid #2a5298;
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

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      font-size: 15px;
    }

    table thead {
      background-color: #2980b9;
      color: #ffffff;
    }

    table th, table td {
      padding: 12px 15px;
      border: 1px solid #dfe6ec;
      text-align: left;
    }

    table tbody tr:nth-child(even) {
      background-color: #f2f9ff;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="header">
      <h1>Pengajuan Tindakan Pelanggaran Siswa</h1>
    </div>
    <div class="body">
      <p>Yth. <strong>Bapak/Ibu Guru BK,</strong></p>

      <p>Telah diajukan laporan pelanggaran oleh siswa melalui pihak Kesiswaan untuk ditindaklanjuti. Berikut detail pengajuan:</p>

      <div class="info-box">
        <ul>
          <li><strong>Nama Siswa:</strong> {{$data->student?->name}}</li>
          <li><strong>Kelas:</strong> {{$data->student?->classRoom?->code}}</li>
          <li><strong>Total Poin Pelanggaran:</strong> {{ $data->total_point }} poin</li>
          <li><strong>Kode Laporan:</strong> {{ $data->code }}</li>
          <li><strong>Tgl Laporan:</strong> {{ $data->report_date }}</li>
        </ul>
      </div>

        <div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggaran</th>
                    <th>Tanggal Kejadian</th>
                    <th>Point</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody id="tbody-pelanggaran">
               @foreach ($data->sanctionDecisionDetail as $detail)
                   <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$detail->category?->name}}</td>
                        <td>{{$detail->incident_date}}</td>
                        <td>{{$detail->category?->point}}</td>
                        <td>{{$detail->comment}}</td>
                   </tr>
               @endforeach
            </tbody>
        </table>
      </div>

      <p>Mohon untuk dilakukan verifikasi dan tindak lanjut sesuai prosedur Bimbingan Konseling.</p>

      <p style="margin-top: 25px;">
        <a href="{{ route('penentuan-sanksi.index') }}" class="btn">Lihat Pengajuan</a>
      </p>

      <p style="margin-top: 30px;">Terima kasih atas kerja sama dan perhatiannya.</p>

      <p>Salam hormat,<br><strong>Tim Kesiswaan<br>SMAN 1 Banjaran</strong></p>
    </div>
    <div class="footer">
      Email ini dikirim otomatis oleh sistem pelaporan pelanggaran siswa. Mohon tidak membalas email ini.
    </div>
  </div>

</body>
</html>
