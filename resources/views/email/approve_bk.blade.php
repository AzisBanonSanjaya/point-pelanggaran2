<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Notifikasi Pelanggaran</title>
  <style>
    body {
      background-color: #eef3f9;
      margin: 0;
      padding: 30px 10px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #333;
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
      background: linear-gradient(to right, #2980b9, #3498db);
      color: white;
      padding: 30px;
      text-align: center;
    }

    .header h1 {
      margin: 0;
      font-size: 24px;
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
      background-color: #eaf4fb;
      border-left: 6px solid #3498db;
      padding: 15px 20px;
      margin-bottom: 20px;
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
      background-color: #2980b9;
      color: #ffffff;
      text-decoration: none;
      padding: 12px 24px;
      border-radius: 8px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .btn:hover {
      background-color: #2471a3;
    }

    .footer {
      background-color: #f4f8fb;
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
      <h1>Notifikasi Pelanggaran Siswa</h1>
    </div>
    <div class="body">
      <p>Yth. <strong> {{$data->student?->name}}</strong>,</p>

      <p>Kami informasikan bahwa Anda telah tercatat melakukan pelanggaran di lingkungan sekolah. Berikut detail pelanggaran tersebut:</p>

      <div class="info-box">
        <ul>
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

      <p>Segera lakukan klarifikasi atau konfirmasi ke ruang BK untuk penanganan lebih lanjut. Klik tombol di bawah ini untuk melihat detail lengkap pelanggaran Anda.</p>

      <p style="margin-top: 25px;">
        <a href="{{ route('penentuan-sanksi.index') }}" class="btn">Lihat Pengajuan</a>
      </p>

      <p style="margin-top: 30px;">Terima kasih atas perhatian dan kerja samanya.</p>

      <p>Salam hormat,<br><strong>Guru BK SMAN 1 Banjaran</strong></p>
    </div>
    <div class="footer">
      Email ini dikirim secara otomatis oleh sistem. Mohon tidak membalas email ini.
    </div>
  </div>

</body>
</html>
