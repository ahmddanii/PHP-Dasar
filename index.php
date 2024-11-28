<?php
session_start();

require 'functions.php';
$siswa = query("SELECT * FROM siswa");

if (isset($_POST["search"])) {
   $siswa = cari($_POST["keyword"]);
}
?>

<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Daftar Siswa</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <style>
      .lds-dual-ring {
         display: none;
         width: 40px;
         height: 40px;
         justify-content: center;
      }

      .lds-dual-ring:after {
         content: " ";
         display: block;
         width: 30px;
         height: 30px;
         border-radius: 50%;
         border: 2px solid rgba(0, 0, 0, .75);
         border-color: rgba(0, 0, 0, .75) transparent rgba(0, 0, 0, .75) transparent;
         animation: lds-dual-ring 1.2s linear infinite;
      }

      @keyframes lds-dual-ring {
         0% {
            transform: rotate(0deg);
         }

         100% {
            transform: rotate(360deg);
         }
      }
   </style>
</head>

<body>
   <h1 class="text-body text-center mt-5 m-3 ">Daftar Siswa</h1>

   <div class="main w-75 mx-auto ">
      <div class="head d-flex justify-content-between ">
         <div class="action">
            <a href="#" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#addModal">
               <i class="bi bi-plus-square"></i> Add Students</a>
            <a href="print.php" class="btn btn-dark mb-2" target="_blank"><i class="bi bi-printer"></i> Print</a>
         </div>
         <form action="" method="post">
            <div class="row g-3 align-items-center justify-content-end ">
               <div class="col-auto d-flex flex-row mb-2 ">
                  <input type="text" placeholder="Cari Data Siswa" id="keyword" name="keyword" class="form-control mx-2" autocomplete="off" autofocus>
                  <button type="submit" id="search" name="search" class="btn btn-primary">Search</button>
                  <div class="lds-dual-ring"></div>
               </div>
            </div>
         </form>
      </div>
      <div id="container">
         <table border="2" class="table table-secondary rounded-2 ">
            <tr>
               <th>No.</th>
               <th>Aksi</th>
               <th>Gambar</th>
               <th>NIS</th>
               <th>Nama</th>
               <th>Email</th>
               <th>Jurusan</th>
            </tr>
            <?php $i = "1"; ?>
            <?php foreach ($siswa as $row) : ?>
               <tr class="table-light">
                  <td><?= $i; ?></td>
                  <td>
                     <button class="btn btn-primary btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?= $row['id']; ?>" data-nis="<?= $row['nis']; ?>" data-nama="<?= $row['nama']; ?>" data-email="<?= $row['email']; ?>" data-jurusan="<?= $row['jurusan']; ?>" data-gambar="<?= $row['gambar']; ?>"><i class="bi bi-pencil"></i> Edit</button>
                     <span>|</span>
                     <a href="#" class="btn btn-danger btn-sm btn-delete" data-id="<?= $row['id']; ?>" data-name="<?= $row['nama']; ?>"><i class="bi bi-trash"></i> Delete</a>
                  </td>
                  <td><img src="img/<?= $row['gambar']; ?>" alt="" width="50"></td>
                  <td><?= $row['nis']; ?></td>
                  <td><?= $row['nama']; ?></td>
                  <td><?= $row['email']; ?></td>
                  <td><?= $row['jurusan']; ?></td>
               </tr>
               <?php $i++; ?>
            <?php endforeach; ?>
         </table>
      </div>
      <div class="footer d-flex justify-content-between">
         <a href="logout.php" class="btn btn-danger mb-2"><i class="bi bi-box-arrow-left"></i> Logout</a>
      </div>
   </div>

   <!-- Modal for Add Students -->
   <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <!-- Add modal content here -->
         </div>
      </div>
   </div>

   <!-- Modal for Edit Students -->
   <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <!-- Edit modal content here -->
         </div>
      </div>
   </div>

   <!-- Script -->
   <script src="js/jquery-3.7.0.min.js"></script>
   <script src="js/script.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
   <script>
      // SweetAlert for Delete Confirmation
      document.addEventListener('DOMContentLoaded', function() {
         const deleteButtons = document.querySelectorAll('.btn-delete');
         deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
               e.preventDefault();
               const studentId = this.getAttribute('data-id');
               const studentName = this.getAttribute('data-name');
               Swal.fire({
                  title: 'Are you sure?',
                  text: `You are about to delete "${studentName}"!`,
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: 'Yes, delete it!'
               }).then((result) => {
                  if (result.isConfirmed) {
                     window.location.href = `hapus.php?id=${studentId}`;
                  }
               });
            });
         });
      });
   </script>
</body>

</html>