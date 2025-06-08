
<?php
include("connect.php");

$name = $_POST['name'];
$mobile = $_POST['mobile'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$address = $_POST['address'];
$image = $_FILES['photo']['name'];
$tmp_name = $_FILES['photo']['tmp_name'];
$role = $_POST['role'];
$pincode = $_POST['pincode'];

if ($password == $cpassword) {
    // Ensure the destination directory exists
    $upload_directory = "../uploads/";
    if (!is_dir($upload_directory)) {
        mkdir($upload_directory, 0777, true);
    }

    // Move uploaded file to destination directory
    $target_path = $upload_directory . basename($image);

    // Check for file upload errors
    if (move_uploaded_file($tmp_name, $target_path)) {
        // Validate the pin code
        $escaped_pincode = mysqli_real_escape_string($connect, $pincode);
        $pincode_query = "SELECT * FROM pincodes WHERE pincode = '$escaped_pincode'";
        $pincode_result = mysqli_query($connect, $pincode_query);

        // Check if the query failed and output the error
        if (!$pincode_result) {
            die("Database query failed: " . mysqli_error($connect));
        }

        if (mysqli_num_rows($pincode_result) > 0) {
            // Use mysqli_real_escape_string to prevent SQL injection
            $escaped_name = mysqli_real_escape_string($connect, $name);
            $escaped_mobile = mysqli_real_escape_string($connect, $mobile);
            $escaped_password = mysqli_real_escape_string($connect, $password);
            $escaped_address = mysqli_real_escape_string($connect, $address);
            $escaped_role = mysqli_real_escape_string($connect, $role);

            // Insert data into the database
            $insert = mysqli_query($connect, "INSERT INTO users (name, mobile, password, address, photo, role, pincode, status, votes) VALUES ('$escaped_name', '$escaped_mobile', '$escaped_password', '$escaped_address', '$image', '$escaped_role', '$escaped_pincode', 0, 0)");

            // Check for database query errors
            if ($insert) {
                echo '
                    <script>
                        alert("Registration Successful!");
                        window.location = "../";
                    </script>';
            } else {
                echo '
                    <script>
                        alert("Database Error: ' . mysqli_error($connect) . '");
                        window.location = "../routes/register.html";
                    </script>';
            }
        } else {
            echo '
                <script>
                    alert("Invalid Pin Code!");
                    window.location = "../routes/register.html";
                </script>';
        }
    } else {
        echo '
            <script>
                alert("File upload failed with error code ' . $_FILES['photo']['error'] . '");
                window.location = "../routes/register.html";
            </script>';
    }
} else {
    echo '
        <script>
            alert("Password and confirm password do not match!");
            window.location = "../routes/register.html";
        </script>';
}
?>
