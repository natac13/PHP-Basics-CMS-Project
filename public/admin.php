<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/sessions.php"); ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<div class="main">
    <nav>
        &nbsp;
    </nav>
    <div id="page">
        <h2>Admin Menu</h2>
        <p>Welcome to the admin area, <?php echo htmlentities($_SESSION["username"]); ?></p>
        <ul>
            <li><a href="manage_content.php">Manage Website Content</a></li>
            <li><a href="manage_admin.php">Manage Admin Users</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</div>
   <?php include("../includes/layouts/footer.php"); ?>

