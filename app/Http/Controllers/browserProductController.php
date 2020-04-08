<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


class browserProductController extends Controller
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
        return view('browserProduct');
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
       // $users = DB::connection('account');
        $DBname = "wtlab108";
        $DBhost = "127.0.0.1";
        $DBuser = 'root';
        $DBpass = '';

    $conn = mysqli_connect($DBhost, $DBuser, $DBpass) ;//連接資料庫
    //DB::connection('mysql');
	mysqli_query($conn,"SET NAMES utf8");
mysqli_select_db($conn,$DBname);
	header('Content-Type: application/json;charset=utf-8');

	$return_arr = array();
	$id = $_POST['id'];

	$sql = "SELECT `productName` ,`productPrice`,`productImage`, `productID` FROM `product` WHERE `supplierID`=".$id;
    $result = $conn->query($sql);
   // $result = DB::select('select * from users where id = :id', ['id' => 1]);

	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		$row_array = $row;
		array_push($return_arr,$row_array);
    }
	//回傳json形式
	echo json_encode($return_arr);
	mysqli_free_result($result);

    mysqli_close($conn);

}



}


