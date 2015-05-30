<?php require_once("../includes/sessions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php
    $admin = find_admin_by_id($_GET['id']);

    if (!$admin) {
        // admin ID was missing
        // or admin was not found in database

        redirect_to("manage_admins.php");
    }
?>
<?php
if (isset($_POST['submit'])) {
    // Process the form

    $required_fields = array('username', 'password');
    validate_presences($required_fields);

    $fields_with_max_length = array("username" => 30);
    validate_max_lengths($fields_with_max_length);

    // $errors is an assoc array that is made with validate functions to
    // display whatever is wrong during the process
    if (empty($errors)) {
        // No errors found therefore continue

        $id = $admin["id"];
        $username = mysql_prep($_POST["username"]);
        $hashed_password = mysql_prep($_POST["password"]);

        $query = "UPDATE admins SET ";
        $query .= "username = '{$username}', ";
        $query .= "hashed_password = {$hashed_password}, ";
        $query .= "WHERE id = {$id} ";
        $query .= "LIMIT 1";
        $result = mysqli_query($db_connection, $query);

        if ($result && mysqli_affected_rows($db_connection) == 1) {
            $_SESSION["message"] = "Admin updated.";
            redirect_to("manage_admins.php");
        } else {
            $_SESSION["mesages"] = "Admin update failure.";
        }
    }
} else {
    // GET request
}
?>

<?php $layout_content = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<div id="main">
    <div id="navigation">
        &nbsp;
    </div>
    <div id="page">
        <?php echo message(); ?>
        <?php echo form_errors($errors); ?>
        <h2>Edit Admin <?php echo htmlentities($admin["username"]); ?></h2>
        <form action="edit_admin.php?id=<?php echo
        urlencode($admin["id"]); ?>" method="post">
            <p>Username:
                <input type="text" name="username" value="<?php echo
                htmlentities($admin["username"]); ?>"/>
            </p>
            <p>Password:
                <input type="password" name="password" value="" placeholder="">
            </p>
            <input type="submit" name="submit" value="Edit Admin">
        </form>
        <br>
        <a href="manage_admin.php">Cancel</a>
    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>