<?php

	if(isset($poruka)){
		echo $poruka;
	}

	if(isset($utakmice)){
		// foreach($sluzbenici as $sluzbenik){
		// 	echo "$sluzbenik->IDKorisnik";
		// }
		echo form_open(site_url("Registrovani/storniranjeTiketa"),"method=POST");
		echo "<table style='border: 1px solid black;'>";
		foreach($utakmice as $utakmica){
			echo "<tr><td>".$utakmica->IDTiket."</td><td>".$utakmica->IDUtakmice."</td><td>".$utakmica->Odigrano."</td><td></tr>";
		}
		echo "<tr><td>";
		echo "ID:</td><td>";
		echo form_input("brisanje_id", set_value("brisanje_id"));
		echo "</td><td>";
		echo form_error("brisanje_id", "<font color='red'>","</font>");
		echo "</td><td>";
		echo form_submit("submit", "obrisi tiket");
		echo "</td></tr></table>";
		echo form_close();
	}else{
		//nikada ne bi trebalo da udje u ovu granu
		echo "Nema Utakmica";
	}

?>