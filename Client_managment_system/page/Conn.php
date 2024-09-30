
</style>

<?php
// Database connection parameters
//==================================
$host = 'localhost'; 
$username = 'root'; 
$password = ''; 
$database = 'CMS'; 

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    // Display error message 
    echo '<div class="error-message">Connection failed: ' . $conn->connect_error . '</div>';
    exit; // Stop further execution
} 

?>
<!-- git remote add origin https://github.com/DanKibwikaAkillix/Binary_city-.git
git branch -M main
git push -u origin main -->