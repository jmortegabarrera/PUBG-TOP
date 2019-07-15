<?php
header('Content-Type: application/json; charset=utf-8');

use GuzzleHttp\Client;
use Lifeformwp\PHPPUBG\PUBGManager;

require_once ('../../vendor/autoload.php');
$token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJqdGkiOiIyNDhlNmU2MC04NTFkLTAxMzctOWY5Ny0wNTVmYmQzZDJiYTEiLCJpc3MiOiJnYW1lbG9ja2VyIiwiaWF0IjoxNTYyNzQ4MzkzLCJwdWIiOiJibHVlaG9sZSIsInRpdGxlIjoicHViZyIsImFwcCI6ImRpc2pleWpvdXNlLWhvIn0.9FSsxlZL5lD8D_rfpS3AncTh7k9V67RD8QoXq2TniVc";

$client = new GuzzleHttp\Client();
$class = new Lifeformwp\PHPPUBG\PUBGManager($client, $token);

//$data = $class->getMatch('pc-eu', 'abe08f7e-3add-4fd6-9bcd-4aff88fc7adf'); //returns array
//$matchObject = $class->hydrate($data, \Lifeformwp\PHPPUBG\PUBGManager::HYDRATE_MATCH); //returns Lifeformwp\PHPPUBG\DTO\Match object

//BUSCAR POR PLAYER
$listado=['KeTeMeTo','Nomemate'];
$listado=$class->getPlayers('pc-eu',$listado);

//sacar season actual
$seasons=$class->getSeasons('pc-eu');
foreach ($seasons['data'] as $season){
    if ($season['attributes']['isCurrentSeason']==true){
        $seasonid=$season['id'];
    }
}

foreach ($listado['data'] as $item){
    $id[]=$item['id'];
}

//sacar estadisticas por player
$i=0;
foreach ($id as $item) {
    $data=$class->getPlayer('pc-eu',$item);
    $estadisticas=$class->getSeasonDataForPlayer('pc-eu',$item,$seasonid);
    $data=$data['data']['attributes']['name'];
    $estadisticas=$estadisticas['data']['attributes']['gameModeStats']['squad-fpp'];
    $lpe['data'][$i]['nombre']=$data;
    $lpe['data'][$i]['atributo']=$estadisticas;
    $i++;
}

//$clasi=$class->getLeaderboard('steam','squad-fpp');
//$lpe='{"data":[{"nombre":"KeTeMeTo","atributo":{"assists":56,"bestRankPoint":2828.7388,"boosts":336,"dBNOs":114,"dailyKills":1,"dailyWins":0,"damageDealt":19943.97,"days":34,"headshotKills":41,"heals":436,"killPoints":0,"kills":139,"longestKill":324.68155,"longestTimeSurvived":1899.685,"losses":161,"maxKillStreaks":2,"mostSurvivalTime":1899.685,"rankPoints":2828.7388,"rankPointsTitle":"3-1","revives":59,"rideDistance":288549.62,"roadKills":0,"roundMostKills":5,"roundsPlayed":165,"suicides":4,"swimDistance":1124.9402,"teamKills":4,"timeSurvived":159221.55,"top10s":78,"vehicleDestroys":4,"walkDistance":282959.44,"weaponsAcquired":710,"weeklyKills":1,"weeklyWins":0,"winPoints":0,"wins":8}},{"nombre":"Nomemate","atributo":{"assists":287,"bestRankPoint":4314.65,"boosts":1037,"dBNOs":708,"dailyKills":19,"dailyWins":1,"damageDealt":119668.64,"days":63,"headshotKills":167,"heals":1303,"killPoints":0,"kills":751,"longestKill":453.62796,"longestTimeSurvived":1954.96,"losses":523,"maxKillStreaks":4,"mostSurvivalTime":1954.96,"rankPoints":4314.65,"rankPointsTitle":"5-4","revives":195,"rideDistance":708221.06,"roadKills":0,"roundMostKills":7,"roundsPlayed":573,"suicides":7,"swimDistance":4756.804,"teamKills":10,"timeSurvived":494004.94,"top10s":265,"vehicleDestroys":14,"walkDistance":806560.6,"weaponsAcquired":2594,"weeklyKills":67,"weeklyWins":4,"winPoints":0,"wins":57}}]}';
echo json_encode($lpe);