<?php
include 'Conn.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Capture client details from the form
$client_name = $_POST['client_name'];
$client_code = $_POST['client_code'];

// Insert the client details into the `client` table
$sql = "INSERT INTO client (name, code) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $client_name, $client_code);
$stmt->execute();

// Get the generated client ID or code for linking contacts
$client_code_for_contacts = $client_code; // Use client_code as the foreign key for contacts

// Capture contact details from the form
$contact_names = $_POST['contact_name'];
$contact_surnames = $_POST['contact_surname'];
$contact_emails = $_POST['contact_email'];

// Loop through each contact and insert them into the `contact` table
for ($i = 0; $i < count($contact_names); $i++) {
    $contact_name = $contact_names[$i];
    $contact_surname = $contact_surnames[$i];
    $contact_email = $contact_emails[$i];

    // Insert contact details into `contact` table
    $sql = "INSERT INTO contact (name, surname, email, client_code) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $contact_name, $contact_surname, $contact_email, $client_code_for_contacts);
    $stmt->execute();
}

// Close the connection
$conn->close();


?>
