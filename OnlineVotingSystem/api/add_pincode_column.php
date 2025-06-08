<?php
include("connect.php");

$query = "ALTER TABLE users ADD COLUMN pincode VARCHAR(6) NOT NULL AFTER role";

if (mysqli_query($connect, $query)) {
    echo "Column 'pincode' added successfully.";
} else {
    echo "Error adding column 'pincode': " . mysqli_error($connect);
}

mysqli_close($connect);
?>
