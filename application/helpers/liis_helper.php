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

function createNulls(&$array)
{
    foreach ($array as &$element) {
        if (is_array($element)) {
            createNulls($element);
        } //is_array($element)
        if (empty($element)) {
            $element = NULL;
        } //empty($element)
    } //$array as &$element
    unset($element);
}

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

function isEmpty($array)
{
    $empty = true;
    foreach ($array as $key => $value) {
        if ($key == 'DNARNA_TYPE')
            continue; //special case - type is always set
        if (!empty($value)) {
            $empty = false;
        } //!empty($value)
    } //$array as $key => $value
    return $empty;
}

function checkDuplicates($array)
{
    return count($array) !== count(array_unique($array));
}

function setMessage($message, $type, &$array)
{
    array_push($array, array(
        'Message' => $message,
        'Type' => $type
    ));
}

function requiredError($field, $expected)
{
    if ($field != $expected) {
        echo '<br><span class="error">  error: field "' . $field . '" incorrect! expected: "' . $expected . '"</span>';
        return FALSE;
    } //$field != $expected
    return TRUE;
}