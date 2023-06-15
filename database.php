<!DOCTYPE html>
<html>
<head>
  <title>Campus Cribs - Databases</title>
</head>
<body>
  <h1>Databases</h1>
  <h1>Students:</h1>
  <!-- Add your database-related content here -->

  <?php
    include "db_connect.php";
    $sql = "SELECT Stud_ID, FName, LName, Stud_Email, Stud_Pass FROM Students";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        echo "Student ID: " . $row["Stud_ID"]. " First Name: " . $row["FName"]. " Last Name: " . $row["LName"]. " Student Email: " . $row["Stud_Email"]. " Student Password: " . $row["Stud_Pass"]."<br>";
      }
    } else {
      echo "0 results";
    }
  ?>
  
  <h1>Landlords:</h1>

  <?php
    $sql = "SELECT Land_ID, FName, LName, Land_Email, Land_Pass, Cell_Number, Land_Phot FROM Landlords";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        echo "Land ID: " . $row["Land_ID"]. " First Name: " . $row["FName"]. " Last Name: " . $row["LName"]. " Land Email: " . $row["Land_Email"]. " Landlord Password: " . $row["Land_Pass"]. " Cell Number: " . $row["Cell_Number"]. " Landlord Photo: " ."<br>";
        
        // load photo
        if (!empty($row["Land_Phot"])) {
          $photoData = $row["Land_Phot"];
          $photoSrc = 'data:image/jpeg;base64,' . base64_encode($photoData);
          echo "<br><img src='$photoSrc' alt='Landlord Photo' style='max-width: 200px; max-height: 200px;'><br>";
        } else {
           echo "No photo available<br>";
        }
      }
    } else {
      echo "0 results";
    }
  ?>

<h1>Properties:</h1>

<?php
  $sql = "SELECT Prop_ID, Prop_Address, Price, Avail, Popul, DOL FROM Properties";
  $result = $mysqli->query($sql);

  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          $propID = $row["Prop_ID"];
          echo " Property ID: " . $propID . " Address: " . $row["Prop_Address"] . " Price: " . $row["Price"] . " Availability: " . $row["Avail"] . " Popularity: " . $row["Popul"] .  " Date of Listing: " . $row["DOL"] . " Property Photos: " . "<br>";

          // Retrieve related photos
          $photosSql = "SELECT Phot_Data FROM Photos WHERE Prop_ID = '$propID'";
          $photosResult = $mysqli->query($photosSql);

          if ($photosResult->num_rows > 0) {
              while ($photoRow = $photosResult->fetch_assoc()) {
                  $photoData = $photoRow["Phot_Data"];
                  $photoSrc = 'data:image/jpeg;base64,' . base64_encode($photoData);
                  echo "<div style='display: inline-block; margin-right: 10px;'>";
                  echo "<img src='$photoSrc' alt='Property Photo' style='max-width: 200px; max-height: 200px;'>";
                  echo "</div>";
              }
          } else {
              echo "No photos available<br>";
          }

          echo "<br>";
      }
  } else {
      echo "0 results";
  }
  $mysqli->close();
?>

</body>
</html>
