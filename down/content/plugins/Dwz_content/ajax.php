<?php
$return=file_get_contents("https://eps.gs/api/make.php?url=".$_POST['url']."");
$resulta=json_decode($return);
$nameurla=$resulta->url_short;
echo $nameurla;