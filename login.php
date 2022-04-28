<?php
//menyertakan file program koneksi.php pada register
require('connect.php');
//inisialisasi session
session_start();
 
$error = '';
$validate = '';
 
//mengecek apakah sesssion username tersedia atau tidak jika tersedia maka akan diredirect ke halaman index
if( isset($_SESSION['username']) ) header('Location: index.php');
 
//mengecek apakah form disubmit atau tidak
if( isset($_POST['submit']) ){
         
        // menghilangkan backshlases
        $username = stripslashes($_POST['username']);
        //cara sederhana mengamankan dari sql injection
        $username = mysqli_real_escape_string($koneksi, $username);
         // menghilangkan backshlases
        $password = stripslashes($_POST['password']);
         //cara sederhana mengamankan dari sql injection
        $password = mysqli_real_escape_string($koneksi, $password);
        
        //cek apakah nilai yang diinputkan pada form ada yang kosong atau tidak
        if(!empty(trim($username)) && !empty(trim($password))){
 
            //select data berdasarkan username dari database
            $query      = "SELECT * FROM pembeli WHERE username = '$username'";
            $result     = mysqli_query($koneksi, $query);
            $rows       = mysqli_num_rows($result);
 
            if ($rows != 0) {
                $hash   = mysqli_fetch_assoc($result)['password'];
                if(password_verify($password, $hash)){
                    $_SESSION['username'] = $username;
                
                    header('Location: index.php');
                }
                             
            //jika gagal maka akan menampilkan pesan error
            } else {
                $error =  'Register User Gagal !!';
            }
             
        }else {
            $error =  'Data tidak boleh kosong !!';
        }
    } 
 
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="icon" href="assets/images/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Comforter&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Comforter&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Permanent+Marker&display=swap" rel="stylesheet">
    <title>Login</title>
    <style>
            body{
                background-color:#F8F8FF;
            }
            .container{
                margin:auto;
                width : 600px
            }
            .container h1{
                font-family: 'Permanent Marker', cursive;
                font-size:bold;
                margin-top:200px; 
            }
            .container label, p{
                font-family:bebas neue;
            }
            .container a{
                text-decoration : none;
            }
            .card{
                background-color:#F0E68C;
                width:500px;
                margin:auto;
                padding:10px;
            }
            .card h2{
                font-family:bebas neue;
                border-bottom: 2px solid lime; 
            }

            
    </style>
  </head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Card -->

    <!-- End Card -->
    <div class="container">
        <h1 class="text-center fw-bold">Booku.com</h1>
        <div class="card mt-4">
            <h2 class="text-center">Login</h2>
        <form action="" method="POST" >

            <div class="form-group">
                <label for="username" class="fs-3">Username</label>
                <input class="form-control mb-3" type="text" name="username" placeholder="Username" />
            </div>


            <div class="form-group">
                <label for="password" class="fs-3">Password</label>
                <input class="form-control mb-5" type="password" name="password" placeholder="Password" />
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <input type="submit" class="btn btn-success btn-block text-center" name="submit" value="Masuk" />
            </div>
                <p class="text-center mt-2">Belum memiliki akun?<a href="registrasi.php"> Daftar di sini</a></P>
        </form>
        </div>
    </div>
  </body>
</html>