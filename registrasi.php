<?php
//menyertakan file program koneksi.php pada register
require('connect.php');
//inisialisasi session
session_start();
 
$error = '';
$validate = '';
//mengecek apakah form registrasi di submit atau tidak
if( isset($_POST['submit']) ){
        // menghilangkan backshlases
        $username = stripslashes($_POST['username']);
        //cara sederhana mengamankan dari sql injection
        $username = mysqli_real_escape_string($koneksi, $username);
        $name     = stripslashes($_POST['name']);
        $name     = mysqli_real_escape_string($koneksi, $name);
        $email    = stripslashes($_POST['email']);
        $email    = mysqli_real_escape_string($koneksi, $email);
        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($koneksi, $password);
        $repass   = stripslashes($_POST['repassword']);
        $repass   = mysqli_real_escape_string($koneksi, $repass);
        //cek apakah nilai yang diinputkan pada form ada yang kosong atau tidak
        if(!empty(trim($name)) && !empty(trim($username)) && !empty(trim($email)) && !empty(trim($password)) && !empty(trim($repass))){
            //mengecek apakah password yang diinputkan sama dengan re-password yang diinputkan kembali
            if($password == $repass){
                //memanggil method cek_nama untuk mengecek apakah user sudah terdaftar atau belum
                if( cek_nama($name,$koneksi) == 0 ){
                    //hashing password sebelum disimpan didatabase
                    $pass  = password_hash($password, PASSWORD_DEFAULT);
                    //insert data ke database
                    $query = "INSERT INTO pembeli (username,nama_pembeli,email_pembeli, password ) VALUES ('$username','$nama','$email','$pass')";
                    $result   = mysqli_query($koneksi, $query);
                    //jika insert data berhasil maka akan diredirect ke halaman index.php serta menyimpan data username ke session
                    if ($result) {
                        $_SESSION['username'] = $username;
                        
                        header('Location: login.php');
                     
                    //jika gagal maka akan menampilkan pesan error
                    } else {
                        $error =  'Register User Gagal !!';
                    }
                }else{
                        $error =  'Username sudah terdaftar !!';
                }
            }else{
                $validate = 'Password tidak sama !!';
            }
             
        }else {
            $error =  'Data tidak boleh kosong !!';
        }
    } 
    //fungsi untuk mengecek username apakah sudah terdaftar atau belum
    function cek_nama($username,$koneksi){
        $nama = mysqli_real_escape_string($koneksi, $username);
        $query = "SELECT * FROM users WHERE username = '$nama'";
        if( $result = mysqli_query($koneksi, $query) ) return mysqli_num_rows($result);
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
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Comforter&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Comforter&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Permanent+Marker&display=swap" rel="stylesheet">

    <title>Registrasi</title>
    <style>
            body{
                background-color:#F8F8FF;
            }
            .container{
                margin:auto;
                width : 600px;
                margin-bottom:300px;
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

            
    </style>
  </head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <div class="container">
        <h1 class="text-center fw-bold">REGISTRASI</h1>
        <div class="card">
        <form action="" method="POST" class="">

            <div class="form-group mb-2">
                <label for="name">Nama Lengkap</label>
                <input class="form-control" type="text" name="name" placeholder="Nama kamu" required/>
            </div>

            <div class="form-group mb-2">
                <label for="email">Email</label>
                <input class="form-control" type="email" name="email" placeholder="Alamat Email" required/>
            </div>

            <div class="form-group mb-2">
                <label for="username">Username</label>
                <input class="form-control" type="text" name="username" placeholder="Username" required/>
            </div>

            <div class="form-group mb-2">
                <label for="password">Password</label>
                <input class="form-control" type="password" name="password" placeholder="Password" required/>
            </div>

            <div class="form-group mb-2">
                <label for="password">Konfirmasi Password</label>
                <input class="form-control" type="password" name="repassword" placeholder="Konfirmasi Password" required/>
            </div>

            <input type="submit" class="btn btn-success btn-block" name="submit" value="Daftar" />
            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>

        </form>
        </div>
    </div>

  </body>
</html>



