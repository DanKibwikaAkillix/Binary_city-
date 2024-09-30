// Function to open modals
function openModal(clientName, contactCount) {
    const modal = document.getElementById('contactModal');
    document.getElementById('clientName').textContent = `Client: ${clientName}`;
    document.getElementById('contactCount').textContent = `No. of Contacts: ${contactCount}`;
    modal.style.display = 'flex';
}

// Function to open the Add New Client modal
function openClientModal() {
    document.getElementById('newClientModal').style.display = 'flex';
}

// Function to open the Add New Contact modal
function openContactModal() {
    document.getElementById('newContactModal').style.display = 'flex';
}

// Function to close the modal
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Function to add contact details to the contact list in the New Client Modal
function addContact() {
    const fullName = document.getElementById('contactFullNameInput').value;
    const email = document.getElementById('contactEmailInput').value;

    if (fullName && email) {
        const contactList = document.getElementById('contactList');
        const contactItem = document.createElement('div');
        contactItem.classList.add('contact-item');
        // Updated background styling for the contact
        contactItem.innerHTML = `
            <div style="background-color: #e0f7fa; padding: 15px; margin: 10px 0; border-radius: 10px;">
                <p style="font-weight: bold;">${fullName}</p>
                <p>${email}</p>
            </div>`;
        contactList.appendChild(contactItem);

        // Clear the input fields and close the contact modal
        document.getElementById('contactFullNameInput').value = '';
        document.getElementById('contactEmailInput').value = '';
        closeModal('newContactModal');
    } else {
        alert('Please fill in both fields');
    }
}

// Close the modal if the user clicks outside of the modal content
window.onclick = function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach((modal) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
};
