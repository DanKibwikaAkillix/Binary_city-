
</style>

<?php
// Database connection parameters
$host = 'localhost'; 
$username = 'root'; 
$password = ''; // Make sure this is your actual password, if any
$database = 'CMS'; 

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    // Display error message with animation
    echo '<div class="error-message">Connection failed: ' . $conn->connect_error . '</div>';
    exit; // Stop further execution
} 

?>
