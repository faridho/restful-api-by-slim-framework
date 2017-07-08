<?php
/**
 * Created by Faridho.
 * User: pc
 * Date: 6/20/2017
 * Time: 9:38 PM
 */
function getDB() {
    $dbhost="localhost";
    $dbuser="root";
    $dbpass="";
    $dbname="db_movie";
    $dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbConnection;
}