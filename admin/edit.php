<?php

require "../koneksi.php";
  session_start()  ;

if ($_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
  }
  
  if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../index.php');
    exit();
  } 

  $id = $_GET['id'];

  $query = "SELECT * FROM produk WHERE id_produk = '$id'";
  $result = mysqli_query($koneksi, $query);
  
  if(!isset($_GET["id"])){
      header ("Location: produk.php");
      exit;
  }else if(mysqli_num_rows($result ) ==  1 ){
    //   header ("Location: produk.php");
  }else {
      header ("Location: produk.php");
      exit;
  }
  function ubah($data){
      global $koneksi;
      
      $id = $_POST["id"];
      $nama_produk = $_POST["nama_produk"];
      $harga = $_POST["harga"];
      $gambar = $_POST["gambar"];
      
      $data = mysqli_query ($koneksi, "SELECT * FROM produk WHERE id_produk = '$_GET[id]' ") ;
      $result = mysqli_fetch_array($data) ;
  
      $gambarn = $result['gambar'] ;
      if(file_exists('../file/'.$gambarn))
      {
          unlink('../file/'.$gambarn) ;
      }
      $gambarn = $_FILES['gambar']['name'];
      $file_tmp = $_FILES['gambar']['tmp_name'] ;
      move_uploaded_file($file_tmp, '../file/'.$gambarn) ;
      
      $query ="UPDATE produk SET
                  nama_produk = '$nama_produk',
                  harga ='$harga',
                  gambar = '$gambar'
                  WHERE id_produk = '$id' ";
      $result = mysqli_query($koneksi, $query);
      return mysqli_affected_rows($koneksi);          
  }
  
  ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">        
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Produk</title>
        <link rel="icon" href="../asset/gambar/Ud Haderah.png">
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link href="style-login.css" rel="stylesheet" />

    </head>
    <style>
        .navbar {
            background-color: burlywood;
            padding: 0.600rem 1.25rem;
        }
        .sidebar-heading {
            background-color: burlywood;
        }
        .sidebar-wrapper
        {
            background-color: black;
        }
    </style>
    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div id="sidebar-wrapper">
                <div class="sidebar-heading">Admin</div>
                <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
                    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <img src="../asset/gambar/Ud Haderah.png" class="bi me-2" width="250" height="50">
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                      <li>
                      <a href="index.php" class="nav-link text-white">
                          <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                          Beranda
                        </a>
                      </li> 
                      <li>
                        <a href="produk.php" class="nav-link text-white">
                          <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"/></svg>
                          Produk
                        </a>
                      </li>
                      <li>                        
                        <a href="Pembelian.php" class="nav-link text-white">
                          <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"/></svg>
                          Pembelian
                        </a>
                        <a href="supir.php" class="nav-link text-white">
                          <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"/></svg>
                          Supir
                        </a>
                        <a href="mobil.php" class="nav-link text-white">
                          <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"/></svg>
                          Mobil
                        </a>
                        <a href="?logout=true" class="nav-link text-white">
                          <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"/></svg>
                          Logout
                        </a>
                        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                <!-- Top navigation-->
                <nav class="navbar navbar-expand-lg navbar-light border-bottom">
                    <div class="container-fluid">
                       
                       
                        <svg id="sidebarToggle" xmlns="http://www.w3.org/2000/svg" width="16" height="39" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                          </svg>
                    </div>
                </nav>
                <!-- Page content-->
                <div class="container-fluid">
                <div class="Isi">
                  <h1>Form Input</h1>
                  <form enctype="multipart/form-data" method="POST"> 
                    <input type="hidden" name="id" value="<?php echo $row['id_produk']?>">    
                    <span class="sub">nama</span>
                    <input type="text" placeholder="Masukkan Nama" name="nama_produk">
                    <span class="sub">harga</span>
                    <input type="number" placeholder="Masukkan Harga" min="1" name="harga">
                    <span class="sub">gambar</span>  
                    <input type="file" name="gambar">
                    <br>  
                    <input type="submit" name="update" cursorshover="true">
                  </form>
              <hr>
                <h1 class="text-center">                  
                Tabel Produk                
                </h1>
                <br>
                <table id="tabel" class="table table-hover" border="2" cellspacing="0" width="100%">

                    <tr>
                      <th rowspan="1" bgcolor="yellowgreen">No_Produk</th>
                      <th rowspan="1" bgcolor="yellow">Nama</th>
                      <th rowspan="1" bgcolor="yellowgreen">Harga</th>
                      <th rowspan="1" bgcolor="yellowgreen">Gambar</th>
                      <th colspan="1" bgcolor="yellow">Aksi</th>
                    </tr> 
                    
                    <form method="post">

                      <?php 
            include "../koneksi.php" ;
            $query = "SELECT * FROM produk;";
            
            $data = mysqli_query($koneksi,$query) ;
            while ($row = mysqli_fetch_array($data)) {
            $harga = $row['harga'];
            ?>     
                    <tr>
                      <td><?php echo $row['id_produk'] ; ?></td>
                      <td><?php echo $row['nama_produk'] ; ?></td>
                      <td><?php echo number_format($harga, 0, ',', '.'); ?></td>
                      <td><?php echo $row['gambar'] ; ?></td>
                      <td><a href="../produk.php"><button>Tambah</button></a></td>
                    </tr>

             <?php }?>       
            </form>
                </table>
                </div>
                </div>
            </div>
        </div>
        <footer>
          <div class="foot">
              <img src="../asset/gambar/Ud Haderah.png" width="150px">
              <p> Hak Cipta © 2023 - Kelompok 3 C1</p>
          </div>
      </footer>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>

    </body>
</html>