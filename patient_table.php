<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

th {
    background-color: #4caf50;
    color: white;
}
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<?php
// Connect to database
$mysqli = new mysqli("localhost", "root", "", "medrecord"); 

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch records
$qry = "SELECT * FROM patient";
$result = $mysqli->query($qry);

if ($result->num_rows > 0) {
    echo "<h1>Patients</h1><table>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Name</th>";
    echo "<th>Email</th>";
    echo "<th>Birthdate</th>";
    echo "<th>Phone</th>";
    echo "<th>Gender</th>";
    echo "<th>Address</th>";
    echo "<th>Blood Group</th>";
    echo "<th>Height (cm)</th>";
    echo "<th>Weight (kg)</th>";
    echo "<th>Comments</th>";
    echo "<th>Action</th>";
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["id"] ?? 'N/A') . "</td>";
        echo "<td>" . htmlspecialchars($row["name"] ?? 'N/A') . "</td>";
        echo "<td>" . htmlspecialchars($row["email"] ?? 'N/A') . "</td>";
        echo "<td>" . htmlspecialchars($row["birthdate"] ?? 'N/A') . "</td>";
        echo "<td>" . htmlspecialchars($row["phone"] ?? 'N/A') . "</td>";
        echo "<td>" . htmlspecialchars($row["gender"] ?? 'N/A') . "</td>";
        echo "<td>" . htmlspecialchars($row["address"] ?? 'N/A') . "</td>";
        echo "<td>" . htmlspecialchars($row["blood_group"] ?? 'N/A') . "</td>";
        echo "<td>" . htmlspecialchars($row["height"] ?? 'N/A') . "</td>";
        echo "<td>" . htmlspecialchars($row["weight"] ?? 'N/A') . "</td>";
        echo "<td>" . htmlspecialchars($row["comments"] ?? 'N/A') . "</td>";
        echo "<td><a href='edit_record.php?id=" . htmlspecialchars($row["id"] ?? 'N/A') . "'>Edit</a></td>";
        echo "</tr>";       
    }
    echo "</table>";
} else {
    echo "No records found";
}

// Close connection
$mysqli->close();
?>
