<html>
	
	<body>
		<a href="<?php echo site_url("Registrovani/index") ?>">Pocetna</a>
		<a href="<?php echo site_url("Registrovani/mojiTiketi") ?>">Moji tiketi</a>
		<div style="float: right;">
			Korisnik: <?php echo "$korisnik->Ime"." "."$korisnik->Prezime" ?>&nbsp;
			Stanje: <?php echo "$stanje" ?>
			<a href="<?php echo site_url("Registrovani/izlogujse") ?>">Izloguj se</a>
		</div>
		<br>
		<hr>
