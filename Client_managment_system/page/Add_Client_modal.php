<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Code Generator</title>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
            margin: 0 auto;
        }
        .close {
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        #clientCodeInput {
            font-weight: bold;
            font-size: 18px;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Modal for Adding New Client -->
    <!-- //================================== -->
    <div id="newClientModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('newClientModal')">&times;</span>
            <h2>Add New Client</h2>
            <form action="#" method="POST" id="clientForm">
                <label for="clientNameInput">Client Name:</label>
                <input type="text" id="clientNameInput" name="clientName" placeholder="Enter client name" onblur="generateCodeWithAnimation()" required>

                <label for="clientCodeInput">Client Code:</label>
                <input type="text" id="clientCodeInput" name="clientCode" value="GeneratedClientCode" readonly>

                <button class="add-contact-btn" type="button" onclick="openContactModal()">Add Contact</button>
                <div id="contactList"></div>
                <input type="hidden" id="contactsInput" name="contacts">
                <button class="save-client-btn" type="submit">Save Client</button>
            </form>
        </div>
    </div>


    <script>
        let codeCounter = 1;
        const ignoredWords = ["AND", "OF", "FOR", "THE", "A", "AN", "BUT", "FROM"];
        let contacts = [];

        function generateCodeWithAnimation() {
            const clientName = document.getElementById("clientNameInput").value;
            const generatedCode = generateCode(clientName);
            const clientCodeInput = document.getElementById("clientCodeInput");
            clientCodeInput.value = generatedCode.slice(0, 3) + '001';

            let currentCount = 1;
            const interval = setInterval(() => {
                if (currentCount < parseInt(generatedCode.slice(3))) {
                    currentCount++;
                    clientCodeInput.value = generatedCode.slice(0, 3) + String(currentCount).padStart(3, '0');
                } else {
                    clearInterval(interval);
                }
            }, 100);
        }

        function generateCode(name) {
            name = name.toUpperCase().trim().split(" ");
            let acronym = "";
            if (name.length === 1) {
                let word = name[0];
                acronym = (word.length >= 3) ? word.slice(0, 3) : word.padEnd(3, randomLetter());
            } else {
                let filteredWords = name.filter(word => !ignoredWords.includes(word));
                filteredWords.forEach(word => {
                    if (acronym.length < 3 && word.length > 0) {
                        acronym += word[0];
                    }
                });
                acronym = acronym.padEnd(3, randomLetter());
            }
            let numberPart = String(codeCounter).padStart(3, '0');
            codeCounter++;
            return acronym + numberPart;
        }

        function randomLetter() {
            const letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            return letters[Math.floor(Math.random() * letters.length)];
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        function openContactModal() {
            document.getElementById("newContactModal").style.display = "block";
        }

        function addContact() {
            const fullName = document.getElementById("contactFullNameInput").value;
            const surname = document.getElementById("contactSurnameInput").value;
            const email = document.getElementById("contactEmailInput").value;

            if (fullName && surname && email) {
                contacts.push({ fullName, surname, email });
                document.getElementById("contactList").innerHTML += `<p>${fullName} ${surname} (${email})</p>`;
                document.getElementById("newContactModal").style.display = "none";

                // Update the hidden input with the contacts as JSON
                //================================== -->
                document.getElementById("contactsInput").value = JSON.stringify(contacts);

                // Clear input fields for next entry
                //================================== -->
                document.getElementById("contactFullNameInput").value = '';
                document.getElementById("contactSurnameInput").value = '';
                document.getElementById("contactEmailInput").value = '';
            } else {
                alert("Please fill in all contact fields.");
            }
        }
    </script>



</body>
</html>
