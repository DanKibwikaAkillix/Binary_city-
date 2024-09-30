<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Generator</title>
</head>
<body>
    <h1>6 Character Code Generator</h1>
    <form id="codeForm">
        <label for="clientName">Enter a name: </label>
        <input type="text" id="clientName" placeholder="Enter client name" required>
        <button type="submit">Generate Code</button>
    </form>
    <p id="generatedCode"></p>

    <script>


let codeCounter = 0; // Starting number counter

// List of prepositions and common small words to ignore
//==================================//==================================
const ignoredWords = ["AND", "OF", "FOR", "THE", "A", "AN", "BUT", "FROM"];

// Function to generate the code based on user input
function generateCode(name) {
    //==================================//==================================
    // Convert name to uppercase and split into words
    name = name.toUpperCase().trim().split(" ");

    let acronym = "";

    if (name.length === 1) {
        // If it's a single word
        let word = name[0];
        if (word.length >= 3) {
            acronym = word.slice(0, 3); // First 3 letters
        } else {
            // If less than 3 letters, fill with random letters
            //==================================//==================================
            acronym = word.padEnd(3, randomLetter());
        }
    } else {
        // If multiple words, filter out the ignored words
        //==================================//==================================
        let filteredWords = name.filter(word => !ignoredWords.includes(word));

        // Take the first letters of up to 3 valid words
        //==================================//==================================
        filteredWords.forEach((word, index) => {
            if (acronym.length < 3 && word.length > 0) {
                acronym += word[0];
            }
        });

        // Ensure acronym is 3 letters long
        //==================================
        acronym = acronym.padEnd(3, randomLetter());
    }

    // Increment the number (3 digits, padded with zeros)
    //==================================//==================================
    let numberPart = String(codeCounter).padStart(3, '0');

    // Increment the counter for the next code
    //==================================
    codeCounter++;

    // Return the final 6-character code
    //==================================
    return acronym + numberPart;
}

// Function to generate a random uppercase letter
//==================================//==================================
function randomLetter() {
    const letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    return letters[Math.floor(Math.random() * letters.length)];
}

// Handling form submission and generating the code
//==================================//==================================
document.getElementById("codeForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form refresh
    const clientName = document.getElementById("clientName").value;
    const code = generateCode(clientName);
    document.getElementById("generatedCode").textContent = "Generated Code: " + code;
});


    </script>
</body>
</html>
