<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Laboratory Information Indexing System
 *
 * An open source mini LIMS for metadata organisation and archival purposes
 *
 * @author      Matt Forster / @frostyforster
 * @copyright   Copyright (c) 2013, Matthew S. Forster
 * @license     MIT (./license.txt)
 * @link        http://github.com/forstermatth/liis
 * @since       Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * LIIS Helper
 *
 * Holds misc. helper functions used throughout the LIIS source code
 *
 * @category    LIIS-Helper
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */

/**
* createArray
*
* Creates an array from a string and removes any blank elements
* 
* @access   public   
* @param    post      string     The string to be exploded
* @return   array created from the string
*/
function createArray($post)
{
    $temp = trim($post);
    $temp = explode(' ', $temp);
    for ($i = 0; $i < sizeof($temp); $i++) {
        if ($temp[$i] == "") {
            unset($temp[$i]);
        } //$temp[$i] == ""
    } //$i = 0; $i < sizeof($temp); $i++
    return $temp;
}

/**
* createNulls
*
* Recursive function that walks through an array and replaces blank strings with nulls
* 
* @access   public   
* @param    &array      array     The array to be modified
* @return   
*/
function createNulls(&$array)
{
    foreach ($array as &$element) {
        if (is_array($element)) {
            createNulls($element);
        } //is_array($element)
        if (empty($element) || ($element == ' ')) {
            $element = NULL;
        } //empty($element)
    } //$array as &$element
    unset($element);
}

/**
* remove_empty_arrays
*
* Walks through an array and removes any child array elements that are empty. Will not
* remove if one or more elements are populated inside an array.
* 
* @access   public   
* @param    array      array     The array to be modified
* @return   modified array
*/
function remove_empty_arrays($array)
{
    foreach ($array as $key => &$value) {
        if (is_array($value)) {
            if (isEmpty($value)) {
                unset($array[$key]);
            } //isEmpty($value)
        } //is_array($value)
    } //$array as $key => &$value
    unset($value);
    return $array;
}

/**
* isEmpty
*
* Tests a single array to see if it is completely empty
* 
* @access   public   
* @param    array      array     The array to be tested
* @return   TRUE if array is completely empty, FALSE if not.
*/
function isEmpty($array)
{
    foreach ($array as $key => $value) {
        if ($key == 'DNARNA_TYPE')
            continue; //special case - type is always set
        if (!empty($value)) {
            return FALSE;
        } //empty($value)
    } //$array as $key => $value
    return TRUE;
}

/**
* checkDuplicates
*
* Checks an array for duplicate entries
* 
* @access   public   
* @param    array      array     The array to be tested
* @return   FALSE if no duplicates, TRUE if duplicates present
*/
function checkDuplicates($array)
{
    return count($array) !== count(array_unique($array));
}

/**
* setMessage
*
* Pushes an array to the array passed. keys: 'Message' and 'Type'
* For use with the message view 'application/views/templates/mesage.php'
* 
* @access   public   
* @param    message     string     the message to be pushed
* @param    type        string     the type of message (error, warning, success)
* @param    &array      array      the array the message should be pushed to
* @return
*/
function setMessage($message, $type, &$array)
{
    array_push($array, array(
        'Message' => $message,
        'Type' => $type
    ));
}

/**
* requiredError
*
* Prints an error message if field does not equal expected
* 
* @access   public   
* @param    field       string     The string to be tested
* @param    expected    string     The expected string
* @return   false if not equal, true if equal
*/
function requiredError($field, $expected)
{
    if ($field != $expected) {
        echo '<br><span class="error">  error: field "' . $field . '" incorrect! expected: "' . $expected . '"</span>';
        return FALSE;
    } //$field != $expected
    return TRUE;
}