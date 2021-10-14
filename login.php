<?php 

		require('functions.php');	

		if (isset($_POST["login"])) {

			//mengambil data yang dikirimkan dari setelah menekan tombol login
			$username = $_POST["username"];
			$password = $_POST["password"];


				//mengecek apakah username yang di inputkan dari login ada tidak di database
				$result = mysqli_query($db, "SELECT * FROM user WHERE username = '$username'");

				//cek username
				//fungsi dari mysqli_num_rows() yaitu menghitung ada berapa baris yang dikembalikan dari quer diatas $result
				if (mysqli_num_rows($result) === 1) {


						//cek password
					//mengambil data dari result dulu menggunakan mysqli_fetch_assoc() dengan index kalimat
					$row = mysqli_fetch_assoc($result);
					//menggunakan fungsi password_verify() yang didalamnya ada 2 parameter. yakni password yang dikirim dari form login, dan password acak yang sudah di ecrypt di database
					//kenapa menggunakan $row, karena row berisi data dari result
					if(password_verify($password, $row["password"]))	{


						header("Location:index.php");
						exit;
					}
					

				}

				$error = true;


		}



 ?>









<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Halaman Login</title>
</head>
<body>
	<h1>Halaman Login</h1>
	<?php if (isset($error)) :?>
		
		<?php echo "<script>

		alert('Username / Password Salah!');

		</script>
		"; ?>

	<?php endif; ?>

	<form action="" method="post">
		<ul>
			<li>
				<label for="username">Username :</label>
				<input type="text" name="username" id="username">
			</li>
			<li>
				<label for="password">Password :</label>
				<input type="password" name="password" id="password">
			</li>
			<li>
				<button type="submit" name="login">Login</button>
			</li>
		</ul>
	</form>

</body>
</html>