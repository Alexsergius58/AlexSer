<?php 
require 'functions.php';

//Menangkap id yang dikirim dari URL
$id = $_GET["id"];

				//Mengambil data di database melalui fungsi query
				$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];


		if(isset($_POST["submit"])){ // Mengecek apakah tombol submit sudah di tekan apa belum

			

				if(ubah($_POST)>0) {
					echo "
						<script>
							alert('Data berhasil diubah!');
							window.location.href = 'index.php';
						</script>
					";	
					
				}
				else {
					echo "<script>
							alert('Data gagal diubah!');
							windows.location.href = 'index.php';
						</script>
						";
				}
			

			

		}

 ?>



<!DOCTYPE html>
<html>
<head>
	<title>Ubah Data Mahasiswa</title>
</head>
<body>
	<h1>UBAH DATA MAHASISWA</h1>
	<form action="" method="post">

		<ul>
			<!-- input bertype hidden untuk tidak menampilkan ke user -->
			<input type="hidden" name="id" value="<?php echo $mhs["id"]; ?>">

			<li>
				<label for="nama">Nama</label>
				<input type="text" name="nama" id="nama" value="<?php echo $mhs["nama"]; ?>">
			</li>
			
			<li>
				<label for="nim">NIM</label>
				<input type="text" name="nim" id="nim" value="<?php echo $mhs["nim"]; ?>">
			</li>
			<li>
				<label for="jurusan">Jurusan</label>
				<input type="text" name="jurusan" id="jurusan" value="<?php echo $mhs["jurusan"]; ?>">
			</li>
			<li>
				<label for="gambar">Gambar</label>
				<input type="text" name="gambar" id="gambar" value="<?php echo $mhs["gambar"]; ?>">
			</li>
			<li>
				<button type="submit" name="submit">Ubah Data!</button>
			</li>
		</ul>
		
	</form>

</body>
</html>