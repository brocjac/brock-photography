<?php
// example of the docblock for better hints when writing code
/**
 * Function to get values from a GET or POST form
 * @author Jacob Brockwell
 *
 * @param string $name The name of the form input
 * @param mixed $default The default value if the input doesn't exist
 * @return mixed|string The value from the form (or the default)
 */
function formVal($name, $default = ''){
    // check the form for POST
    if(isset($_POST[$name])){
        $value = $_POST[$name];
    // check the form for GET
    } else if (isset($_GET[$name])){
        $value = $_GET[$name];
    // not in GET or POST, use the default
    } else {
        $value = $default;
    }
    return $value;
    // return exists the function
    // $value = 1; // will not run
}