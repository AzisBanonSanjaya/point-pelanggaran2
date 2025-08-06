<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pemberitahuan Pelanggaran Tata Tertib Siswa</title>
  <style>
    body {
      background-color: #f4f6fa;
      margin: 0;
      padding: 20px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #333;
    }

    .container {
      max-width: 680px;
      margin: auto;
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      border: 1px solid #e0e0e0;
    }

    .header {
      background: linear-gradient(135deg, #1e3c72, #2a5298);
      color: white;
      padding: 30px;
      text-align: center;
    }

    .header h1 {
      margin: 0;
      font-size: 24px;
      letter-spacing: 0.5px;
    }

    .body {
      padding: 35px 40px;
    }

    .body p {
      line-height: 1.7;
      margin: 0 0 18px;
      font-size: 16px;
    }

    .info-box {
      background-color: #f8f9fa;
      border-left: 5px solid #2a5298;
      padding: 20px;
      margin: 25px 0;
      border-radius: 8px;
    }

    .info-box h4 {
      margin-top: 0;
      margin-bottom: 15px;
      color: #1e3c72;
      font-size: 18px;
    }
    
    .info-box ul {
      margin: 0;
      padding-left: 20px;
      list-style-type: '✔  ';
    }

    .info-box li {
      margin-bottom: 10px;
      padding-left: 5px;
    }

    .btn {
      display: inline-block;
      background-color: #2a5298;
      color: #ffffff;
      text-decoration: none;
      padding: 14px 28px;
      border-radius: 8px;
      font-weight: bold;
      transition: background-color 0.3s ease, transform 0.2s ease;
      font-size: 16px;
    }

    .btn:hover {
      background-color: #1e3c72;
      transform: translateY(-2px);
    }
    
    .cta-container {
      text-align: center;
      margin: 30px 0;
    }

    .footer {
      background-color: #f4f6fa;
      text-align: center;
      padding: 25px;
      font-size: 13px;
      color: #7f8c8d;
      border-top: 1px solid #e0e0e0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 25px 0;
      font-size: 15px;
    }

    table h4 {
      margin-top: 0;
      margin-bottom: 15px;
      color: #1e3c72;
      font-size: 18px;
    }

    table thead {
      background-color: #2a5298;
      color: #ffffff;
    }

    table th, table td {
      padding: 12px 15px;
      border: 1px solid #dfe6ec;
      text-align: left;
    }

    table tbody tr:nth-child(even) {
      background-color: #f8f9fa;
    }
    
    .text-center {
        text-align: center;
    }
    
    .font-bold {
        font-weight: bold;
    }
  </style>
</head>
<body>

  <div class="container">
    
    <div class="header">
      <h1>Pemberitahuan Pelanggaran Tata Tertib</h1>
    </div>

    <div class="body">
      <p>Yth. <strong>Bapak/Ibu Orang Tua/Wali dari {{ $data->student?->name }}</strong>,</p>

      <p>Dengan hormat, melalui email ini kami dari pihak sekolah ingin memberitahukan bahwa putra/putri Anda, berdasarkan catatan kami, telah melakukan pelanggaran terhadap tata tertib sekolah.</p>

      <div class="info-box">
        <h4>RINGKASAN LAPORAN</h4>
        <ul>
          <li><strong>Nama Siswa:</strong> {{ $data->student?->name }}</li>
          <li><strong>Kelas:</strong> {{ $data->student?->classRoom?->code }}</li>
          <li><strong>Tanggal Laporan:</strong> {{ \Carbon\Carbon::parse($data->report_date)->translatedFormat('d F Y') }}</li>
          <li class="font-bold"><strong>Total Poin Saat Ini:</strong> {{ $data->total_point }} poin</li>
          <li><strong>Tindakan Sekolah:</strong> {{ $data->description ?: '-' }}</li>
        </ul>
      </div>

      <div>
          <h4>RINCIAN PELANGGARAN</h4>
          <table>
              <thead>
                  <tr>
                      <th class="text-center" style="width:5%;">No</th>
                      <th>Nama Pelanggaran</th>
                      <th style="width:25%;">Tanggal Kejadian</th>
                      <th class="text-center" style="width:10%;">Poin</th>
                  </tr>
              </thead>
              <tbody>
                 @foreach ($data->sanctionDecisionDetail as $detail)
                     <tr>
                          <td class="text-center">{{ $loop->iteration }}</td>
                          <td>{{ $detail->category?->name ?? 'N/A' }}</td>
                          <td>{{ \Carbon\Carbon::parse($detail->incident_date)->translatedFormat('d F Y') }}</td>
                          <td class="text-center">{{ $detail->category?->point ?? 0 }}</td>
                     </tr>
                 @endforeach
              </tbody>
          </table>
      </div>
      
      <p>Untuk informasi yang lebih detail dan sebagai arsip bagi Bapak/Ibu, silakan mengunduh surat pemberitahuan resmi melalui tautan di bawah ini.</p>
      
      <div class="cta-container">
        {{-- Pastikan variabel $reportUrl sudah dikirim ke view ini --}}
        <a href="{{ route('report.pelanggaran', $data->code) }}" class="btn">Unduh Surat Laporan Resmi (.pdf)</a>
      </div>

      <p>Kami sangat mengharapkan kerja sama dari Bapak/Ibu untuk turut serta memberikan bimbingan dan pengawasan demi kebaikan dan kemajuan perilaku putra/putri kita bersama.</p>

      <p>Terima kasih atas perhatian dan kerja samanya.</p>

      <p>Hormat kami,<br><strong>Tim Kesiswaan<br>SMAN 1 Banjaran</strong></p>
    </div>

    <div class="footer">
      Email ini dikirim secara otomatis oleh Sistem Informasi Kesiswaan SMAN 1 Banjaran. Mohon untuk tidak membalas email ini.
    </div>
  </div>

</body>
</html>