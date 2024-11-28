<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");

function query($query)
{
   global $conn;
   $result = mysqli_query($conn, $query);
   $rows = [];
   while ($row = mysqli_fetch_assoc($result)) {
      $rows[] = $row;
   }
   return $rows;
}


function tambah($data)
{
   global $conn;
   // ambil data dari tiap elemen dalam form
   $nis = htmlspecialchars($data["nis"]);
   $nama = htmlspecialchars($data["nama"]);
   $email = htmlspecialchars($data["email"]);
   $jurusan = htmlspecialchars($data["jurusan"]);

   // upload gambar
   $gambar = upload();
   if (!$gambar) {
      return false;
   }

   // query insert data
   $query = "INSERT INTO siswa
      VALUES
      ('','$nama', '$nis', '$email', '$jurusan', '$gambar')
   ";
   mysqli_query($conn, $query);

   return mysqli_affected_rows($conn);
}

function upload()
{

   $namaFile = $_FILES['gambar']['name'];
   $ukuranFile = $_FILES['gambar']['size'];
   $error = $_FILES['gambar']['error'];
   $tmpName = $_FILES['gambar']['tmp_name'];

   // cek apakah tidak ada gambar yang diupload
   if ($error === 4) {
      echo "
      <script>
      alert('File Gambar Tidak Boleh Kosong!')</script>
      ";
      return false;
   }

   // cek apakah yg diup adalah gambar
   $ekstensiGambarValid = ['jpeg', 'jpg', 'jfif', 'png'];
   $ekstensiGambar = explode('.', $namaFile);
   $ekstensiGambar = strtolower(end($ekstensiGambar));
   if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
      echo "
      <script>
      alert('Upload Ekstensi Gambar!')</script>
      ";
      return false;
   }

   // cek jika ukurannya terlalu besar
   if ($ukuranFile > 1000000) {
      echo "
      <script>
      alert('Ukuran File Terlalu Besar!')</script>
      ";
      return false;
   }

   // lolos pengecekan, gambar siap upload
   // generate nama gambar baru
   $namaFileBaru = uniqid();
   $namaFileBaru .= '.';
   $namaFileBaru .= $ekstensiGambar;

   move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

   return $namaFileBaru;
}

function hapus($id)
{
   global $conn;
   mysqli_query($conn, "DELETE FROM siswa WHERE id = $id");

   return mysqli_affected_rows($conn);
}


function ubah($data)
{
   global $conn;
   // ambil data dari tiap elemen dalam form
   $id = $data["id"];
   $nis = htmlspecialchars($data["nis"]);
   $nama = htmlspecialchars($data["nama"]);
   $email = htmlspecialchars($data["email"]);
   $jurusan = htmlspecialchars($data["jurusan"]);
   $gambarLama = htmlspecialchars($data["gambarLama"]);

   // cek apakah user pilih gambar baru atau tidak
   if ($_FILES['gambar']['error'] === 4) {
      $gambar = $gambarLama;
   } else {
      $gambar = upload();
   }

   // query insert data
   $query = "UPDATE siswa SET
      nis = '$nis',
      nama = '$nama',
      email = '$email',
      jurusan = '$jurusan',
      gambar = '$gambar'
      WHERE id = $id
   ";
   mysqli_query($conn, $query);

   return mysqli_affected_rows($conn);
}


function cari($keyword)
{
   $query = "SELECT * FROM siswa
      WHERE
      nama LIKE '%$keyword%' OR
      nis LIKE '%$keyword%' OR
      email LIKE '%$keyword%' OR
      jurusan LIKE '%$keyword%'
   ";
   return query($query);
}

function registrasi($data)
{
   global $conn;

   $username = strtolower(stripslashes($data["username"]));
   $password = mysqli_real_escape_string($conn, $data["password"]);
   $password2 = mysqli_real_escape_string($conn, $data["password2"]);

   // cek apakah user sudah terdaftar atau belum
   $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");

   if (mysqli_fetch_assoc($result)) {
      echo "
      <script>
      alert('User Sudah Terdaftar, Silahkan Login!');
      </script>
      ";

      return false;
   }
   // konfirmasi password
   if ($password !== $password2) {
      echo "<script>
      alert('Password Tidak Sama');
      </script>";

      return false;
   }

   // enkripsi password
   $password = password_hash($password, PASSWORD_DEFAULT);

   // tambahkan user ke database
   mysqli_query($conn, "INSERT INTO users VALUES('', '$username', '$password')");
}
