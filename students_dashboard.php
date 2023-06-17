<?php
include "db_connect.php";

if (isset($_GET['incrementPopularity'])) {
    $propID = $_GET['incrementPopularity'];

    // Increment the popularity value for the given property
    $incrementSql = "UPDATE Properties SET Prop_Popularity = Prop_Popularity + 1 WHERE Prop_ID = '$propID'";
    $mysqli->query($incrementSql);
}
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

        /* Styling for the pop-up window */
        .image-popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        /* Styling for the enlarged image inside the pop-up */
        .enlarged-image {
            max-width: 90%;
            max-height: 90%;
        }

        /* Styling for the close button */
        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
        }

        /* Additional styles for the search form */
        .search-block {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-block label {
            margin-right: 10px;
        }

        .search-block input[type="text"],
        .search-block input[type="date"],
        .search-block select {
            width: 200px;
            margin-right: 10px;
        }

        .search-block button {
            margin-left: 0;
        }
    </style>

    <script>
        function enlargeImage(image) {
            // Create a pop-up window
            var popup = document.createElement("div");
            popup.className = "image-popup";

            // Create an image element inside the pop-up
            var popupImage = document.createElement("img");
            popupImage.src = image.src;
            popupImage.alt = image.alt;
            popupImage.className = "enlarged-image";

            // Add the image to the pop-up
            popup.appendChild(popupImage);

            // Create a close button
            var closeButton = document.createElement("span");
            closeButton.innerHTML = "&times;";
            closeButton.className = "close-button";

            // Add the close button to the pop-up
            popup.appendChild(closeButton);

            // Append the pop-up to the document body
            document.body.appendChild(popup);

            // Register an event listener for the close button
            closeButton.addEventListener("click", function() {
                // Remove the pop-up from the document body
                document.body.removeChild(popup);
            });
        }

        function searchProperties() {
            // Submit the form for searching properties
            document.getElementById("searchForm").submit();
        }

        function incrementPopularity(propID) {
        // Send an AJAX request to the PHP script to increment the popularity
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "?incrementPopularity=" + propID, true);

        xhttp.onreadystatechange = function() {
            if (xhttp.readyState === 4 && xhttp.status === 200) {
                // Update the displayed popularity value in the table
                var popularityElement = document.getElementById("popularity-" + propID);
                if (popularityElement) {
                    popularityElement.innerText = parseInt(popularityElement.innerText) + 1;
                }
            }
        };

    xhttp.send();
    }
    </script>
</head>

<body>
<h1>Welcome Students!</h1>

<!-- Search Form -->
<form id="searchForm" action="" method="GET">
    <div class="search-block">
        <label for="priceThreshold">Price Below:</label>
        <input type="text" id="priceThreshold" name="price" value="<?php echo isset($_GET['price']) ? $_GET['price'] : ''; ?>">

        <label for="availability">Available Before:</label>
        <input type="date" id="availability" name="availability" value="<?php echo isset($_GET['availability']) ? $_GET['availability'] : ''; ?>">

        <label for="popularity">Popularity Above:</label>
        <input type="number" name="popularity" id="popularity" step="1">

        <label for="landlord">Landlord:</label>
        <input type="text" id="landlord" name="landlord" value="<?php echo isset($_GET['landlord']) ? $_GET['landlord'] : ''; ?>">

        <button type="button" onclick="searchProperties()">Search</button>
    </div>
</form>

<table>
    <thead>
    <tr>
        <th>Registration number</th>
        <th>Address</th>
        <th>Description</th>
        <th>Price</th>
        <th>Availability</th>
        <th>Popularity</th>
        <th>Landlord</th>
        <th>Email</th>
        <th>Cell Number</th>
        <th>Property Photos</th>
    </tr>
    </thead>

    <tbody>
    <?php
    // Retrieve search parameters from the URL query parameters
    $priceThreshold = isset($_GET['price']) ? $_GET['price'] : null;
    $availability = isset($_GET['availability']) ? $_GET['availability'] : null;
    $popularity = isset($_GET['popularity']) ? $_GET['popularity'] : null;
    $landlord = isset($_GET['landlord']) ? $_GET['landlord'] : null;

    // Prepare the SQL query based on the search parameters
    $sql = "SELECT p.Prop_ID, p.Prop_Address, p.Prop_Description, p.Prop_Price, p.Prop_Avail, p.Prop_Popularity, l.FName, l.LName, l.Land_Email, l.Cell_Number
            FROM Properties p
            INNER JOIN Landlords l ON p.Land_ID = l.Land_ID
            WHERE 1";

    if (!empty($priceThreshold)) {
        $sql .= " AND p.Prop_Price <= $priceThreshold";
    }

    if (!empty($availability)) {
        $sql .= " AND p.Prop_Avail <= '$availability'";
    }

    if (!empty($popularity)) {
        $sql .= " AND p.Prop_Popularity >= '$popularity'";
    }

    if (!empty($landlord)) {
        $landlordParts = explode(" ", $landlord);
        $firstName = $landlordParts[0];
        $lastName = $landlordParts[1] ?? "";

        $sql .= " AND (l.FName LIKE '%$firstName%' OR l.LName LIKE '%$lastName%')";
    }

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
            echo "<td id='popularity-" . $propID . "'>" . $row["Prop_Popularity"] . "</td>";
            echo "<td>" . $row["FName"] . " " . $row["LName"] . "</td>";
            echo "<td><a href='mailto:" . $row["Land_Email"] . "'>" . $row["Land_Email"] . "</a></td>";
            echo "<td>" . $row["Cell_Number"] . "</td>";

            // Retrieve related photos
            $photosSql = "SELECT Phot_Data FROM Photos WHERE Prop_ID = '$propID'";
            $photosResult = $mysqli->query($photosSql);

            if ($photosResult->num_rows > 0) {
                echo "<td>";
                while ($photoRow = $photosResult->fetch_assoc()) {
                    $photoData = $photoRow["Phot_Data"];
                    echo "<img src='$photoData' alt='Property Photo' class='enlarge-image' style='max-width: 200px; max-height: 200px;' onclick='incrementPopularity($propID); enlargeImage(this)'>";
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