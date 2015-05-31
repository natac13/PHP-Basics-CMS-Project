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
               $output .= "<li>";
               $output .= htmlentities($error);
               $output .= "</li>";
           }
           $output .= "</ul>";
           $output .= "</div>";
        }
        return $output;
    }

    function find_all_subjects ($public=true) {
        global $db_connection;

        $query = "SELECT * ";
        $query .= "FROM subjects ";
        if ($public) {
            $query .= "WHERE visible = 1 ";
        }
        $query .= "ORDER BY position ASC";

        $subject_set = mysqli_query($db_connection, $query);
        confirm_query($subject_set);
        return $subject_set;
    }

    function find_pages_for_subject ($subject_id, $public=true) {
        global $db_connection;

        $safe_subject_id = mysqli_real_escape_string($db_connection,
            $subject_id);


        $query = "SELECT * ";
        $query .= "FROM pages ";
        $query .= "WHERE subject_id = {$safe_subject_id} ";
        if ($public) {
            $query .= "AND visible = 1 ";
        }

        $query .= "ORDER BY position ASC";

        $page_set = mysqli_query($db_connection, $query);
        confirm_query($page_set);
        return $page_set;
    }

    function find_all_admins() {
        global $db_connection;

        $query = "SELECT * ";
        $query  .= "FROM admins ";
        $query .= "ORDER BY username ASC";
        $admin_set = mysqli_query($db_connection, $query);
        confirm_query($admin_set);
        return $admin_set;
    }

    function find_admin_by_id($admin_id) {
        global $db_connection;

        $safe_admin_id = mysqli_real_escape_string($db_connection, $admin_id);

        $query = "SELECT * ";
        $query .= "FROM admins ";
        $query .= "WHERE id = {$safe_admin_id} ";
        $query .= "LIMIT 1";
        // The set is all date in this case just 1 entry
        $admin_set = mysqli_query($db_connection, $query);
        confirm_query($admin_set);
        if($admin = mysqli_fetch_assoc($admin_set)) {
            return $admin;
        } else {
            return null;
        }
    }

    function find_admin_by_username($username) {
        global $db_connection;

        $safe_username = mysqli_real_escape_string($db_connection, $username);

        $query = "SELECT * ";
        $query .= "FROM admins ";
        $query .= "WHERE username = '{$safe_username}' ";
        $query .= "LIMIT 1";
        // The set is all date in this case just 1 entry
        $admin_set = mysqli_query($db_connection, $query);
        confirm_query($admin_set);
        if($admin = mysqli_fetch_assoc($admin_set)) {
            return $admin;
        } else {
            return null;
        }
    }
// the nav function build up a string that it outputs at the end with
// the return therefore all the html tag are strings appended to $output
// and the php is just throughout the function
// the 2 arguments are either an associative array with the column names
// for keys OR it is null so I need to check for this
    function navigation ($subject_array, $page_array) {
        $output = "<ul class=\"subjects\">";

        $subject_set = find_all_subjects(false);
        while($subject = mysqli_fetch_assoc($subject_set)) {
        // this php is for only an <li> tag to either have a class of selected
        // or not but I use the php to output everything including the normal
        // <li> tag
            $output .= "<li";
            if ($subject_array && $subject["id"] == $subject_array["id"]) {
                $output .=  " class=\"selected\"";
            }
            $output .=  ">" ;
            $output .= "<a href=\"manage_content.php?subject=";
            $output .=  urldecode($subject["id"]);
            $output .= "\">";
            $output .=  htmlentities($subject["menu_name"]);
            $output .= "</a>";

            $page_set = find_pages_for_subject($subject["id"], false);
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
                $output .=  htmlentities($page["menu_name"]);
                $output .= "</a></li>";
                }
                mysqli_free_result($page_set);
                $output .= "</ul> </li>";

        } // end: while($subject = mysqli_fetch_assoc($subject_set))
        mysqli_free_result($subject_set);
        $output .= "</ul>";
        return $output;
    }

    function public_navigation ($subject_array, $page_array) {
        $output = "<ul class=\"subjects\">";

        $subject_set = find_all_subjects();
        while($subject = mysqli_fetch_assoc($subject_set)) {
        // this php is for only an <li> tag to either have a class of selected
        // or not but I use the php to output everything including the normal
        // <li> tag
            $output .= "<li";
            if ($subject_array && $subject["id"] == $subject_array["id"]) {
                $output .=  " class=\"selected\"";
            }
            $output .=  ">" ;
            $output .= "<a href=\"index.php?subject=";
            $output .=  urldecode($subject["id"]);
            $output .= "\">";
            $output .=  htmlentities($subject["menu_name"]);
            $output .= "</a>";


            if ($subject_array["id"]  == $subject["id"] ||
                $page_array["subject_id"] == $subject["id"]) {
                $page_set = find_pages_for_subject($subject["id"]);
                $output .= "<ul class=\"pages\">";
                while($page = mysqli_fetch_assoc($page_set)) {
                $output .=  "<li";
                if ($page_array && $page["id"] == $page_array["id"]) {
                    $output .=  " class=\"selected\"";
                }
                $output .=  ">" ;
                $output .= "<a href=\"index.php?page=";
                $output .=  urldecode($page["id"]);
                $output .= "\">";
                $output .=  htmlentities($page["menu_name"]);
                $output .= "</a></li>";
                }
            $output .= "</ul>";
            mysqli_free_result($page_set);
            }


            $output .= "</li>"; // end of subject <li>

        }
        mysqli_free_result($subject_set);
        $output .= "</ul>";
        return $output;
    }
// These two function are a very good template for reading back info from the database
// find whatever it is by id and the return the assoc array to assign to a variable
// then call each column name to get the info(from mysql)



    function find_subject_by_id($subject_id, $public=true) {
        global $db_connection;

        $safe_subject_id = mysqli_real_escape_string($db_connection,
            $subject_id);

        $query = "SELECT * ";
        $query .= "FROM subjects ";
        $query .= "WHERE id = {$safe_subject_id} ";
        if ($public) {
            $query .= "AND visible = 1 ";
        }
        $query .= "LIMIT 1";

        $subject_set = mysqli_query($db_connection, $query);
        confirm_query($subject_set);
        if($subject = mysqli_fetch_assoc($subject_set)) {
            return $subject;
        }
        return null;
    }

    function find_page_by_id($page_id, $public=true) {
        global $db_connection;

        $safe_page_id = mysqli_real_escape_string($db_connection, $page_id);

        $query = "SELECT * ";
        $query .= "FROM pages ";
        $query .= "WHERE id = {$safe_page_id} ";
        if ($public) {
            $query .= "AND visible = 1 ";
        }
        $query .= "LIMIT 1";

        $page_set = mysqli_query($db_connection, $query);
        confirm_query($page_set);
        if($page = mysqli_fetch_assoc($page_set)) {
            return $page;
        }
        return null;
    }

    function find_default_page_for_subject($subject_id) {
        $page_set = find_pages_for_subject($subject_id);
        if($first_page = mysqli_fetch_assoc($page_set)) {
            return $first_page;
        }
        return null;
    }


    function find_selected_page($public=false) {
        global $current_page;
        global $current_subject;

        if (isset($_GET["subject"])) {
            //  This is an associative array with all the database info
            $current_subject = find_subject_by_id($_GET["subject"], $public);
            if ($current_subject && $public) {
                $current_page = find_default_page_for_subject(
                    $current_subject["id"]);
            } else {
                $current_page = null;
            }

        } elseif  (isset($_GET["page"])) {
            $current_subject = null;
            $current_page = find_page_by_id($_GET["page"], $public);
        } else{
            $current_page = null;
            $current_subject = null;
        }
    }

    function password_encrypt($password) {
        $hash_format = "$2y$10$"; // tell php to use blowfish with cost of 10
        $salt_lenght = 22; // what blowfish expects to see everytime

        $salt = generate_salt($salt_lenght);
        $format_and_salt = $hash_format . $salt;
        $hash = crypt($password, $format_and_salt);
        return $hash;
    }

    function generate_salt($length) {
        // Not 100% random or unique but good enough for salt.
        // MD5 returns 32 characters
        $unique_random_string = md5(uniqid(mt_rand(), true));

        // Valid characters for a salt are [a-z A-Z 0-9 ./]
        $base64_string = base64_encode($unique_random_string);
        // base 64 return + instead of . so i have to fix this on next line

        // But not '+' which is valid in base 64 encoding
        $modified_base64_string = str_replace('+', '.', $base64_string);

        // Truncate string to the correct length
        $salt = substr($modified_base64_string, 0, $length);

        return $salt;
    }

    function password_check ($password, $existing_hash) {
        // existing hash contains format and salt at start
        // able to use the entire existing hash since the function will only
        // take the first 22 character of the second argument and prefix it
        // to the hashed password. Therefore the first 22 character are the
        // same on the hashed versions and off
        // pulls the format_and_salt which is at beginning of the existing_hash
        $hash = crypt($password, $existing_hash);
        if ($hash === $existing_hash) {
            return true;
        }else {
            return false;
        }
    }

    function attempt_login ($username, $password) {
        $admin = find_admin_by_username($username);

        if ($admin) {
            // found admin in database
            if (password_check($password, $admin["hashed_password"])) {
                // password matches
                return $admin;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
?>