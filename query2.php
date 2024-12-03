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
u.username,
COUNT(p.post_id) AS total_posts
FROM 
Users u
JOIN 
Post p ON u.user_id = p.user_id
GROUP BY 
u.username;";
$result = mysqli_query($conn, $query);

if ($result == TRUE){
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
<p><a href="project.html">Back to Query Form</a></p>
