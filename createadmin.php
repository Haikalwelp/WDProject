<?php
include 'database/db.php';

// Create the admin table
$create_table_query = "
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    adminEmail VARCHAR(255),
    adminPassword VARCHAR(255)
)";
if ($conn->query($create_table_query) === TRUE) {
    echo "Admin table created successfully!<br>";
} else {
    echo "Error creating admin table: " . $conn->error;
}

// Insert the first admin data
$adminEmail = "haikalultraman123@gmail.com";
$adminPassword = "12345";

$insert_query = "INSERT INTO admin (adminEmail, adminPassword) VALUES (?, ?)";
$stmt = $conn->prepare($insert_query);
$stmt->bind_param("ss", $adminEmail, $adminPassword);
$stmt->execute();

echo "First admin data inserted successfully!<br>";

// Close the statement and connection
$stmt->close();
$conn->close();
?>
