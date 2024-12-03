<?php
// Database connection information
$host = 'cssql.seattleu.edu';
$username = 'll_jroot';
$password = 'K8Y95EJit5TYp3N9';
$database = 'll_jroot';

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
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Query Results</title>
        <link rel="stylesheet" href="styles.css"> <!-- Link to CSS file -->
    </head>
    <body>
    <?php
    if ($result === FALSE) {
        echo "<h1> Ad Hoc Query Error </h1>";
        echo "<p style='color: red;'>Error executing query: " . mysqli_error($conn) . "</p>";
    } else {
        // Display results in a table if the query returns data
        echo "<h1> Ad Hoc Query: '" .htmlspecialchars($query) . "' Result</h1>";
        echo "<p style = 'text-align: center'>Ambigous Column names highlighted in <span style='color: red'>RED</span> (CAN CAUSE ISSUES)</p>";


        if (mysqli_num_rows($result) > 0) {
            $headers = [];
            // echo "<table border='1' style='border-collapse: collapse; width: 100%; text-align: left;'>";
            echo "<table class = 'styled-table'>";
            echo "<tr>";

            // Fetch and display table headers
            $fields = mysqli_fetch_fields($result);
            foreach ($fields as $field) {
                $column_name = $field->name;
                if (in_array($column_name, $headers)) {
                    echo "<th style='color: red;'>" . htmlspecialchars($column_name) . " (Ambiguous)</th>";
                } else {
                    echo "<th>" . htmlspecialchars($column_name) . "</th>";
                    $headers[] = $column_name;
                }            }
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
<div class ="back_Button">
    <p><a class = "back_Button" href="project.html">Back to Query Form</a></p>
</div>
</body>
</html>