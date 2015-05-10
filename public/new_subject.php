<?php require_once("../includes/sessions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<?php find_selected_page(); ?>


<div class="main">
    <nav>
        <?php echo navigation ($current_subject, $current_page)  ?>
    </nav>
    <div id="page">
        <?php echo message(); ?>
        <?php $errors = errors();  ?>
        <?php echo form_errors($errors); ?>
        <h2>Create Subject</h2>
        <form action="create_subject.php" method="post" accept-charset="utf-8">
            <p>Menu Name:<input type="text" name="menu_name" value=""></p>
            <p>Position:
                <select name="position">
                <?php
                //  so I find all the data from the database with my function
                //  then get the number of rows to have a max value for the for loop
                //  the for loop is going to make a bunch of option tags for the selection tag
                    $subject_set = find_all_subjects(false);
                    $subject_count = mysqli_num_rows($subject_set);
                    for ($count=1; $count <= ($subject_count + 1); $count++) {
                        echo "<option value=\"{$count}\">{$count}</option>";
                    }
                 ?>
                </select>
            </p>
            <p>Visible:
                <input type="radio" name="visible" value="0" placeholder="">No
                <input type="radio" name="visible" value="1">Yes
            </p>
            <input type="submit" name="submit" value="Create Subject">
        </form>
        <br>
        <a href="manage_content.php">Cancel</a>
    </div>
</div>


<?php include("../includes/layouts/footer.php"); ?>
