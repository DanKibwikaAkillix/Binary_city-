
 
    <!-- Modal for Adding New Contact -->
    <!-- //================================== -->
    <div id="newContactModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('newContactModal')">&times;</span>
            <h2>Add New Contact</h2>
            <label for="contactFullNameInput">Name:</label>
            <input type="text" id="contactFullNameInput" placeholder="Enter full name">
            <label for="contactSurnameInput">Surname:</label>
            <input type="text" id="contactSurnameInput" placeholder="Enter surname">
            <label for="contactEmailInput">Email:</label>
            <input type="email" id="contactEmailInput" placeholder="Enter email address">
            <button class="add-contact-btn" type="button" onclick="addContact()">Add Contact</button>
        </div>
    </div>