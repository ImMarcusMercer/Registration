<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <title>Web Systems Activity 1</title>
</head>
    <a href="index.php"><button>Go Back</button><br></a>
<?php
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$address = $_POST['address'];
$selectedDate = $_POST['selected_date'];
$gender = $_POST['gender'];
$email = $_POST['email'];

// Check Values(comment if not needed)
echo $fname . "<br>";
echo $lname . "<br>";
echo $address . "<br>";
echo $selectedDate . "<br>";
echo $gender . "<br>";
echo $email . "<br>";

try {
	$db = new PDO("sqlite:record.db");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "Connection to the database was successful.<br>";

	// Create table if not exists
	$db->exec("CREATE TABLE IF NOT EXISTS customer (
		first_name VARCHAR(50),
		last_name VARCHAR(50),
		city_address VARCHAR(100),
		birthdate TEXT,
		gender VARCHAR(10),
		email VARCHAR(50)
	)");

	// Corrected insert with bound parameters
	$stmt = $db->prepare("INSERT INTO customer (first_name, last_name, city_address, birthdate, gender, email) 
		VALUES (:first_name, :last_name, :city_address, :birthdate, :gender, :email)");

	$stmt->bindParam(':first_name', $fname);
	$stmt->bindParam(':last_name', $lname);
	$stmt->bindParam(':city_address', $address);
	$stmt->bindParam(':birthdate', $selectedDate);
	$stmt->bindParam(':gender', $gender);
	$stmt->bindParam(':email', $email);

	$stmt->execute();

	echo "Data saved successfully!";
} catch (PDOException $e) {
	echo "Database error: " . $e->getMessage();
}
?>

</html>
