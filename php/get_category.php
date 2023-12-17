

<?php
include 'connection.php'; 

$query = "SELECT department_name FROM departments";
$result = mysqli_query($con, $query);

if ($result) {

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['department_name'] . '">' . $row['department_name'] . '</option>';
    }
} else {
    echo '<option value="">Error retrieving options</option>';
}

// Close the database connection
mysqli_close($con);
?>
