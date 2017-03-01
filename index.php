<?php 
	require_once('lib/rb.php');
	
	date_default_timezone_set('Europe/Rome');
	
	R::setup('mysql:host=127.0.0.1;dbname=montepagano','montepagano', 'pwd');
	R::freeze(TRUE);
	
	$pg=(empty($_REQUEST['p'])) ? 'home' : $_REQUEST['p'];
	$pg='pgs/'.$pg.'.php';
	
?>
<!doctype html>
<html lang="it">
  <head>
    <title>Manutenzione pc</title>
	<meta charset="utf-8" />
	<link src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  </head>
  <body>
	<div id="all" class="all">
		<? if (file_exists($pg)) include_once($pg); ?>
	</div>
  </body>
</html>
