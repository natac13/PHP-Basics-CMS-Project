<?php require_once("../includes/sessions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php
// For single page processing of a form.
// I check to see if the submit button was pressed (meaning if has a value of
// true in the $_POST variable). By checking isset() determines if there is to
// be a mySQL query made
$username = "";
if (isset($_POST['submit'])) {
    // Process the form

    $required_fields = array('username', 'password');
    validate_presences($required_fields);

    // $errors is an assoc array that is made with validate functions to
    // display whatever is wrong during the process
    if (empty($errors)) {
        // No errors found therefore continue

        $username = $_POST["username"];
        $password = $_POST["password"];
        $found_admin = attempt_login($username, $password);

        if ($found_admin) {
            // $_SESSION["message"] = "Welcome to the admin pages";
            // mark as logged in
            $_SESSION["admin_id"] = $found_admin["id"];
            $_SESSION["username"] = $found_admin["username"];
            // can use user name in place like the header to greet them
            // or just to remember them for a great UI experience! This is
            // so I do not have to keep querying to get the username from
            // the database.
            redirect_to("admin.php");
        } else {
            $_SESSION["message"] = "Username/password not found.";
        }

    }
} else {
    // GET request


} // end: (isset($_POST['submit']))
?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<div class="main" id="main">
    <nav>
        &nbsp;
    </nav>
    <div id="page">
        <?php echo message(); ?>
        <?php echo form_errors($errors); ?>
        <h2>Login</h2>
        <form action="login.php" method="post">
            <p>Username:
                <input type="text" name="username" value="<?php echo
                htmlentities($username); ?>"/>
            </p>
            <p>Password:
                <input type="password" name="password" value="" placeholder="">
            </p>
            <input type="submit" name="submit" value="Submit">
        </form>
        <br>
        <a href="manage_admin.php">Cancel</a>
    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>