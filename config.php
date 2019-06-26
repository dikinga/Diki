<?php

error_reporting(E_ALL ^ E_NOTICE);

$con = mysqli_connect("localhost:3307","root","","diki");

if (mysqli_connect_errno()){
  
  echo "Ez a baja a MySQL-nek: " . mysqli_connect_error();
  
}

$result = mysqli_query($con,"set names 'utf8'");

$email = 'sardi.kinga@cujo.hu';
$name='Diki';
$pass='b2d23757df87de1ab7822cd956bdb43ee3947d30';

?>