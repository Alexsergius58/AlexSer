<?php 

session_start();
	if (!isset($_SESSION["login"])) {

		header("Location:login.php");
		exit;

	}

require 'functions.php';
		if(isset($_POST["submit"])){ // Mengecek apakah tombol submit sudah di tekan apa belum
				


				if(tambah($_POST)>0) {
					echo "
						<script>
							alert('Data berhasil ditambahkan!');
							window.location.href = 'index.php';
						</script>
					";	
					
				}
				else {
					echo "<script>
							alert('Data berhasil ditambahkan!');
							windows.location.href = 'index.php';
						</script>
						";
				}
			

			

		}

 ?>



<!DOCTYPE html>
<html>
<head>
	<title>Tambah Mahasiswa</title>
</head>
<body>
	<h1>MASUKKAN DATA MAHASISWA</h1>
	<form action="" method="post" enctype="multipart/form-data">

		<ul>
			<li>
				<label for="nama">Nama</label>
				<input type="text" name="nama" id="nama">
			</li>
			<li>
				<label for="nim">NIM</label>
				<input type="text" name="nim" id="nim">
			</li>
			<li>
				<label for="jurusan">Jurusan</label>
				<input type="text" name="jurusan" id="jurusan">
			</li>
			<li>
				<label for="gambar">Gambar</label>
				<input type="file" name="gambar" id="gambar">
			</li>
			<li>
				<button type="submit" name="submit">Masukan Data</button>
			</li>
		</ul>
		
	</form>

</body>
</html>