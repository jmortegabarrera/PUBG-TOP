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

//$data = $class->getMatch('pc-eu', 'abe08f7e-3add-4fd6-9bcd-4aff88fc7adf'); //returns array
//$matchObject = $class->hydrate($data, \Lifeformwp\PHPPUBG\PUBGManager::HYDRATE_MATCH); //returns Lifeformwp\PHPPUBG\DTO\Match object


//BUSCAR USUARIOS REGISTRADOS
$query="SELECT nombre FROM usuarios";
$result=mysqli_query($conection,$query);
$usuarios=$result->fetch_all();
foreach ($usuarios as $user){
    $listado[]=$user[0];
}
////BUSCAR POR PLAYER
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


//sacar estadisticas por player y meterlas tanto en el json como en la base de datos
$i=0;
foreach ($id as $item) {
    $data=$class->getPlayer('pc-eu',$item);
    $estadisticas=$class->getSeasonDataForPlayer('pc-eu',$item,$seasonid);
    $data=$data['data']['attributes']['name'];
    $estadisticas=$estadisticas['data']['attributes']['gameModeStats']['squad-fpp'];
    $lpe['data'][$i]['nombre']=$data;
    $lpe['data'][$i]['atributo']=$estadisticas;
    $nombre=$data;
    $assist=$estadisticas['assists'];
    $bestRankPoint=$estadisticas['bestRankPoint'];
    $boosts=$estadisticas['boosts'];
    $dBNOs=$estadisticas['dBNOs'];
    $dailyKills=$estadisticas['dailyKills'];
    $dailyWins=$estadisticas['dailyWins'];
    $damageDealt=$estadisticas['damageDealt'];
    $days=$estadisticas['days'];
    $headshotKills=$estadisticas['headshotKills'];
    $heals=$estadisticas['heals'];
    $killPoints=$estadisticas['killPoints'];
    $kills=$estadisticas['kills'];
    $longestKill=$estadisticas['longestKill'];
    $longestTimeSurvived=$estadisticas['longestTimeSurvived'];
    $losses=$estadisticas['losses'];
    $maxKillStreaks=$estadisticas['maxKillStreaks'];
    $mostSurvivalTime=$estadisticas['mostSurvivalTime'];
    $rankPoints=$estadisticas['rankPoints'];
    $rankPointsTitle=$estadisticas['rankPointsTitle'];
    $revives=$estadisticas['revives'];
    $rideDistance=$estadisticas['rideDistance'];
    $roadKills=$estadisticas['revives'];
    $roundMostKills=$estadisticas['roundMostKills'];
    $roundsPlayed=$estadisticas['roundsPlayed'];
    $suicides=$estadisticas['suicides'];
    $swimDistance=$estadisticas['swimDistance'];
    $teamKills=$estadisticas['teamKills'];
    $timeSurvived=$estadisticas['timeSurvived'];
    $top10s=$estadisticas['top10s'];
    $vehicleDestroys=$estadisticas['vehicleDestroys'];
    $walkDistance=$estadisticas['walkDistance'];
    $weaponsAcquired=$estadisticas['weaponsAcquired'];
    $weeklyKills=$estadisticas['weeklyKills'];
    $weeklyWins=$estadisticas['weeklyWins'];
    $winPoints=$estadisticas['winPoints'];
    $wins=$estadisticas['wins'];

    $query="SELECT idRank FROM rank WHERE nombre='$nombre' AND seasonid='$seasonid'";
    $result=mysqli_query($conection,$query);
    $idrank=$result->fetch_row();
    if ($result->fetch_row()){
        $query="UPDATE rank SET nombre='$nombre',assists=$assist,bestRankPoint=$bestRankPoint,boosts=$boosts,dBNOs=$dBNOs,dailyKills=$dailyKills,dailyWins=$dailyWins,damageDealt='$damageDealt',
                days=$days, headshotKills=$headshotKills,heals=$heals,killPoints=$killPoints,kills=$kills, longestKill=$longestKill,longestTimeSurvived=$longestTimeSurvived,
                losses=$losses,maxKillStreaks=$maxKillStreaks,mostSurvivalTime=$mostSurvivalTime,rankPoints=$rankPoints,rankPointsTitle='$rankPointsTitle',
                revives=$revives,rideDistance=$rideDistance,roadKills=$roadKills,roundMostKills=$roundMostKills,roundsPlayed=$roundsPlayed,
                suicides=$suicides,swimDistance=$swimDistance,teamKills=$teamKills,timeSurvived=$timeSurvived,top10s=$top10s,vehicleDestroys=$vehicleDestroys,
                 walkDistance=$walkDistance,weaponsAcquired=$weaponsAcquired,weeklyKills=$weeklyKills,weeklyWins=$weeklyWins,winPoints=$winPoints,wins=$wins,
                 seasonid='$seasonid' WHERE CodUsuario=$idrank";
        $result = mysqli_query($conection, $query);
        var_dump($result);
    }
    else{
        $query="INSERT INTO rank VALUES (0,'$nombre',$assist,$bestRankPoint,$boosts,$dBNOs,$dailyKills,$dailyWins,'$damageDealt',$days,$headshotKills,
          $heals,$killPoints,$kills,$longestKill,$longestTimeSurvived,$losses,$maxKillStreaks,$mostSurvivalTime,$rankPoints,'$rankPointsTitle',$revives,
          $rideDistance,$roadKills,$roundMostKills,$roundsPlayed,$suicides,$swimDistance,$teamKills,$timeSurvived,$top10s,$vehicleDestroys,
          $walkDistance,$weaponsAcquired,$weeklyKills,$weeklyWins,$winPoints,$wins,'$seasonid')";
        $result = mysqli_query($conection, $query);
    }
    $i++;
}

////$clasi=$class->getLeaderboard('steam','squad-fpp');
////$lpe='{"data":[{"nombre":"KeTeMeTo","atributo":{"assists":56,"bestRankPoint":2828.7388,"boosts":336,"dBNOs":114,"dailyKills":1,"dailyWins":0,"damageDealt":19943.97,"days":34,"headshotKills":41,"heals":436,"killPoints":0,"kills":139,"longestKill":324.68155,"longestTimeSurvived":1899.685,"losses":161,"maxKillStreaks":2,"mostSurvivalTime":1899.685,"rankPoints":2828.7388,"rankPointsTitle":"3-1","revives":59,"rideDistance":288549.62,"roadKills":0,"roundMostKills":5,"roundsPlayed":165,"suicides":4,"swimDistance":1124.9402,"teamKills":4,"timeSurvived":159221.55,"top10s":78,"vehicleDestroys":4,"walkDistance":282959.44,"weaponsAcquired":710,"weeklyKills":1,"weeklyWins":0,"winPoints":0,"wins":8}},{"nombre":"Nomemate","atributo":{"assists":287,"bestRankPoint":4314.65,"boosts":1037,"dBNOs":708,"dailyKills":19,"dailyWins":1,"damageDealt":119668.64,"days":63,"headshotKills":167,"heals":1303,"killPoints":0,"kills":751,"longestKill":453.62796,"longestTimeSurvived":1954.96,"losses":523,"maxKillStreaks":4,"mostSurvivalTime":1954.96,"rankPoints":4314.65,"rankPointsTitle":"5-4","revives":195,"rideDistance":708221.06,"roadKills":0,"roundMostKills":7,"roundsPlayed":573,"suicides":7,"swimDistance":4756.804,"teamKills":10,"timeSurvived":494004.94,"top10s":265,"vehicleDestroys":14,"walkDistance":806560.6,"weaponsAcquired":2594,"weeklyKills":67,"weeklyWins":4,"winPoints":0,"wins":57}}]}';
echo json_encode($lpe);