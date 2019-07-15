$(document).ready(function() {
    $('#rank').DataTable( {
        'responsive': 'true',
        'ajax': {
            'method': 'POST',
            'url': 'table/datos.php',
        },
        'columns' :[
            {data: 'atributo.assists'},
            {data: 'atributo.bestRankPoint'},
            {data: 'atributo.boosts'},
            {data: 'atributo.dBNOs'},
            {data: 'atributo.dailyKills'},
            {data: 'atributo.dailyWins'},
            {data: 'atributo.damageDealt'},
            {data: 'atributo.days'},
            {data: 'atributo.headshotKills'},
            {data: 'atributo.heals'},
            {data: 'atributo.killPoints'},
            {data: 'atributo.kills'},
            {data: 'atributo.longestKill'},
            {data: 'atributo.longestTimeSurvived'},
            {data: 'atributo.losses'},
            {data: 'atributo.maxKillStreaks'},
            {data: 'atributo.mostSurvivalTime'},
            {data: 'atributo.rankPoints'},
            {data: 'atributo.rankPointsTitle'},
            {data: 'atributo.revives'},
            {data: 'atributo.rideDistance'},
            {data: 'atributo.roadKills'},
            {data: 'atributo.roundMostKills'},
            {data: 'atributo.roundsPlayed'},
            {data: 'atributo.suicides'},
            {data: 'atributo.swimDistance'},
            {data: 'atributo.teamKills'},
            {data: 'atributo.timeSurvived'},
            {data: 'atributo.top10s'},
            {data: 'atributo.vehicleDestroys'},
            {data: 'atributo.walkDistance'},
            {data: 'atributo.weaponsAcquired'},
            {data: 'atributo.weeklyKills'},
            {data: 'atributo.weeklyWins'},
            {data: 'atributo.winPoints'},
            {data: 'atributo.wins'},
            {data: 'nombre'},
        ]
    } );



} );