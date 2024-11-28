<?php
session_start();

// Koneksi ke DBMS
require 'functions.php';

// Cek tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {

   // Cek data berhasil ditambahkan atau gagal
   if (tambah($_POST) > 0) {
      // SweetAlert untuk berhasil
      $message = "<script>
         document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
               title: 'Success!',
               text: 'Data berhasil ditambahkan!',
               icon: 'success',
               confirmButtonText: 'OK'
            }).then((result) => {
               if (result.isConfirmed) {
                  window.location.href = 'index.php';
               }
            });
         });
      </script>";
   } else {
      // SweetAlert untuk gagal
      $message = "<script>
         document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
               title: 'Error!',
               text: 'Data gagal ditambahkan!',
               icon: 'error',
               confirmButtonText: 'OK'
            }).then((result) => {
               if (result.isConfirmed) {
                  window.location.href = 'index.php';
               }
            });
         });
      </script>";
   }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Add Students</title>
   <!-- Link Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- Link SweetAlert2 -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

   <h1 class="text-dark m-4 text-xl-center">Tambah Siswa</h1>

   <div class="main w-50 mx-auto rounded-2 shadow p-5 m-3">
      <form action="" method="post" enctype="multipart/form-data">
         <div class="mb-3">
            <label for="nis" class="form-label">Nomor Induk Siswa</label>
            <input type="text" class="form-control" name="nis" id="nis" required>
         </div>
         <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" name="nama" id="nama" required>
         </div>
         <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" name="email" id="email" required>
         </div>
         <div class="mb-3">
            <label for="jurusan" class="form-label">Jurusan</label>
            <input type="text" class="form-control" name="jurusan" id="jurusan" required>
         </div>
         <div class="mb-3">
            <label for="gambar" class="form-label">Gambar</label>
            <input type="file" class="form-control" name="gambar" id="gambar">
         </div>

         <button type="submit" name="submit" class="btn btn-primary w-25 mx-auto">Submit</button>
      </form>
   </div>

   <!-- Script untuk SweetAlert -->
   <?php if (isset($message)) echo $message; ?>

   <!-- Link Bootstrap JS -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>