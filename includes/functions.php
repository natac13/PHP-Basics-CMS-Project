<?php
    function redirect_to($new) {
        header("Location: " . $new);
        exit;
    }

    function mysql_prep($string) {
        global $db_connection;

        $escape_string = mysqli_real_escape_string($db_connection, $string);
        return $escape_string;
    }

    function confirm_query($result_set) {
        if (!$result_set) {
            die("Database query failed.");
        }
    }

   function form_errors($errors=array()) {
        $output = "";
        if (!empty($errors)) {
            $output .= "<div class=\"error\">";
            $output .= "Please fix the following errors:";
            $output .= "<ul>";
            foreach ($errors as $key => $error) {
                $output .= "<li>{$error}</li>";
            }
            $output .= "</ul>";
            $output .= "</div>";
        }
        return $output;
    }

    function find_all_subjects () {
        global $db_connection;

        $query = "SELECT * ";
        $query .= "FROM subjects ";
        // $query .= "WHERE visible = 1 ";
        $query .= "ORDER BY position ASC";

        $subject_set = mysqli_query($db_connection, $query);
        confirm_query($subject_set);
        return $subject_set;
    }

    function find_pages_for_subject ($subject_id) {
        global $db_connection;

        $safe_subject_id = mysqli_real_escape_string($db_connection, $subject_id);


        $query = "SELECT * ";
        $query .= "FROM pages ";
        $query .= "WHERE visible = 1 ";
        $query .= "AND subject_id = {$safe_subject_id} ";
        $query .= "ORDER BY position ASC";

        $page_set = mysqli_query($db_connection, $query);
        confirm_query($page_set);
        return $page_set;
    }

//  the nav function build up a string that it outputs at the end with the return
//  therefore all the html tag are strings appended to $output
//  and the php is just throughout the function
//  the 2 arguments are either an associative array with the column names for keys OR
//  it is null so I need to check for this
    function navigation ($subject_array, $page_array) {
             $output = "<ul class=\"subjects\">";

             $subject_set = find_all_subjects();
             while($subject = mysqli_fetch_assoc($subject_set)) {
             // this php is for only an <li> tag to either have a class of selected or not
             // but I use the php to output everything including the normal <li> tag
                 $output .= "<li";
                 if ($subject_array && $subject["id"] == $subject_array["id"]) {
                    $output .=  " class=\"selected\"";
                    }
                $output .=  ">" ;
                $output .= "<a href=\"manage_content.php?subject=";
                $output .=  urldecode($subject["id"]);
                $output .= "\">";
                $output .=  $subject["menu_name"];
                $output .= "</a>";

                $page_set = find_pages_for_subject($subject["id"]);
                $output .= "<ul class=\"pages\">";
                 while($page = mysqli_fetch_assoc($page_set)) {
                    $output .=  "<li";
                    if ($page_array && $page["id"] == $page_array["id"]) {
                        $output .=  " class=\"selected\"";
                    }
                    $output .=  ">" ;
                    $output .= "<a href=\"manage_content.php?page=";
                    $output .=  urldecode($page["id"]);
                    $output .= "\">";
                    $output .=  $page["menu_name"] ;
                    $output .= "</a></li>";
                }
                mysqli_free_result($page_set);
                $output .= "</ul> </li>";

            }
             mysqli_free_result($subject_set);
            $output .= "</ul>";
            return $output;
        }
//
// These two function are a very good template for reading back info from the database
// find whatever it is by id and the return the assoc array to assign to a variable
// then call each column name to get the info(from mysql)
//
        function find_subject_by_id($subject_id) {
            global $db_connection;

            $safe_subject_id = mysqli_real_escape_string($db_connection, $subject_id);

            $query = "SELECT * ";
            $query .= "FROM subjects ";
            $query .= "WHERE id = {$safe_subject_id} ";
            $query .= "LIMIT 1";

            $subject_set = mysqli_query($db_connection, $query);
            confirm_query($subject_set);
            if($subject = mysqli_fetch_assoc($subject_set)) {
                return $subject;
            }
            return null;
        }

        function find_page_by_id($page_id) {
            global $db_connection;

            $safe_page_id = mysqli_real_escape_string($db_connection, $page_id);

            $query = "SELECT * ";
            $query .= "FROM pages ";
            $query .= "WHERE id = {$safe_page_id} ";
            $query .= "LIMIT 1";

            $page_set = mysqli_query($db_connection, $query);
            confirm_query($page_set);
            if($page = mysqli_fetch_assoc($page_set)) {
                return $page;
            }
            return null;
        }

        function find_selected_page() {

            global $current_page;
            global $current_subject;

            if (isset($_GET["subject"])) {
                //  This is an associative array with all the database info
                $current_subject = find_subject_by_id($_GET["subject"]);
                $current_page = null;
            } elseif  (isset($_GET["page"])) {
                $current_subject = null;
                $current_page = find_page_by_id($_GET["page"]);
            } else{
            $current_page = null;
            $current_subject = null;
            }
        }
 ?>