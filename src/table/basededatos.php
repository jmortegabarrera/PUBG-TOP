<?php
header('Content-Type: application/json; charset=utf-8');

require_once('../Conection.php');
session_start();


$conection = Conection::getConection();
$acentos = mysqli_query($conection,"SET NAMES 'utf8'");

use GuzzleHttp\Client;
use Lifeformwp\PHPPUBG\PUBGManager;

require_once ('../../vendor/autoload.php');
$token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJqdGkiOiIyNDhlNmU2MC04NTFkLTAxMzctOWY5Ny0wNTVmYmQzZDJiYTEiLCJpc3MiOiJnYW1lbG9ja2VyIiwiaWF0IjoxNTYyNzQ4MzkzLCJwdWIiOiJibHVlaG9sZSIsInRpdGxlIjoicHViZyIsImFwcCI6ImRpc2pleWpvdXNlLWhvIn0.9FSsxlZL5lD8D_rfpS3AncTh7k9V67RD8QoXq2TniVc";

$client = new GuzzleHttp\Client();
$class = new Lifeformwp\PHPPUBG\PUBGManager($client, $token);

$seasonid='division.bro.official.pc-2018-04';

$query="SELECT * FROM rank WHERE seasonid='$seasonid'";
$result=mysqli_query($conection,$query);
$i=0;
while($row = mysqli_fetch_assoc($result)) {
    $datos['data'][$i] = $row;
    $i++;
}
echo json_encode($datos);