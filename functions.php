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
			// $gambar = htmlspecialchars($data["gambar"]);

			//Upload foto
			$gambar = upload();
			if(!$gambar) {

				return false;
			}





			// query insert data
			$query = "INSERT INTO mahasiswa VALUES
			('','$nama','$nim','$jurusan','$gambar')";

			mysqli_query($db,$query); 

			return mysqli_affected_rows($db);
	}


		function upload() {
				
				$namaFile = $_FILES['gambar']['name'];
				$ukuranFile = $_FILES['gambar']['size'];
				$error = $_FILES['gambar']['error'];
				$tmpName = $_FILES['gambar']['tmp_name'];

				//cek apakah gambar di upload apa belum
				if ($error === 4) {
					echo "<script>
						alert('Pilih file dulu!'); 
					</scrip>
					"; 
					return false;
					
				}

				//cek apakah yang di upload itu berekstensi gambar apa tidak
				$ekstensiGambarValid = ['jpg','png','jpeg'];

				//mengambil ekstensi file yang di upload lalu di pecah dengan expload untuk memisah nama file dengan ekstensinya
				$ekstensiGambar = explode('.', $namaFile);

				//mengambil ekstensi gambar/array terakhir menggunakan fungsi end
				//menggunakan fungsi strtolower() untuk memaksa semua ekstensinya dengan huruf kecil
				$ekstensiGambar = strtolower(end($ekstensiGambar));

				//mengecek ekstensi gambar yang di upload ada gak di $ekstensiGambarValid?
				//menggunakan fungi if yang didalamnya ada fungsi in_array(needle, haystack)
				//needle = jarum haystack = jerami sama dengan mencari jarum ditumpukan jerami
				// jarumnya $ekstensiGambar dan jeraminya $ekstensiGambarValid
				//tanda seru(!) di fungsi in_array digunakan untuk memberitahu bahwa yang di upload itu bukan salah 1 dari ekstensi di $eksrensiGambarValid
				if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
					echo "<script>
						alert('Yang anda Upload Bukan Gambar'); 
					</scrip>
					"; 
					return false;
				}

				//cek jika ukurannya terlalu besar
				if ($ukuranFile>1000000) {
					echo "<script>
						alert('Ukuran gambar terlalu besar!'); 
					</scrip>
					"; 
					return false;
				}

				//lolos pengecekan gambar siap di upload
				//membuat agar nama gambarnya menjadi random

				$namaFileBaru = uniqid();
				$namaFileBaru .= '.';
				$namaFileBaru .= $ekstensiGambar;
				

				move_uploaded_file($tmpName, 'img/'.$namaFileBaru);
				return $namaFileBaru;



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
			$gambarLama = htmlspecialchars($data["gambarLama"]);


			//cek apakah user menekan tombol upload atau tidak
			if ($_FILES['gambar']['error'] === 4) {

				$gambar = $gambarLama;
			
			} else {
			
				$gambar = upload();
			
			}

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

function register($data){
		global $db;
			//striplashes() berfungsi membersihkan agar ketika user menginputkan karakter tertentu (contoh : \(backslash)) itu tidak dimasukkan ke database
			//strtolower() berfungsi agar semua karakter yang diinputkan user dipaksa menjadi huruf kecil semua
		$username = strtolower(stripslashes($data["username"]));
		//mysqli_real_escape() untuk memungkinkan user memasukkan password berupa tanda kutip ("")
		//yang memiliki 2 argument ($db(koneksi), $data["password"] )
		$password = mysqli_real_escape_string($db, $data["password"]); 
		$password2 = mysqli_real_escape_string($db, $data["password2"]);

		//cek apakah username sudah ada atau belum di database
		$result = mysqli_query($db, "SELECT username FROM user WHERE username = '$username'");

			if (mysqli_fetch_assoc($result)) {
				
				echo "<script>
						alert('Username sudah pernah digunakan!');
						</script>
				"; return false;

			} 

		//cek apakah password sama dengan password2
		if ($password !== $password2) {
			echo "
				<script>
				alert ('Password tidak sesuai!');
				</script>
			";

			return false;
		}
		// return true;


			//encrypt password
		//fungsi password_hash() memiliki 2 parameter, 1.password mana yang mau diacak 2. mengacaknya menggunakan algoritma apa? 
		// $password = md5($password);
		$password = password_hash($password, PASSWORD_DEFAULT);
		


		//tambahkan user baru ke dalam database
		mysqli_query($db, "INSERT INTO user VALUES ('', '$username','$password')");

			return mysqli_affected_rows($db);


}








 ?>