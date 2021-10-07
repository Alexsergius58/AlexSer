<?php 
	
require ('functions.php');

$mahasiswa = query("SELECT * FROM mahasiswa");	

//Ketika tombol cari di tekan
if (isset($_POST["cari"])) {

	//Data $mahasiswa akan berisi data hasil pencarian dari function cari, lalu function cari mendapatkan data dari apa yang ditulis dalam keyword
	$mahasiswa = cari($_POST["keyword"]);
}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1><a href="index.php">Daftar Mahasiswa</a></h1>
	<a href="tambah.php">Tambah Data Mahasiswa</a>
	<br>
	<br>
	<form action="" method="post">
		<!-- <label for="keyword"> Cari Data Mahasiswa</label> -->

		<input type="text" name=" keyword" id="keyword" size="40" autofocus placeholder="Masukan Data yang dicari.." autocomplete="off"> <!-- autofokus, berfungsi agar text langsung aktif  -->
		<!-- placeholder. digunakan untuk memberi text dalam textbox dan ketika ditulis akan hilang -->
		<!-- autocomplete dengan value "off", berfungsi agar histori/saran kata dihilangkan -->

		<button type="submit" name="cari"> Cari!</button>
	</form>
	<br>
	

	<table border="1" cellspacing="0" cellpadding="10">
		<tr>
			<th>Id</th>
			<th>Aksi</th>
			<th>Gambar</th>
			<th>Nama</th>
			<th>NIM</th>
			<th>Jurusan</th>

		</tr>
		<?php $i=1; ?>
			<?php foreach ($mahasiswa as $row) : ?>
		<tr>
			<td><?php echo $i ?></td>
			<td>
				<a href="ubah.php?id=<?php echo $row["id"]; ?>">Ubah</a> |
				<a href="hapus.php?id=<?php echo $row["id"] ?>"onclick = "return confirm('yakin?');">Hapus</a>
				<!-- onclick = "return confrim('yakin');" fungsi yang digunakan untuk memunculkan pilihan apakah kita yakin untuk melakukan tindakan tersebut --> 
			</td>
			<td><img src="img/<?php echo $row["gambar"] ?>" width="50"></td>
			<td><?php echo $row["nama"] ?></td>
			<td><?php echo $row["nim"] ?></td>
			<td><?php echo $row["jurusan"] ?></td>
		</tr>
		<?php $i++; ?>
	<?php endforeach; ?>

	</table>

</body>
</html>