<?php
session_start();

// koneksi ke DBMS
require 'functions.php';

// ambil data di URL
$id = $_GET["id"];

// query data siswa berdasarkan id
$student = query("SELECT * FROM siswa WHERE id = $id")[0];

// cek tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {

   // cek data berhasil diubah atau gagal
   if (ubah($_POST) > 0) {
      echo "<script>
         alert ('data berhasil diedit!');
         document.location.href = 'index.php';
      </script>";
   } else {
      echo "<script>
         alert ('data gagal diedit!');
         document.location.href = 'index.php';
      </script>";
   }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Edit Data</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>

   <h1 class="text-dark m-4 text-xl-center ">Edit Data Siswa</h1>

   <div class="main w-50 mx-auto rounded-2 shadow p-5 m-3 ">
      <form action="" method="post" enctype="multipart/form-data">
         <input type="hidden" name="id" id="" value="<?= $student["id"]; ?>">
         <input type="hidden" name="gambarLama" id="" value="<?= $student["gambar"]; ?>">
         <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Nomor Induk Siswa</label>
            <input type="text" class="form-control" name="nis" id="exampleInputEmail1" aria-describedby="emailHelp" required value="<?= $student["nis"]; ?>">
         </div>
         <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Nama</label>
            <input type="text" class="form-control" name="nama" id="exampleInputEmail1" aria-describedby="emailHelp" required value="<?= $student["nama"]; ?>">
         </div>
         <div class=" mb-3">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" required value="<?= $student["email"]; ?>">
         </div>
         <div class=" mb-3">
            <label for="exampleInputEmail1" class="form-label">Jurusan</label>
            <input type="text" class="form-control" name="jurusan" id="exampleInputEmail1" aria-describedby="emailHelp" required value="<?= $student["jurusan"]; ?>">
         </div>
         <div class="mb-3 d-flex flex-column ">
            <label for="exampleInputEmail1" class="form-label">Gambar</label>
            <img class="mx-auto m-3 rounded-2 w-100" src="img/<?= $student["gambar"] ?>" alt="">
            <input type="file" class="form-control" name="gambar" id="exampleInputEmail1" aria-describedby="emailHelp">
         </div>

         <button type=" submit" name="submit" class="btn btn-primary w-25 mx-auto">Edit</button>
      </form>
   </div>
   <!-- Script -->
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>