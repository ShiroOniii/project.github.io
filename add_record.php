<?php
if (isset($_POST['submit'])) {
    // Connect to database
    $mysqli = new mysqli("localhost", "root", "", "medrecord");

    // Validasi input
    $name = $_POST['name'];
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $blood_group = $_POST['blood_group'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $comments = $_POST['comments'];

    // Cek jika birthdate kosong
    if (empty($birthdate)) {
        die("Birthdate is required.");
    }

    // Siapkan statement untuk mencegah SQL injection
    $stmt = $mysqli->prepare("INSERT INTO patient (name, email, birthdate, phone, gender, address, blood_group, height, weight, comments) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $name, $email, $birthdate, $phone, $gender, $address, $blood_group, $height, $weight, $comments);

    // Eksekusi statement
    if ($stmt->execute()) {
        echo "New record created successfully. Show the <a href='patient_table.php'>patient table</a> to see the new record.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Tutup statement
    $stmt->close();
    $mysqli->close();
    exit();
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<div class="container">
<h1>Add Record</h1>
<form action="add_record.php" method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>
    <label for="birthdate">Birthdate:</label>
    <input type="date" id="birthdate" name="birthdate" required><br><br>
    <label for="phone">Phone:</label>
    <input type="tel" id="phone" name="phone" required><br><br>
    <label for="gender">Gender:</label>
    <select id="gender" name="gender" required>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
    </select><br><br>
    <label for="address">Address:</label>
    <input type="text" id="address" name="address" required><br><br>
    <label for="blood_group">Blood Group:</label>
    <select id="blood_group" name="blood_group" required>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
    </select><br><br>    
    <label for="height">Height (cm):</label>
    <input type="number" id="height" name="height" min="150" max="300" required><br><br>
    <label for="weight">Weight (kg):</label>
    <input type="number" id="weight" name="weight" min="50" max="200" required><br><br>
    <label for="comments">Comments:</label>
    <textarea id="comments" name="comments" rows="5" cols="50"></textarea><br><br>
    <input type="submit" name='submit' value="Submit">
</form>
</div>
