<?php
include "db_connect.php";
session_start();

// Set the session timeout in seconds (30 minutes)
$sessionTimeout = 1800;

// Check if the session variable for the last activity timestamp exists
if (isset($_SESSION['lastActivity'])) {
    // Calculate the time difference between the current time and the last activity
    $inactiveTime = time() - $_SESSION['lastActivity'];

    // Check if the user has been inactive for longer than the session timeout
    if ($inactiveTime >= $sessionTimeout) {
        // Expire the session and redirect the user to the login page
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }
}
// Update the last activity timestamp in the session
$_SESSION['lastActivity'] = time();

if (isset($_GET['incrementPopularity'])) {
    $propID = $_GET['incrementPopularity'];

    // Increment the popularity value for the given property
    $incrementSql = "UPDATE Properties SET Prop_Popularity = Prop_Popularity + 1 WHERE Prop_ID = ?";
    $stmt = $mysqli->prepare($incrementSql);
    $stmt->bind_param("i", $propID);
    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
<div class="menu-bar">
    <ul class="menu">
        <li><a href="index.php">Home</a></li>
        <?php if (isset($_SESSION['student_id']) || isset($_SESSION['land_id'])): ?>
            <li><a href="students_dashboard.php">Properties</a></li>
        <?php endif; ?>
        <?php if (isset($_SESSION['land_id'])): ?>
            <li><a href="landlord_dashboard.php">Add a Property</a></li>
        <?php endif; ?>
    </ul>
</div>

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

        .menu-bar {
        background-color: #4CAF50;
        height: 40px;
        }

        .menu {
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: space-between;
        }

        .menu li {
        flex: 1;
        text-align: center;
        }

        .menu a {
        display: block;
        height: 100%;
        line-height: 40px;
        text-decoration: none;
        color: white;
        }

        .menu a:hover {
        background-color: #ddd;
        }

        body {
        font-family: Arial, sans-serif;
        }

        h1 {
            font-family: Arial, sans-serif;
            font-size: 24px;
            margin: 5;
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
<h1>Properties</h1>

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

        <label for="gate">Gate:</label>
        <select name="gate" id="gate">
            <option value="">Choose Gate</option>
            <option value="Gate A">Gate A</option>
            <option value="Gate B">Gate B</option>
            <option value="Gate C">Gate C</option>
            <option value="Gate D">Gate D</option>
            <option value="Gate E">Gate E</option>
            <option value="Gate F">Gate F</option>
        </select>

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
        <th>Distance to <?php echo isset($_GET['gate']) ? $_GET['gate'] : 'Gate D'; ?></th>
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
    $gate = isset($_GET['gate']) ? $_GET['gate'] : null;

    
    // Define the column mapping for the gates
    $gateColumns = [
        'Gate A' => 'Dist_A',
        'Gate B' => 'Dist_B',
        'Gate C' => 'Dist_C',
        'Gate D' => 'Dist_D',
        'Gate E' => 'Dist_E',
        'Gate F' => 'Dist_F',
    ];

    // Prepare the SQL query based on the search parameters
    $sql = "SELECT p.Prop_ID, p.Prop_Address, p.Prop_Description, p.Prop_Price, p.Prop_Avail, p.Prop_Popularity, l.FName, l.LName, l.Land_Email, l.Cell_Number, d.Dist_A, d.Dist_B, d.Dist_C, d.Dist_D, d.Dist_E, d.Dist_F
    FROM Properties p
    INNER JOIN Landlords l ON p.Land_ID = l.Land_ID
    LEFT JOIN distances d ON p.Prop_ID = d.Prop_ID
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

    // Add the ORDER BY clause to sort the results by distance to the specific gate
    if (!empty($gate) && isset($gateColumns[$gate])) {
        $gateColumn = $gateColumns[$gate];
        $sql .= " ORDER BY d.$gateColumn ASC";
    } else {
        // Default arrangement in ascending order based on Dist_D
        $sql .= " ORDER BY d.Dist_D ASC";
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
            
            // Display the relevant gate's distance if chosen by the user
            if (!empty($gate) && isset($gateColumns[$gate])) {
                $gateDistance = $row[$gateColumns[$gate]];
                echo "<td>" . $gateDistance . "</td>";
            } elseif (empty($gate)) {
                $gateDistance = $row['Dist_D'];
                echo "<td>" . $gateDistance . "</td>";
            }

            $photosSql = "SELECT Phot_Data FROM Photos WHERE Prop_ID = '$propID'";
            $photosResult = $mysqli->query($photosSql);

            if ($photosResult->num_rows > 0) {
                echo "<td>";
                
                $photos = [];
                while ($photoRow = $photosResult->fetch_assoc()) {
                    $photos[] = $photoRow["Phot_Data"];
                }
                
                $numPhotos = count($photos);
                $photosPerRow = 2; // Change this value to set the number of photos per row in the matrix
                $numRows = ceil($numPhotos / $photosPerRow);
                
                for ($row = 0; $row < $numRows; $row++) {
                    echo "<div style='display: flex;'>";
                    
                    for ($col = 0; $col < $photosPerRow; $col++) {
                        $index = $row * $photosPerRow + $col;
                        
                        if ($index < $numPhotos) {
                            $photoData = $photos[$index];
                            echo "<img src='$photoData' alt='Property Photo' class='enlarge-image' style='max-width: 200px; max-height: 200px; margin-right: 10px;' onclick='incrementPopularity($propID); enlargeImage(this)'>";
                        } else {
                            echo "<div style='width: 200px; height: 200px;'></div>";
                        }
                    }
                    
                    echo "</div>";
                }
                
                echo "</td>";
            } else {
                echo "<td>No photos available</td>";
            }

            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>0 results</td></tr>";
    }
    $mysqli->close();
    ?>
    </tbody>
</table>

</body>
</html>
