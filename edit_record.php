<style>
    .delete {
        background-color: red;
        color: white;
    }
    .delete:hover {
        background-color: darkred;
    }
</style>

<?php
// Connect to database
$mysqli = new mysqli("localhost", "root", "", "medrecord");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Update a record
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
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

    // Prepare update statement
    $stmt = $mysqli->prepare("UPDATE patient SET name=?, email=?, birthdate=?, phone=?, gender=?, address=?, blood_group=?, height=?, weight=?, comments=? WHERE id=?");
    $stmt->bind_param("ssssssssssi", $name, $email, $birthdate, $phone, $gender, $address, $blood_group, $height, $weight, $comments, $id);

    if ($stmt->execute()) {
        echo "Record updated successfully. Show the <a href='patient_table.php'>patient table</a> to see the updated record.";
    } else {
        echo "Error updating record: " . $stmt->error;
    }
    exit();
}

// Delete a record
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $stmt = $mysqli->prepare("DELETE FROM patient WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Record deleted successfully. Show the <a href='patient_table.php'>patient table</a> to see the deleted record.";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    exit();
}

// Select patient record
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Validate that id is a number
    if (!is_numeric($id)) {
        echo "Invalid ID format.";
        exit();
    }

    $stmt = $mysqli->prepare("SELECT * FROM patient WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch record
        $row = $result->fetch_assoc();

        // Display patient details
        echo "<h1>Edit Record</h1>";
        echo "<form action='edit_record.php' method='post'>";
        echo "<input type='hidden' name='id' value='" . htmlspecialchars($row["id"]) . "'>";
        echo "<label for='name'>Name:</label>";
        echo "<input type='text' id='name' name='name' value='" . htmlspecialchars($row["name"] ?? '') . "' required><br><br>";
        echo "<label for='email'>Email:</label>";
        echo "<input type='email' id='email' name='email' value='" . htmlspecialchars($row["email"] ?? '') . "' required><br><br>";
        echo "<label for='birthdate'>Birthdate:</label>";
        echo "<input type='date' id='birthdate' name='birthdate' value='" . htmlspecialchars($row["birthdate"] ?? '') . "' required><br><br>";
        echo "<label for='phone'>Phone:</label>";
        echo "<input type='tel' id='phone' name='phone' value='" . htmlspecialchars($row["phone"] ?? '') . "' required><br><br>";
        echo "<label for='gender'>Gender:</label>";
        echo "<select id='gender' name='gender' required>";
        echo "<option value='Male'" . (($row["gender"] ?? '') == "Male" ? " selected" : "") . ">Male</option>";
        echo "<option value='Female'" . (($row["gender"] ?? '') == "Female" ? " selected" : "") . ">Female</option>";
        echo "<option value='Other'" . (($row["gender"] ?? '') == "Other" ? " selected" : "") . ">Other</option>";
        echo "</select><br><br>";
        echo "<label for='address'>Address:</label>";
        echo "<input type='text' id='address' name='address' value='" . htmlspecialchars($row["address"] ?? '') . "' required><br><br>";
        echo "<label for='blood_group'>Blood Group:</label>";
        echo "<select id='blood_group' name='blood_group' required>";
        echo "<option value='A+'" . (($row["blood_group"] ?? '') == "A+" ? " selected" : "") . ">A+</option>";
        echo "<option value='A-'" . (($row["blood_group"] ?? '') == "A-" ? " selected" : "") . ">A-</option>";
        echo "<option value='B+'" . (($row["blood_group"] ?? '') == "B+" ? " selected" : "") . ">B+</option>";
        echo "<option value='B-'" . (($row["blood_group"] ?? '') == "B-" ? " selected" : "") . ">B-</option>";
        echo "<option value='AB+'" . (($row["blood_group"] ?? '') == "AB+" ? " selected" : "") . ">AB+</option>";
        echo "<option value='AB-'" . (($row["blood_group"] ?? '') == "AB-" ? " selected" : "") . ">AB-</option>";
        echo "<option value='O+'" . (($row["blood_group"] ?? '') == "O+" ? " selected" : "") . ">O+</option>";
        echo "<option value='O-'" . (($row["blood_group"] ?? '') == "O-" ? " selected" : "") . ">O-</option>";
        echo "</select><br><br>";
        echo "<label for='height'>Height (cm):</label>";
        echo "<input type='number' id='height' name='height' min='150' max='300' value='" . htmlspecialchars($row["height"] ?? '') . "' required><br><br>";
        echo "<label for='weight'>Weight (kg):</label>";
        echo "<input type='number' id='weight' name='weight' min='50' max='200' value='" . htmlspecialchars($row["weight"] ?? '') . "' required><br><br>";
        echo "<label for='comments'>Comments:</label>";
        echo "<textarea id='comments' name='comments' rows='5' cols='50'>" . htmlspecialchars($row["comments"] ?? '') . "</textarea><br><br>";
        echo "<input type='submit' value='Submit' name='submit'> ";
        echo "<input type='submit' class='delete' value='Delete' name='delete' onclick='return confirm(\"Are you sure you want to delete this record?\")'>";
        echo "</form>";
    } else {
        echo "Patient not found.";
    }
} else {
    echo "Invalid ID.";
}

// Close connection
$mysqli->close();
?>
