<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
    }

public function viewOrder()
{
    return view('viewOrder');
}

public function navSigninCheck()
{
    $DBname = 'wtlab108';//資料庫名稱
    $DBhost = "127.0.0.1";
    $DBuser = 'root';
    $DBpass = '';
        $conn = mysqli_connect($DBhost, $DBuser, $DBpass) ;//連接資料庫
        mysqli_query($conn,"SET NAMES utf8");
        mysqli_select_db($conn,$DBname);
        header('Content-Type: application/json;charset=utf-8');

        //$token = $_COOKIE['token'];
        $return_arr = array();

      //這邊傳入verifyToken的方法verifyToken 和getToken 去尋找token內部的值username 和time



      $acc=Auth::user();  //將data內的username取出放入acc
        //echo $acc;
          $sql = "SELECT `account` FROM `account` Where `account` = '$acc' ";
        $result = mysqli_query($conn, $sql);

        //這邊將抓到的資料放入陣列
          while ($row = mysqli_fetch_array($result,MYSQLI_NUM)) {
              $row_array = $row;
          array_push($return_arr,$row_array);
        }

        //回傳json形式
          echo json_encode($return_arr);

          mysqli_free_result($result);
          mysqli_close($conn);
        $guest = array();
        array_push($guest,"Guest");
        array_push($return_arr,$guest);
        echo json_encode($return_arr);



}
public function getOrder()
{
    $DBname = 'wtlab108';//資料庫名稱
    $DBhost = "127.0.0.1";
    $DBuser = 'root';
    $DBpass = '';
	$conn = mysqli_connect($DBhost, $DBuser, $DBpass) ;//連接資料庫
	mysqli_query($conn,"SET NAMES utf8");
	mysqli_select_db($conn,$DBname);
	header('Content-Type: application/json;charset=utf-8');

  //建立一個用來放回傳資料的陣列
	$return_arr = array();
    $acc=Auth::user(); //將data內的username取出放入acc

  //從資料庫獲得資料
  $sql = "SELECT *  FROM `storeorder` Where `customer`='$acc' AND `status`='0'";
  $result = mysqli_query($conn, $sql);
  //這邊將抓到的資料放入陣列
  while ($row = mysqli_fetch_array($result,MYSQLI_BOTH)) {
    $row_array = $row;
    array_push($return_arr,$row_array);
  }
  //從資料庫獲得資料
  $sql = "SELECT *  FROM `storeorder` Where `customer`='$acc' AND `status`='1'";
  $result = mysqli_query($conn, $sql);
  //這邊將抓到的資料放入陣列
  while ($row = mysqli_fetch_array($result,MYSQLI_BOTH)) {
    $row_array = $row;
    array_push($return_arr,$row_array);
  }
  //從資料庫獲得資料
  $sql = "SELECT *  FROM `storeorder` Where `customer`='$acc' AND `status`='2'";
  $result = mysqli_query($conn, $sql);
  //這邊將抓到的資料放入陣列
  while ($row = mysqli_fetch_array($result,MYSQLI_BOTH)) {
    $row_array = $row;
    array_push($return_arr,$row_array);
  }

  //回傳json形式
  echo json_encode($return_arr);

  mysqli_free_result($result);
  mysqli_close($conn);


}

}


