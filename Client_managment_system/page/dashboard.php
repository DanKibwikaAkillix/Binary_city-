<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/Page_css.css">
  <?php include 'Conn.php'; ?>
  <style>
    .red-text {
      color: red;
    }
    .center {
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Dashboard</h1>
    
    <p>Welcome to the Binary City Client Management System Dashboard!</p>

    <!-- Add New Client Button -->
       <!-- //================================== -->
    <button class="btn btn-primary" onclick="openClientModal()">Add New Client</button>
    <br><br>

    <!-- Table with Clients Information -->
       <!-- //================================== -->
    <table class="table table-bordered table-striped">
      <thead class="thead-dark">
        <tr>
          <th>Name</th>
          <th>Client Code</th>
          <th>No. Of Linked Contacts</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $stmt = $conn->prepare("SELECT c.name, c.code, COUNT(co.client_code) AS contact_count
                                  FROM client c
                                  LEFT JOIN contact co ON c.code = co.client_code
                                  GROUP BY c.code");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['code']}</td>
                    <td class='center'>{$row['contact_count']}</td>
                    <td><button class='btn btn-info' onclick=\"openModal('{$row['name']}', {$row['contact_count']})\">View Contacts</button></td>
                  </tr>";
          }
        } else {
          echo "<tr><td colspan='4' class='text-center red-text'>No client(s) found</td></tr>";
        }
        ?>
      </tbody>
    </table>

    <!-- Pagination -->
       <!-- //================================== -->
    <nav aria-label="Page navigation">
      <ul class="pagination">
        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
      </ul>
    </nav>
  </div>

  <?php include 'Client_insertion_logic.php' ?>
  <?php include 'View_Contact_modal.php';?>
  <?php include 'Add_Client_modal.php'; ?>
  <?php include 'Add_Contact_modal.php';?>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="js/modal_dash.js"></script>
</body>
</html>




  <!-- View Contacts Modal -->
     <!-- //================================== -->
<div class="modal fade" id="viewContactsModal" tabindex="-1" role="dialog" aria-labelledby="viewContactsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewContactsModalLabel">Contacts for <span id="clientName"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="contactsBody">
          <?php
          if (isset($_GET['client_code'])) {
            $clientCode = $_GET['client_code'];

            // Fetch contacts for the selected client code
            <!-- //================================== -->
            $query = "SELECT name, surname, email FROM contact WHERE client_code = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $clientCode);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
              echo "<table class='table'>";
              echo "<thead>";
              echo "<tr>";
              echo "<th>Name</th>";
              echo "<th>Surname</th>";
              echo "<th>Email</th>";
              echo "</tr>";
              echo "</thead>";
              echo "<tbody>";
              while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['surname']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "</tr>";
              }
              echo "</tbody></table>";
            } else {
              echo "<p class='text-center'>No contact(s) found.</p>";
            }
          } else {
            echo "<p class='text-center'>No contact(s) found.</p>";
          }
          ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  // Function to open the modal and set the client name
  <!-- //================================== -->
  function openModal(clientCode) {
    document.getElementById('clientName').innerText = clientCode;
    $('#viewContactsModal').modal('show');
    
   
  }
</script>

</body>
</html>
