<html>
	
	<body>
		<a href="<?php echo site_url("Sluzbenik/index") ?>">Pocetna</a>
		<div style="float: right;">
			Sluzbenik: <?php echo "$korisnik->Ime"." "."$korisnik->Prezime" ?>
			<a href="<?php echo site_url("Sluzbenik/izlogujse") ?>">Izloguj se</a>
		</div>
		<br>
		<hr>
