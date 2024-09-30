
<?php
include 'Conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get the client name and initial client code from the form
        //==================================//==================================
        $clientName = $_POST['clientName'];
        $initialClientCode = $_POST['clientCode'];

        // Extract the prefix and last three digits from the initial client code
        //==================================//==================================
        $codePrefix = substr($initialClientCode, 0, 3);
        $baseCodeNumber = intval(substr($initialClientCode, 3));

        // Query to find the highest existing code with the same prefix
        //==================================//==================================
        $stmt = $conn->prepare("SELECT MAX(SUBSTRING(code, 4)) AS max_code FROM client WHERE code LIKE ?");
        $likeCode = $codePrefix . '%';
        $stmt->bind_param("s", $likeCode);
        
        // Execute the query
        //==================================
        if (!$stmt->execute()) {
            throw new Exception("Error executing query to get max client code: " . $stmt->error);
        }

        // Get the result and determine the new client code
        //==================================//==================================
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row['max_code'] !== null) {
            $existingMaxCode = intval($row['max_code']);
            if ($baseCodeNumber <= $existingMaxCode) {
                $baseCodeNumber = $existingMaxCode + 1; 
            }
        }

        // Generate the new client code
        //==================================
        $newClientCode = $codePrefix . str_pad($baseCodeNumber, 3, '0', STR_PAD_LEFT);

        // Process the contacts first
        //==================================
        if (!empty($_POST['contacts'])) {
            $contacts = json_decode($_POST['contacts'], true);

            // Check if contacts data was decoded successfully
            //==================================//==================================
            if (is_array($contacts) && count($contacts) > 0) {
                // Prepare the contact insertion statement
                $stmtContact = $conn->prepare("INSERT INTO contact (name, surname, email, client_code) VALUES (?, ?, ?, ?)");

                foreach ($contacts as $contact) {
                    $fullName = $contact['fullName'];
                    $surname = $contact['surname'];
                    $email = $contact['email'];

                    // Bind parameters for each contact
                    //==================================
                    $stmtContact->bind_param("ssss", $fullName, $surname, $email, $newClientCode);

                    // Try to execute the statement for each contact
                    if (!$stmtContact->execute()) {
                        throw new Exception("Error inserting contact ($fullName $surname): " . $stmtContact->error);
                    }

                    echo "Contact added successfully: $fullName $surname<br>";
                }

                // Close the contact statement after processing all contacts
                //==================================//==================================
                $stmtContact->close();
            } else {
                throw new Exception("No valid contacts provided or error decoding contacts JSON.");
            }
        }

        // Insert the client after contacts have been added
        //==================================//==================================
        $stmtClient = $conn->prepare("INSERT INTO client (name, code) VALUES (?, ?)");
        $stmtClient->bind_param("ss", $clientName, $newClientCode);

        if (!$stmtClient->execute()) {
            throw new Exception("Error inserting new client: " . $stmtClient->error);
        }

        echo "Client added successfully: $clientName with code $newClientCode<br>";

        // Close client statement and connection
        //==================================
        $stmtClient->close();
        $conn->close();
    } catch (Exception $e) {
        // Catch any exceptions and display the error message
        //==================================//==================================
        echo "Error: " . $e->getMessage() . "<br>";
    }
}
?>
