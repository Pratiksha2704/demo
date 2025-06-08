<?php
session_start();
include('connect.php');

$votes = $_POST['gvotes'];
$total_votes = $votes + 1;  // Calculate total votes
$gid = $_POST['gid'];
$uid = $_SESSION['userdata']['id'];

// Update the vote count for the group
$update_votes = mysqli_query($connect, "UPDATE users SET votes='$total_votes' WHERE id='$gid'");

// Update the user's status to indicate they have voted
$update_users_status = mysqli_query($connect, "UPDATE users SET status=1 WHERE id='$uid'");

if ($update_votes && $update_users_status) {
    // Retrieve the list of groups
    $groups = mysqli_query($connect, "SELECT * FROM users WHERE role=2");
    $groupsdata = mysqli_fetch_all($groups, MYSQLI_ASSOC);

    // Update session data
    $_SESSION['userdata']['status'] = 1;
    $_SESSION['groupsdata'] = $groupsdata;

    // Redirect to dashboard with success message
    echo '
    <script>
        alert("Voting is successful!");
        window.location = "../routes/dashboard.php";
    </script>
    ';
} else {
    // Redirect to dashboard with error message
    echo '
    <script>
        alert("Some error occurred!");
        window.location = "../routes/dashboard.php";
    </script>
    ';
}
?>
