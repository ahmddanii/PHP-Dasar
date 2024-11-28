<?php

require_once __DIR__ . './mpdf_v8.0.3-master/vendor/autoload.php';

require 'functions.php';
$siswa = query("SELECT * FROM siswa");


$html = '<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Row</title>
</head>
<body>
<h1>Daftar Siswa</h1>
<table border="1" cellpadding="10" cellspacing="0">
<tr>
   <th>No.</th>
   <th>Gambar</th>
   <th>NIS</th>
   <th>Nama</th>
   <th>Email</th>
   <th>Jurusan</th>
</tr>';

$i = 1;
foreach ($siswa as $row) {
   $html .= '<tr>
   <td>' . $i++ . '</td>
   <td><img src="img/' . $row["gambar"] . '" width="50" ></td>
   <td>' . $row["nis"] . '</td>
   <td>' . $row["nama"] . '</td>
   <td>' . $row["email"] . '</td>
   <td>' . $row["jurusan"] . '</td>
   </tr>';
}

$html .= '</table>
</body>
</html>';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output();
