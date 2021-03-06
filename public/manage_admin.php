<?php require_once("../includes/sessions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php
    $admin_set = find_all_admins();
?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<div class="main" id="main">
    <nav>
        &nbsp;
    </nav>
    <div id="page">
        <?php echo message(); ?>
        <h2>Manage Admins</h2>
        <table>
            <tr>
                <th style="text-align: left; width=200px; ">Username</th>
                <th colspan="2" style="text-align: left;">Actions</th>
            </tr>
            <!-- This while loop is going to continue as long as the variable
            $admin can be set to something pulled out of the assoc array that
            was fetched -->
            <?php while($admin = mysqli_fetch_assoc($admin_set)) { ?>
            <tr>
                <td><?php echo htmlentities($admin['username']); ?></td>
                    <td><a href="edit_admin.php?id=<?php echo
                    urlencode($admin["id"]); ?>">Edit</a></td>
                    <td><a href="delete_admin.php?id=<?php echo
                    urlencode($admin["id"]); ?>" onclick="return confirm('Are
                    you SURE?');">Delete</a></td>
            </tr>
            <?php } ?>
        </table>
        <br>
        <a href="new_admin.php">Add New Admin</a>

    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>