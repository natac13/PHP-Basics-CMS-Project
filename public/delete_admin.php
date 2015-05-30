<?php require_once("../includes/sessions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php
    $admin = find_admin_by_id($_GET['id']);

    if (!$admin) {
        // admin ID was missing
        // or admin was not found in database

        redirect_to("manage_admins.php");
    }

    $id = $admin["id"];

    $query = "DELETE FROM admins WHERE id = {$id} LIMIT 1";
    $result = mysqli_query($db_connection, $query);

    if ($result && mysqli_affected_rows($db_connection) == 1) {
        $_SESSION["message"] = "Admin deleted.";
        redirect_to("manage_admin.php");
    } else {
        $_SESSION["message"] = "Admin deletion failed. :( ";
        redirect_to("manage_admin.php");
    }
?>