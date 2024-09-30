
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