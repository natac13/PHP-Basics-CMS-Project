<?php require_once("../includes/sessions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>


<?php find_selected_page(); ?>

<?php
    if (!$current_subject) {
        //  subject ID was missing or invalid or
        //  subject couldn't be found in database
        redirect_to("manage_content.php");
    }
 ?>

<?php
    if (isset($_POST['submit'])) {
        // process the form


        //  validations

        $required_fields = array("menu_name", "position", "visible");
        validate_presences($required_fields);

        $fields_with_max_length = array("menu_name" => 30);
        validate_max_lengths($fields_with_max_length);

        if (empty($errors)) {
            // Perform Update if errors are empty

            $id = $current_subject["id"];
            $menu_name = mysql_prep($_POST["menu_name"]);
            $position = (int) $_POST["position"];
            $visible = (int) $_POST["visible"];


            $query = "UPDATE subjects SET ";
            $query .= "menu_name = '{$menu_name}', ";
            $query .= "position = {$position}, ";
            $query .= "visible = {$visible} ";
            $query .= "WHERE id = {$id} ";
            $query .= "LIMIT 1";
            $result = mysqli_query($db_connection, $query);

            if ($result && mysqli_affected_rows($db_connection) >= 0) {
                $_SESSION["message"] = "Subject updated.";
                redirect_to("manage_content.php");
            } else {
                $message = "Subject update failed. :( ";
            }

        }
    } else {
        // This was a GET request then
    } // end: if (isset($_POST['submit']))
 ?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>



<div class="main">
    <nav>
        <?php echo navigation ($current_subject, $current_page)  ?>
    </nav>
    <div id="page">
        <?php
            //  $message is just a variable, doesn't use the SESSION
            if (!empty($message)) {
                echo "<div class=\"message\">" . htmlentities($message) . "</div>";
            }
         ?>
        <?php echo form_errors($errors); ?>
        <h2>Edit Subject: <?php echo htmlentities($current_subject["menu_name"]); ?></h2>
        <form action="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" method="post" accept-charset="utf-8">
            <p>Menu Name:<input type="text" name="menu_name" value="<?php echo htmlentities($current_subject["menu_name"]); ?>"></p>
            <p>Position:
                <select name="position">
                <?php
                //  so I find all the data from the database with my function
                //  then get the number of rows to have a max value for the for loop
                //  the for loop is going to make a bunch of option tags for the selection tag
                    $subject_set = find_all_subjects(false);
                    $subject_count = mysqli_num_rows($subject_set);
                    for ($count=1; $count <= ($subject_count); $count++) {

                        echo "<option value=\"{$count}\"";
                        if ($current_subject["position"] == $count) {
                            echo " selected";
                        }
                        echo ">{$count}</option>";
                    }
                 ?>
                </select>
            </p>
            <p>Visible:
                <input type="radio" name="visible" value="0" <?php if ($current_subject["visible"] == 0) { echo "checked"; } ?>>No
                <input type="radio" name="visible" value="1" <?php if ($current_subject["visible"] == 1) { echo "checked"; } ?>>Yes
            </p>
            <input type="submit" name="submit" value="Edit Subject">
        </form>
        <br>
        <a href="manage_content.php">Cancel</a>
        &nbsp;
        &nbsp;
        <a href="delete_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" onclick="return confirm('Are you sure?');">Delete Subject</a>

    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
