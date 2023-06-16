<?php
include "db_connect.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Students Dashboard</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
<h1>Welcome Students!</h1>

<table>
    <thead>
    <tr>
        <th>Registration number</th>
        <th>Address</th>
        <th>Description</th>
        <th>Price</th>
        <th>Availability</th>
    </tr>
    </thead>

    <tbody>
    <?php
    $sql = "SELECT Prop_ID, Prop_Address, Prop_Description, Prop_Price, Prop_Avail FROM properties";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $propID = $row["Prop_ID"];
            echo "<tr>";
            echo "<td>" . $propID . "</td>";
            echo "<td>" . $row["Prop_Address"] . "</td>";
            echo "<td>" . $row["Prop_Description"] . "</td>";
            echo "<td>" . $row["Prop_Price"] . "</td>";
            echo "<td>" . $row["Prop_Avail"] . "</td>";

            // Retrieve related photos
            $photosSql = "SELECT Phot_Data FROM Photos WHERE Prop_ID = '$propID'";
            $photosResult = $mysqli->query($photosSql);

            if ($photosResult->num_rows > 0) {
                echo "<td>";
                while ($photoRow = $photosResult->fetch_assoc()) {
                    $photoData = $photoRow["Phot_Data"];
                    $photoSrc = 'data:image/jpeg;base64,' . base64_encode($photoData);
                    echo "<img src='$photoSrc' alt='Property Photo' style='max-width: 200px; max-height: 200px;'>";
                }
                echo "</td>";
            } else {
                echo "<td>No photos available</td>";
            }

            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>0 results</td></tr>";
    }
    $mysqli->close();
    ?>
    </tbody>
</table>

</body>
</html>