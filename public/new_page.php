<?php require_once("../includes/sessions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>



<?php find_selected_page(); ?>

<?php
    // Can't add a new page unless we have a subject as a parent!
    if (!$current_subject) {
        // subject ID was missing or invalid or subject not found in database
        redirect_to("manage_content.php");
    }
 ?>

<?php
if (isset($_POST["submit"])) {
    // process the form

    //  validations

    $required_fields = array("menu_name", "position", "visible", "content");
    validate_presences($required_fields);

    $fields_with_max_length = array("menu_name" => 30);
    validate_max_lengths($fields_with_max_length);

    if (empty($errors)) {
        // perform create

        $subject_id = $current_subject["id"];
        $menu_name = mysql_prep($_POST["menu_name"]);
        $position = (int) $_POST["position"];
        $visible = (int) $_POST["visible"];
        $content = mysql_prep($_POST["content"]);

        $query = "INSERT INTO pages (";
        $query .= " subject_id, menu_name, position, visible, content";
        $query .= ") VALUES (";
        $query .= " {$subject_id}, '{$menu_name}', {$position}, {$visible}, '{$content}' ";
        $query .= ")";
        $result = mysqli_query($db_connection, $query);

        if ($result) {
            $_SESSION["message"] = "Page created.";
            redirect_to("manage_content.php?subject=" . urlencode($current_subject["id"]));
        } else {
            $_SESSION["message"] = "Page creation failed. :( ";
        }
    }
} else {

}
?>




<?php include("../includes/layouts/header.php"); ?>

<div class="main">
    <nav>
        <?php echo navigation ($current_subject, $current_page)  ?>
    </nav>
    <div id="page">
        <?php echo message(); ?>
        <?php echo form_errors($errors); ?>
        <h2>Create Page</h2>
        <form action="new_page.php?subject=<?php echo urldecode($current_subject["id"]); ?>" method="post" accept-charset="utf-8">
            <p>Menu Name:<input type="text" name="menu_name" value=""></p>
            <p>Position:
                <select name="position">
                <?php
                //  so I find all the data from the database with my function
                //  then get the number of rows to have a max value for the for loop
                //  the for loop is going to make a bunch of option tags for the selection tag
                    $page_set = find_pages_for_subject($current_subject["id"]);
                    $page_count = mysqli_num_rows($page_set);
                    for ($count=1; $count <= ($page_count + 1); $count++) {
                        echo "<option value=\"{$count}\">{$count}</option>";
                    }
                 ?>
                </select>
            </p>
            <p>Visible:
                <input type="radio" name="visible" value="0" placeholder="">No
                <input type="radio" name="visible" value="1">Yes
            </p>
            <p>Content:</p><br>
            <textarea name="content" cols="80" rows="20"></textarea>
            <br>
            <input type="submit" name="submit" value="Create Page">
        </form>
        <br>
        <a href="manage_content.php?subject=<?php urlencode($current_subject["id"]); ?>">Cancel</a>
    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
