<?php require_once("../includes/sessions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>


<?php
    if (isset($_POST['submit'])) {
        // process the form

        $menu_name = mysql_prep($_POST["menu_name"]);
        $position = (int) $_POST["position"];
        $visible = (int) $_POST["visible"];

        //  validations

        $required_fields = array("menu_name", "position", "visible");
        validate_presences($required_fields);

        $fields_with_max_length = array("menu_name" => 30);
        validate_max_lengths($fields_with_max_length);

        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            redirect_to("new_subject.php");
        }

        $query = "INSERT INTO subjects (";
        $query .= " menu_name, position, visible";
        $query .= ") VALUES (";
        $query .= " '{$menu_name}', {$position}, {$visible}";
        $query .= ")";
        $result = mysqli_query($db_connection, $query);

        if ($result) {
            $_SESSION["message"] = "Subject created.";
            redirect_to("manage_content.php");
        } else {
            $_SESSION["message"] = "Subject creation failed. :( ";
            redirect_to("new_subject.php");
        }

    } else {
        redirect_to("new_subject.php");
    }
 ?>


<?php
    if(isset($db_connection)) { mysqli_close($db_connection); }
?>