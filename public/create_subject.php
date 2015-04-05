<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php
    if (isset($_POST['submit'])) {
        // process the form

        $menu_name = mysql_prep($_POST["menu_name"]);
        $position = (int) $_POST["position"];
        $visible = (int) $_POST["visible"];

        $query = "INSERT INTO subjects (";
        $query .= " menu_name, position, visible";
        $query .= ") VALUES (";
        $query .= " '{$menu_name}', {$position}, {$visible}";
        $query .= ")";
        $result = mysqli_query($db_connection, $query);

        if ($result) {
            redirect_to("manage_content.php");
        } else {
            redirect_to("new_subject.php");
        }

    } else {
        redirect_to("new_subject.php");
    }
 ?>


<?php
    if(isset($db_connection)) { mysqli_close($db_connection); }
?>