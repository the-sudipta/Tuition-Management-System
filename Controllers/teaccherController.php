<?php
//
//    include 'db_config.php';
//
//    $uname="";
//    $err_uname="";
//    $password="";
//    $err_password="";
//
//    $err_db="";
//    $hasError=false;
//
//
//    if (isset($_POST["login"])){
//        if(empty($_COOKIE["uname"])){
//            $hasError=true;
//            $err_uname="Username Required";
//        }
//        else{
//            $uname=$_COOKIE["uname"];
//        }
//
//        if(empty($_POST["password"])){
//            $hasError=true;
//            $err_password="Password Required";
//        }
//        else{
//            $password=$_POST["password"];
//        }
//
//        if(!$hasError){
//			if(authenticateUser($uname,$password)){
//			header("Location: homepage1.php");
//		}
//		    $err_db="uname password invaluname";
//		}
//		}
//
//	function authenticateUser($uname,$password){
//		$query="select * from admin where uname='$uname' and password='$password'";
//		$rs=get($query);
//		if(count($rs)>0){
//			return true;
//		}
//		return false;
//	}
//
//
//?>
<!---->
<!---->
<!---->
