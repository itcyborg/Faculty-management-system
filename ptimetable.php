<?php
/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 5/12/2017
 * Time: 11:36 AM
 */
session_start();
if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $file = fopen($_SERVER['DOCUMENT_ROOT'] . "/uploads/timetables/" . $name, 'r');
    $data = fread($file, filesize($_SERVER['DOCUMENT_ROOT'] . "/uploads/timetables/" . $name));
    fclose($file);
    echo $data;
}