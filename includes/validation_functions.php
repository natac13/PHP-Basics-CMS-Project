<?php

$errors = array();

    function fieldname_as_text($fieldname) {
        $fieldname = str_replace("_", " ", $fieldname);
        $fieldname = ucfirst($fieldname);
        return $fieldname;
    }

// has to be set and is not an empty string exactally
// the $vlaue being passed in need to be trim()

    function has_presence($value) {
        $value = trim($value);
        return isset($value) && $value !== "";
    }

    function validate_presences($array) {
        global $errors;
        foreach ($array as $field) {
            $value = trim($_POST[$field]);
            if (!has_presence($value)) {
                $errors[$field] = fieldname_as_text($field) . " can't be blank";
            }
        }
    }
// has to be equal to or less than a $man amount
    function has_max_length($value, $max) {
        return strlen($value) <= $max;
    }

     function validate_max_lengths($fields_with_max_length) {
    // arug: is a assoc. array (dict, from python)
        global $errors;
        foreach($fields_with_max_length as $field => $max) {
            $value = trim($_POST[$field]);
            if (!has_max_length($value, $max)) {
                $errors[$field] = fieldname_as_text($field) . " is too long";
            }
        }
    }

// has to be within a given list which I would pass in
    function has_inclusion_in($value, $set) {
        return in_array($value, $set);
    }



?>
