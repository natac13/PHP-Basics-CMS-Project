<?php require_once("../includes/sessions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php $layout_context = "public"; ?>
<?php include("../includes/layouts/header.php"); ?>

<?php find_selected_page(); ?>


<div class="main">
    <nav>
        <?php echo public_navigation ($current_subject, $current_page)  ?>
    </nav>
    <div id="page">
            <?php if ($current_subject) { ?>
                <h2>Manage Subject</h2>

                Menu Name: <?php echo htmlentities($current_subject["menu_name"]); ?><br>

            <?php } elseif ($current_page) { ?>

                    <?php echo htmlentities($current_page["content"]); ?>


            <?php } else { ?>

                Please select a subject or page.

            <?php } ?>


    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
