<?php
session_start();
require 'functions.php';

if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
   $id = $_COOKIE['id'];
   $key = $_COOKIE['key'];

   // ambil username sesuai id
   $result = mysqli_query($conn, "SELECT username FROM users WHERE id= $id");
   $row = mysqli_fetch_assoc($result);

   // cek cookie dan username
   if ($key === hash('sha256', $row['username'])) {
      $_SESSION['login'] = true;
   }
}


if (isset($_SESSION["login"])) {
   header("Location: index.php");
   exit;
}



if (isset($_POST["login"])) {
   $username = $_POST["username"];
   $password = $_POST["password"];

   $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

   // cek username 
   if (mysqli_num_rows($result) === 1) {
      // cek password
      $row = mysqli_fetch_assoc($result);
      if (password_verify($password, $row["password"])) {
         // set session
         $_SESSION["login"] = true;

         // cek remember me
         if (isset($_POST['remember'])) {
            // buat cookie
            setcookie('id', $row['id'], time() + 60);
            setcookie('key', hash('sha256', $row['username']), time() + 60);
         }

         header("Location: index.php");
         exit;
      }
   }

   $error = true;
}

?>
<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Login</title>
   <!-- Style -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
   <style>
      .container-reg {
         min-width: 400px;
         max-width: 450px;
      }
   </style>
</head>

<body>
   <div class="main mx-auto shadow-lg p-5 rounded-3 m-5 container-reg">
      <h1 class="text-center">Login</h1>

      <?php if (isset($error)) : ?>
         <p class="text-danger fst-italic">Username / Password Salah</p>
      <?php endif; ?>

      <form action="" method="post">
         <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" id="username">
         </div>
         <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password">
         </div>
         <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">Remember Me</label>
         </div>
         <button type="submit" name="login" class="btn btn-primary w-full">Login</button>
      </form>
   </div>
   <!-- Script -->
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>