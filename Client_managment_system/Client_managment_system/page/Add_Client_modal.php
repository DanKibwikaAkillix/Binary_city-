<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Code Generator</title>
    <style>
        .modal-content { background-color: #fefefe; padding: 20px; border: 1px solid #888; width: 300px; margin: 0 auto; }
        .close { float: right; font-size: 28px; font-weight: bold; cursor: pointer; }
        #clientCodeInput { font-weight: bold; font-size: 18px; text-align: center; }
    </style>
</head>
<body>
    <!-- Modal for Adding New Client -->
    <div id="newClientModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('newClientModal')">&times;</span>
            <h2>Add New Client</h2>
            
            <!-- Form to submit client name and code -->
            <form action="#" method="POST">
                <label for="clientNameInput">Client Name:</label>
                <input type="text" id="clientNameInput" name="clientName" placeholder="Enter client name" onblur="generateCodeWithAnimation()" required>

                <label for="clientCodeInput">Client Code:</label>
                <input type="text" id="clientCodeInput" name="clientCode" value="GeneratedClientCode" readonly>

                <!-- Button to add contact (not implemented yet) -->
                <button class="add-contact-btn" type="button" onclick="openContactModal()">Add Contact</button>

                <!-- Contacts will be added dynamically here -->
                <div id="contactList"></div>

                <!-- Save Client Button -->
                <button class="save-client-btn" type="submit">Save Client</button>
            </form>
        </div>
    </div>



    
  <!-- Modal for Adding New Contact -->
  <div id="newContactModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('newContactModal')">&times;</span>
      <h2>Add New Contact</h2>
      <label for="contactFullNameInput">Name:</label>
      <input type="text" id="contactFullNameInput" placeholder="Enter full name">

      <label for="contactFullNameInput">Surname:</label>
      <input type="text" id="contactFullNameInput" placeholder="Enter full name">

      <label for="contactEmailInput">Email:</label>
      <input type="email" id="contactEmailInput" placeholder="Enter email address">

      <!-- Add the contact to the contact list -->
      <button class="add-contact-btn" onclick="addContact()">Add Another Contact</button>
    </div>
  </div>





    <script>
        let codeCounter = 1; // Starting number counter set to 1
        const ignoredWords = ["AND", "OF", "FOR", "THE", "A", "AN", "BUT", "FROM"];

        // Function to generate code with animation
        function generateCodeWithAnimation() {
            const clientName = document.getElementById("clientNameInput").value;
            const generatedCode = generateCode(clientName);

            // Set the initial value to include the acronym followed by '001' before the animation
            const clientCodeInput = document.getElementById("clientCodeInput");
            clientCodeInput.value = generatedCode.slice(0, 3) + '001';

            // Run the count-up animation
            let currentCount = 1; // Start counting from 1
            const interval = setInterval(() => {
                if (currentCount < parseInt(generatedCode.slice(3))) {
                    currentCount++;
                    clientCodeInput.value = generatedCode.slice(0, 3) + String(currentCount).padStart(3, '0');
                } else {
                    clearInterval(interval); // Stop the animation when the count is reached
                }
            }, 100); // Animation speed
        }

        // Function to generate the code based on user input
        function generateCode(name) {
            name = name.toUpperCase().trim().split(" ");

            let acronym = "";

            if (name.length === 1) {
                let word = name[0];
                if (word.length >= 3) {
                    acronym = word.slice(0, 3); // First 3 letters
                } else {
                    acronym = word.padEnd(3, randomLetter());
                }
            } else {
                let filteredWords = name.filter(word => !ignoredWords.includes(word));

                filteredWords.forEach((word, index) => {
                    if (acronym.length < 3 && word.length > 0) {
                        acronym += word[0];
                    }
                });

                acronym = acronym.padEnd(3, randomLetter());
            }

            // Ensure codeCounter starts at 1 for the number part
            let numberPart = String(codeCounter).padStart(3, '0');
            codeCounter++;
            return acronym + numberPart;
        }

        // Function to generate a random uppercase letter
        function randomLetter() {
            const letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            return letters[Math.floor(Math.random() * letters.length)];
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        function openContactModal() {
            alert("Contact modal opened (not implemented)");
        }
    </script>
</body>

<?php
include 'Conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the client name and client code from the form
    $clientName = $_POST['clientName'];
    $clientCode = $_POST['clientCode'];

    // Extract the first 3 letters from the client code
    $acronym = substr($clientCode, 0, 3);
    $numberPart = intval(substr($clientCode, 3));

    // Start with 1 if no previous number part exists
    if ($numberPart == 0) {
        $numberPart = 1;
    }

    // Check if the last 3 digits exist in any other client code in the database
    do {
        $query = "SELECT COUNT(*) FROM client WHERE SUBSTRING(code, -3) = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", str_pad($numberPart, 3, '0', STR_PAD_LEFT));
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        // If a match is found, increment the number part
        if ($count > 0) {
            $numberPart++;
        }
    } while ($count > 0); // Continue until a unique number is found

    // Create the final client code with the unique number part
    $newClientCode = $acronym . str_pad($numberPart, 3, '0', STR_PAD_LEFT);
    echo "<p>Client code was incremented to: $newClientCode</p>";

    // Insert the new client into the database
    $stmt = $conn->prepare("INSERT INTO client (name, code) VALUES (?, ?)");
    $stmt->bind_param("ss", $clientName, $newClientCode);

    if ($stmt->execute()) {
        echo "New client added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

?>

</html>
