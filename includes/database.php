<?php

$Connection = mysqli_connect('localhost', 'root', '', 'social');

if(!$Connection) {
    die('Database connection failed');
};

$Database = mysqli_select_db($Connection, 'social');

if(!$Database) {
    die('Database selection failed: ' . mysqli_connect_error($Connection));
};

?>