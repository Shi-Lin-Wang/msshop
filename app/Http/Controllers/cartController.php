<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\localhost;


class cartController extends Controller
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
public function addcart()
{

    $DBname = 'lumen';//資料庫名稱
    $DBhost = "127.0.0.1";
    $DBuser = 'root';
    $DBpass = '';
    $connection = mysqli_connect($DBhost, $DBuser, $DBpass);//or die('Error with MySQL connection');
    mysqli_query($connection,"SET NAMES utf8");
    mysqli_select_db($connection,$DBname);
    header('Content-Type: application/json;charset=utf-8');

	  echo var_dump($_POST);

    //這邊傳入verifyToken的方法verifyToken 和getToken 去尋找token內部的值username 和time


	$unitprice=$_POST['productPrice']; //單價
	$number=$_POST['number'];  //數量
	$temp=$number*$unitprice;  //總價
	$productName=$_POST['productName']; //名稱
	$productID=$_POST['productID'];
	$remark=$_POST['remark'];

	$sql = "SELECT `supplierID` FROM `product` WHERE `productID`='$productID'";
	$result = mysqli_query($connection, $sql);
	//這邊將抓到的資料放入陣列
	$row = mysqli_fetch_array($result,MYSQLI_NUM);
  $storeID = $row[0];

    $user=Auth::user();


	$sql = "SELECT * FROM `cart_product` WHERE `customer` = '$user' AND `product`='$productName'";

	$result = mysqli_query($connection,$sql);
	if($result->num_rows > 0){
		$row = mysqli_fetch_array($result,MYSQLI_NUM);
		$number=$row[4]+$number;
		$temp=$number*$unitprice;  //總價
		$sql = "UPDATE `cart_product` SET `amount`=$number,`totalPrice`=$temp WHERE `customer` = '$user' AND `product`='$productName'";
		mysqli_query($connection, $sql);

	}else{
		//寫進資料庫
		$sql = "INSERT INTO `cart_product`(`customer`,`store`,`product`,`unitprice`, `amount`,`totalPrice`,`remark`)" .
						"VALUES ('$user','$storeID','$productName','$unitprice','$number','$temp','$remark')";
		mysqli_query($connection, $sql);
	}
    //全部做完後返回

    //return view('cart');
    //return redirect()->route("cart?storeID=$storeID");
    //$url=
   // $storeID=$_POST[$storeID];
   //return response('$storeID')->cookie('storeID', '$storeID', 60);

    return redirect("cart?storeID=$storeID");
    //return redirect("https://lumen.golaravel.com/docs/responses/", 301);
    //Cookie::queue();
    //return redirect("https://lumen.golaravel.com/docs/responses/");
    //header("Location:https://127.0.0.1/wtlab108/orderWithIOTA/cart.php?storeID=$storeID");

    mysqli_free_result($result);
    mysqli_close($connection);
}

public function cart()
{

    return view('cart');
}


public function getcartDetail()
{
    $DBname = 'lumen';//資料庫名稱
    $DBhost = "127.0.0.1";
    $DBuser = 'root';
    $DBpass = '';
	$conn = mysqli_connect($DBhost, $DBuser, $DBpass) ;//連接資料庫
	mysqli_query($conn,"SET NAMES utf8");
	mysqli_select_db($conn,$DBname);
	header('Content-Type: application/json;charset=utf-8');

  //建立一個用來放回傳資料的陣列
	$return_arr = array();

  //$token = $_COOKIE["token"];
  //這邊傳入verifyToken的方法verifyToken 和getToken 去尋找token內部的值username 和time

  $user=Auth::user();;  //將data內的username取出放入acc


  $storeID=$_GET['storeID']; //單價
  //從資料庫獲得資料
  $sql = "SELECT *  FROM `cart_product` Where `customer`='$user' AND `store`='$storeID' ";


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
}
public function CartDelete()
{
    $DBname = 'lumen';//資料庫名稱
    $DBhost = "127.0.0.1";
    $DBuser = 'root';
    $DBpass = '';
	$conn = mysqli_connect($DBhost, $DBuser, $DBpass) ;//連接資料庫
	mysqli_query($conn,"SET NAMES utf8");
	mysqli_select_db($conn,$DBname);
	header('Content-Type: application/json;charset=utf-8');

  $product=$_GET['product'];

  //$token = $_COOKIE["token"];
  //這邊傳入verifyToken的方法verifyToken 和getToken 去尋找token內部的值username 和time

  $user=Auth::user();  //將data內的username取出放入acc


  //從資料庫獲得資料
  $sql = "DELETE  FROM `cart_product` Where `customer`='$user' AND `product`='$product'";

  echo "success";
  mysqli_query($conn, $sql);


  mysqli_close($conn);


}

public function CartToOrder()
{
    $DBname = 'lumen';//資料庫名稱
    $DBhost = "127.0.0.1";
    $DBuser = 'root';
    $DBpass = '';
    $connection = mysqli_connect($DBhost, $DBuser, $DBpass);//or die('Error with MySQL connection');
    mysqli_query($connection,"SET NAMES utf8");
    mysqli_select_db($connection,$DBname);
    header('Content-Type: application/json;charset=utf-8');
    //建立一個用來放回傳資料的陣列
    $return_arr = array();


    $storeID = $_GET["storeID"];

    //這邊傳入verifyToken的方法verifyToken 和getToken 去尋找token內部的值username 和time

    $user=Auth::user(); //將data內的username取出放入acc

    //從資料庫獲得資料
    $sql = "SELECT *  FROM `cart_product` Where `customer`='$user' AND `store`='$storeID'";

    $result = mysqli_query($connection, $sql);
    //這邊將抓到的資料放入陣列
    while ($row = mysqli_fetch_array($result,MYSQLI_NUM)) {
        $row_array = $row;
        array_push($return_arr,$row_array);
    }


    //先把以前訂單編號最大找出來
    $sql = "SELECT MAX(orderNumber) FROM `storeorder_detail`";
    $result = mysqli_query($connection,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_NUM);
    $ordernumber=$row[0]+1;
    //echo $ordernumber;


    //建立一個放總價的變數
    $totalPrice=0;
    //開始把每樣商品丟進storeorder_detail
	  for($i=0;$i<count($return_arr);$i++){

            //先把價格抓出來
            $name=$return_arr[$i][2];
            $unitprice=$return_arr[$i][3];
            $amount=$return_arr[$i][4];
            $remark=$return_arr[$i][6];

            //算單樣總價
            $temp=$amount*$unitprice;
            $totalPrice+=$temp;

            //寫進資料庫
            $sql = "INSERT INTO `storeorder_detail`(`orderNumber`,`product`,`unitprice`, `amount`,`totalPrice`,`remark`)" .
                   "VALUES ('$ordernumber','$name','$unitprice','$amount','$temp','$remark')";
            mysqli_query($connection, $sql);


            //先把以前庫存找出來
            $sql = "SELECT `stock` FROM `product` WHERE `productName`='$name'";
            $result = mysqli_query($connection,$sql);
            $sqlStock = mysqli_fetch_array($result,MYSQLI_NUM);
            $stock=(int)$sqlStock[0]-(int)$amount;
            echo $stock;
            $sql = "UPDATE `product` SET `stock`='$stock' WHERE `productName`='$name'";
            mysqli_query($connection, $sql);
            //刪除掉購物車的東西
    }


    //這邊需要做出把購買人跟店家跟總額丟進訂單的功能
    date_default_timezone_set('Asia/Taipei');
    $date=date('Y-m-d  h:i:sa');
    $sql = "INSERT INTO `storeorder`(`orderNumber`,`status`, `customer`,`store`,`price`,`date`)".
           "VALUES ('$ordernumber','0','$user','$storeID','$totalPrice',NOW())";
    mysqli_query($connection, $sql);

    $sql = "DELETE FROM `cart_product` WHERE customer='$user' AND `store`='$storeID'";
    mysqli_query($connection, $sql);
    return redirect("/viewOrder");
    mysqli_free_result($result);
    mysqli_close($connection);




}


public function viewOrderDetail()
{

    return view('viewOrderDetail');
}
}
