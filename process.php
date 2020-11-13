$mysqli = new mysqli('localhost', 'MYSQL', 'root', 'simpleform') or die(mysqli_error($mysqli));
if(isset($_POST['register'])){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$dob = $_POST['dob'];

	$mysqli->query("INSERT INTO data (name, email, phone, age) VALUES('$name', '$email', '$phone', '$age')") or die($mysqli->error);
}