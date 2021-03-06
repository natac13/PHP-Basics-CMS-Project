<?php
// $errors: an assoc array that will hold the messages
// The associavtive part shows up in the validate functions when it builds
// the array.
$errors = array();

    function fieldname_as_text($fieldname) {
        $fieldname = str_replace("_", " ", $fieldname);
        $fieldname = ucfirst($fieldname);
        return $fieldname;
    }

// has to be set and is not an empty string exactly
// the $value being passed in need to be trim()

    function has_presence($input_text) {
        $input_text = trim($input_text);
        return isset($input_text) && $input_text !== "";
    }

    function validate_presences($input_text) {
        global $errors;
        foreach ($input_text as $field) {
            // $value = trim($_POST[$field]);
            if (!has_presence($_POST[$field])) {
                $errors[$field] = fieldname_as_text($field) . " can't be blank";
            }
        }
    }

    // has to be equal to or less than a $man amount

    function has_max_length($input_text, $max) {
         return strlen($input_text) <= $max;
    }

    function validate_max_lengths($fields_with_max_length) {
    // variable: is a assoc. array (dict, from python)
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
