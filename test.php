<?php
/* include_once 'brules/usuariosObj.php';
$userObj = new usuariosObj();

echo "Hola mundo<br>";

$usuarios = $userObj->obtTodosUsuarios();

foreach ($usuarios as $usuario) {
	echo $usuario->idUsuario." - ".$usuario->nombre."<br>";
}

echo "<pre>";print_r($usuarios);echo"</pre>";

$user = $userObj->UserByID(1);
echo "<pre>";print_r($user);echo"</pre>";
echo "nombre: ".$user->nombre."<br>";
$user = $userObj->UserByID(6);
echo "<pre>";print_r($user);echo"</pre>";
echo "nombre: ".$user->nombre."<br>";
echo "fin<br>"; */

include_once './libs/eventosCal/iCalEasyReader.php';
$ical = new iCalEasyReader();
$idCal = "q2n3jg9a0luaih80cahghksgu4@group.calendar.google.com"; //Identificador del calendario de google
$arrEvents = $ical->getEventsCols($idCal); //Coleccion de eventos

// $calData = $ical->load( file_get_contents( 'https://calendar.google.com/calendar/ical/'.$idCal.'/public/basic.ics' ) );

echo "<pre>";
print_r($arrEvents);
// print_r($calData);
echo "</pre>";