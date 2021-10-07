<?php 
//Koneksi database
	$db = mysqli_connect("localhost", "root", "", "phpdasar"); //variable db yang berisi sql untuk koneksi ke database

//Ambil data dari table mahasiswa/query datan mahasiswa
	

	function query ($query) { //fungsi query dengan parameter $query yang menangkap inputan dari index.php
		global $db; //menggunakan fungsi global agar variable db yang berisi koneksi database bisa dipanggil didalam fungsi ini
		
		$result = mysqli_query($db, $query); //mengambil data pada table yang ada di database ($query yang ada di index.php)
		
		$rows = []; //array kosong yang nantinya akan dipakai untuk menampilkan data / koper kosong logikanya
		
		while ($row = mysqli_fetch_assoc($result)) {
			$rows[] =$row; //mengisi data rows dengan data row. ibaratnya itu rows adalah koper dan row adalah lemari, makanya perlu koper agar si API lebih gampang untuk menampilkan data yang diminta user

		}
		return $rows; //menampilkan data
	}	

	function tambah ($data){
		global $db;
		//ambil data yang ada dalam form

			$nama = htmlspecialchars($data["nama"]); //htmlspecialchars(string) berfungsi untuk tidak mengeksekusi perintah html didalam form pengisian data
			$nim = htmlspecialchars($data["nim"]);
			$jurusan = htmlspecialchars($data["jurusan"]);
			$gambar = htmlspecialchars($data["gambar"]);

			// query insert data
			$query = "INSERT INTO mahasiswa VALUES
			('','$nama','$nim','$jurusan','$gambar')";

			mysqli_query($db,$query); 

			return mysqli_affected_rows($db);
	}

	function hapus ($id) {
		global $db;
		mysqli_query($db, "DELETE FROM mahasiswa WHERE id=$id");
		return mysqli_affected_rows($db);
	}

	function ubah ($data) {

		global $db;
		//ambil data yang ada dalam form
		$id = $data["id"];

			$nama = htmlspecialchars($data["nama"]); //htmlspecialchars(string) berfungsi untuk tidak mengeksekusi perintah html didalam form pengisian data
			$nim = htmlspecialchars($data["nim"]);
			$jurusan = htmlspecialchars($data["jurusan"]);
			$gambar = htmlspecialchars($data["gambar"]);

			// query insert data
			$query = "UPDATE mahasiswa SET
			nama = '$nama',
			nim = '$nim',
			jurusan = '$jurusan',
			gambar = '$gambar'
			WHERE id =$id;
			";

			mysqli_query($db,$query); 

			return mysqli_affected_rows($db);


	}
	function cari($keyword) {
		$query = "SELECT * FROM mahasiswa WHERE
				nama LIKE '%$keyword%' OR
				nim LIKE '%$keyword%' OR
				jurusan LIKE '%$keyword%'
		";

		return query($query);
	}

 ?>