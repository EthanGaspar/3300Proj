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

// Execute the query and check for errors
$query = "SELECT 
    Users.user_id AS user_user_id,
    Users.username AS user_username,
    Users.email AS user_email,
    Users.registration_date AS user_registration_date,
    Comments.comment_id AS comment_id,
    Comments.user_id AS comment_user_id,
    Comments.post_id AS comment_post_id,
    Comments.comment_date AS comment_date,
    Comments.comment_text AS comment_text 
    
    FROM Users INNER JOIN Comments 
    ON Users.user_id = Comments.user_id
    WHERE LOWER(Comments.comment_text) LIKE '%great%';";
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
    <h1>Query1 Results</h1>
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