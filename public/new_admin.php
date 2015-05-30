<?php require_once("../includes/sessions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php
// For single page processing of a form.
// I check to see if the submit button was pressed (meaning if has a value of
// true in the $_POST variable). By checking isset() determines if there is to
// be a mySQL query made
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

        $username = mysql_prep($_POST["username"]);
        $hashed_password = mysql_prep($_POST["password"]);

        $query = "INSERT INTO admins (";
        $query .= " username, hashed_password";
        $query .= ") VALUES (";
        $query .= " '{$username}', '{$hashed_password}'";
        $query .= ")";
        $result = mysqli_query($db_connection, $query);

        if ($result) {
            $_SESSION["message"] = "Admin Created";
            redirect_to("manage_admin.php");
        } else {
            $_SESSION["message"] = "Admin creation failure.";
        }

    }
} else {
    // GET request


} // end: (isset($_POST['submit']))
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
        <h2>Create Admin</h2>
        <form action="new_admin.php" method="post">
            <p>Username:
                <input type="text" name="username" value=""/>
            </p>
            <p>Password:
                <input type="password" name="password" value="" placeholder="">
            </p>
            <input type="submit" name="submit" value="Create Admin">
        </form>
        <br>
        <a href="manage_admin.php">Cancel</a>
    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>