<?php
require_once ('../vendor/autoload.php');
$token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJqdGkiOiIyNDhlNmU2MC04NTFkLTAxMzctOWY5Ny0wNTVmYmQzZDJiYTEiLCJpc3MiOiJnYW1lbG9ja2VyIiwiaWF0IjoxNTYyNzQ4MzkzLCJwdWIiOiJibHVlaG9sZSIsInRpdGxlIjoicHViZyIsImFwcCI6ImRpc2pleWpvdXNlLWhvIn0.9FSsxlZL5lD8D_rfpS3AncTh7k9V67RD8QoXq2TniVc";

$client = new GuzzleHttp\Client();
$class = new Lifeformwp\PHPPUBG\PUBGManager($client, $token);

//$data = $class->getMatch('pc-eu', 'abe08f7e-3add-4fd6-9bcd-4aff88fc7adf'); //returns array
//$matchObject = $class->hydrate($data, \Lifeformwp\PHPPUBG\PUBGManager::HYDRATE_MATCH); //returns Lifeformwp\PHPPUBG\DTO\Match object


$listado=['KeTeMeTo','Nomemate'];
$listado=$class->getPlayers('pc-eu',$listado);

foreach ($listado['data'] as $item){
    $id[]=$item['id'];
}

foreach ($id as $item) {
    $data=$class->getPlayer('pc-eu',$item);
    $estadisticas=$class->getSeasonDataForPlayer('pc-eu',$item,'division.bro.official.2019-05');
    var_dump($data['data']['attributes']['name']);
    var_dump($estadisticas['data']['attributes']['gameModeStats']['squad-fpp']);
}

