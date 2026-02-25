<?php 
include dirname(__FILE__).'/../config/config.php';

$con = mysqli_connect($config['db']['server'], $config['db']['username'], $config['db']['password'], $config['db']['database']);
#$con = mysqli_connect($config['db']['server'],$config['db']['username'],$config['db']['password']);
#mysqli_select_db($config['db']['database'],$con);
 
?>


