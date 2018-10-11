<?php
include "db.php";

if(isset($_POST['insert']))
{ 
	$numero=$_POST['numero'];
    $register = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `loginPrueba` WHERE `id_num`='$numero'"));
    if($register == 0)
    {
        $insert = mysqli_query($con,"INSERT INTO `loginPrueba` (`id_num`) VALUES ('$numero')");
        if($insert)
            echo "success";
        else
            echo "error";
    }
    else if($register != 0)
        echo "exist";
}
else if(isset($_POST['login']))
{
	$numero=$_POST['numero'];
    $login = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `loginPrueba` WHERE `id_num`='$numero'"));
    if($login != 0)
        echo "success";
    else
        echo "error";
}

/*if(isset($_POST['insert']))
 {
 $numero=$_POST['numero'];
 $password=$_POST['password'];
 $q=mysqli_query($con,"INSERT INTO `loginPrueba` (`id_num`,`password`) VALUES ('$numero','$password')");
 if($q)
  echo "success";
 else
  echo "error";
 }*/
 
 
?>