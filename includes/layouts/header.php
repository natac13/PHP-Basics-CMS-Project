<?php
    if (!isset($layout_context)) {
        $layout_context = "public";
    }
?>

<!DOCTYPE html>


<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Widgets">
    <meta name="viewpoint" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/public.css" media="all" type="text/css">
    <title>Widget Corp <?php if ($layout_context == "admin") {
            echo "Admin";
        } ?></title>
<body>
    <header>
        <h1><a href=<?php
        if ($layout_context == "admin") {
            echo "admin.php";
        } else {
            echo "index.php";
        } ?>>Widget Corp <?php if ($layout_context == "admin") {
            echo "Admin";
        } ?>
        </a></h1>
    </header>