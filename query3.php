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

// Execute the query and check for errors
$query = "SELECT userName 
FROM Users 
WHERE user_id IN (
    SELECT user_id 
    FROM Projects 
    WHERE project_complete IS TRUE
);";
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
    <h1>Query3 Results</h1>
<?php
if ($result == TRUE){
    if (mysqli_num_rows($result) > 0) {
        // echo "<table border='1' style='border-collapse: collapse; width: 100%; text-align: left;'>";
        echo "<table class = 'styled-table'>";

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

}else{
    echo "<p style='color: red;'>Error executing query: " . mysqli_error($conn) . "</p>";
}

// Free the result set if it exists
if ($result instanceof mysqli_result) {
    mysqli_free_result($result);
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
