<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="css/Page_css.css">
  <?php include 'Conn.php'; ?>
</head>
<body>
  <div class="container">
    <h1>Dashboard</h1>
    
    <p>Welcome to the Binary City Client Management System Dashboard!</p>

    <!-- Add New Client Button -->
    <button class="add-client-btn" onclick="openClientModal()">Add New Client</button>
</br>
</br>
    <!-- Table with Clients Information -->
    <table class="client-table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Client Code</th>
          <th>No. Of Linked Contacts</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>John Doe</td>
          <td>BC123</td>
          <td class="center">5</td>
          <td><button class="view-btn" onclick="openModal('John Doe', 5)">View Contacts</button></td>
        </tr>
        <tr>
          <td>Jane Smith</td>
          <td>BC124</td>
          <td class="center">3</td>
          <td><button class="view-btn" onclick="openModal('Jane Smith', 3)">View Contacts</button></td>
        </tr>
      </tbody>
    </table>
  </div>
  <?php include 'View_Contact_modal.php';?>
  <?php include 'Add_Client_modal.php'; ?>
  <?php include 'Add_Contact_modal.php';?>

  <script src="js/modal_dash.js"></script>
</body>
</html>
