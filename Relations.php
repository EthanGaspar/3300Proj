<?php
// Database connection information
$host = 'cssql.seattleu.edu';
$username = 'll_jroot';
$password = 'K8Y95EJit5TYp3N9';
$database = 'll_jroot';

// Connect to the database
$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if a table name was provided in the URL
if (isset($_GET['tableName'])) {
    $tableName = $_GET['tableName']; // Table name from the URL
    // Sanitize the table name to prevent SQL injection
    $tableName = mysqli_real_escape_string($conn, $tableName);

    // Query to select all rows from the specified table
    $query = "SELECT * FROM `$tableName`";
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
    <?php
    if ($result) {
        // Display the table contents
        echo "<h2>Table: " . htmlspecialchars(string: $tableName) . "</h2>";
        echo "<table class = 'styled-table' border='1' style='border-collapse: collapse; width: 100%; text-align: left;'>";
        echo "<tr>";

        // Display table headers
        $fields = mysqli_fetch_fields($result);
        foreach ($fields as $field) {
            echo "<th>" . htmlspecialchars($field->name) . "</th>";
        }
        echo "</tr>";

        // Display rows
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p style='color: red;'>Error executing query: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p style='color: red;'>No table specified.</p>";
}

// Close the database connection
mysqli_close($conn);
?>