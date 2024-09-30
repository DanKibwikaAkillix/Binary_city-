document.addEventListener('DOMContentLoaded', function() {
    const nextPageBtn = document.getElementById('nextPageBtn');
    
    // When the button is clicked, navigate to dashboard.php
    nextPageBtn.addEventListener('click', function() {
      window.location.href = 'page/dashboard.php'; // Navigate to dashboard.php
    });
  });
  