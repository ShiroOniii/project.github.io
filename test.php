<?php
// create CRUD mysqli object
$mysqli = new mysqli("localhost", "root", "", "medrecord");

// check connection
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

// create patient table if it does not exist
$sql = "CREATE TABLE IF NOT EXISTS patient (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    email VARCHAR(50),
    birthdate DATE,
    phone VARCHAR(20),
    gender VARCHAR(10),
    address VARCHAR(100),
    blood_group VARCHAR(10),
    height DECIMAL(5,2),
    weight DECIMAL(5,2),
    comments VARCHAR(255)
)
";

if ($mysqli->query($sql) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error: " . $mysqli->error;
}

// insert data
$sql = "INSERT INTO `patient` (`name`, `email`, `birthdate`, `phone`, `gender`, `address`, `blood_group`, `height`, `weight`, `comments`) VALUES ('John', 'john@example.com', '1990-01-01', '123-456-7890', 'Male', '123 Main St', 'A+', 180, 70, 'Good')";
if ($mysqli->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $mysqli->error;
}

//  read data
$sql = "SELECT * FROM `patient` WHERE `id`=2";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // fetch record
    $row = $result->fetch_assoc();
    
    // display patient details
    echo "<h1>Patient Details</h1>";
    echo "<p>Name: " . $row["name"] . "</p>";
    echo "<p>Email: " . $row["email"] . "</p>";
    echo "<p>Birthdate: " . $row["birthdate"] . "</p>";
    echo "<p>Phone: " . $row["phone"] . "</p>";
    echo "<p>Gender: " . $row["gender"] . "</p>";
    echo "<p>Address: " . $row["address"] . "</p>";
    echo "<p>Blood Group: " . $row["blood_group"] . "</p>";
    echo "<p>Height (cm): " . $row["height"] . "</p>";
    echo "<p>Weight (kg): " . $row["weight"] . "</p>";
    echo "<p>Comments: " . $row["comments"] . "</p>";
} else {
    echo "Patient not found";
}

// update data
$sql = "UPDATE `patient` SET `name`='Jane', `email`='jane@example.com', `birthdate`='1990-01-01', `phone`='123-456-7890', `gender`='Female', `address`='123 Main St', `blood_group`='A-', `height`=180, `weight`=70, `comments`='Good' WHERE `id`=1";   
if ($mysqli->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error: " . $mysqli->error;
}

// show the patient details
$sql = "SELECT * FROM `patient` WHERE `id`=2";
$result = $mysqli->query($sql); 
if ($result->num_rows > 0) {
    // fetch record
    $row = $result->fetch_assoc();
    
    // display patient details
    echo "<h1>Patient Details</h1>";
    echo "<p>Name: " . $row["name"] . "</p>";
    echo "<p>Email: " . $row["email"] . "</p>";
    echo "<p>Birthdate: " . $row["birthdate"] . "</p>";
    echo "<p>Phone: " . $row["phone"] . "</p>";
    echo "<p>Gender: " . $row["gender"] . "</p>";
    echo "<p>Address: " . $row["address"] . "</p>";
    echo "<p>Blood Group: " . $row["blood_group"] . "</p>";
    echo "<p>Height (cm): " . $row["height"] . "</p>";
    echo "<p>Weight (kg): " . $row["weight"] . "</p>";
    echo "<p>Comments: " . $row["comments"] . "</p>";
} else {
    echo "Patient not found";
}

// delete data
$sql = "DELETE FROM `patient` WHERE `id`=1";

// if ($mysqli->query($sql) === TRUE) {
//     echo "Record deleted successfully";
// } else {
//     echo "Error: " . $mysqli->error;
// }

// close connection
$mysqli->close();   