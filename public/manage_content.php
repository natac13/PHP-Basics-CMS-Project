<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../includes/layouts/header.php"); ?>

<?php find_selected_page(); ?>


<div class="main">
    <nav>
        <?php echo navigation ($current_subject, $current_page)  ?>
        <a href="new_subject.php">+ Add a subject</a>
    </nav>
    <div id="page">
            <?php if ($current_subject) { ?>
                <h2>Manage Subject</h2>

                Menu Name: <?php echo $current_subject["menu_name"]; ?><br>

            <?php } elseif ($current_page) { ?>
                <h2>Manage Page</h2>

                Menu Name: <?php echo $current_page["menu_name"]; ?>

            <?php } else { ?>

                Please select a subject or page.

            <?php } ?>


    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
