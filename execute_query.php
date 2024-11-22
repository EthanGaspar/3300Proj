<?php
// Database connection information
$host = 'cssql.seattleu.edu';
$username = 'll_jwong9';
$password = '1fr1MPjwULlkkUBo';
$database = 'll_jwong9';

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if a query was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['query'])) {
    $query = $_POST['query'];

    // Execute the query and check for errors
    $result = mysqli_query($conn, $query);

    if ($result === FALSE) {
        echo "<p style='color: red;'>Error executing query: " . mysqli_error($conn) . "</p>";
    } else {
        // Display results in a table if the query returns data
        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1' style='border-collapse: collapse; width: 100%; text-align: left;'>";
            echo "<tr>";

            // Fetch and display table headers
            $fields = mysqli_fetch_fields($result);
            foreach ($fields as $field) {
                echo "<th>" . htmlspecialchars($field->name) . "</th>";
            }
            echo "</tr>";

            // Fetch and display each row of data
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No results found.</p>";
        }
    }

    // Free the result set if it exists
    if ($result instanceof mysqli_result) {
        mysqli_free_result($result);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!-- Link back to the query form -->
<p><a href="project.html">Back to Query Form</a></p>
