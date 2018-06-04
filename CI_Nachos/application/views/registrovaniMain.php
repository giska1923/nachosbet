<?php

	if(isset($poruka)){
		echo $poruka;
	}

	if(isset($utakmice)){
		// foreach($sluzbenici as $sluzbenik){
		// 	echo "$sluzbenik->IDKorisnik";
		// }
		echo form_open(site_url("Registrovani/kreiranjeTiketa"),"method=POST");
		echo "<table style='border: 1px solid black;'>";
		foreach($utakmice as $utakmica){
			echo "<tr><td style='border: 1px solid black;'>".$utakmica->Vreme."</td><td style='border: 1px solid black;'>".$utakmica->Tim1."</td><td style='border: 1px solid black;'>".$utakmica->Tim2."</td><td style='border: 1px solid black;'>".$utakmica->Jedan."<input type='radio' name='".$utakmica->IDUtakmice."' value='Jedan'/></td><td style='border: 1px solid black;'>".$utakmica->Iks."<input type='radio' name='".$utakmica->IDUtakmice."' value='Iks'/></td><td style='border: 1px solid black;'>".$utakmica->Dva."<input type='radio' name='".$utakmica->IDUtakmice."' value='Dva'/></td>";
		}
		echo "<tr><td>";
		echo "Iznos:</td><td>";
		echo form_input("iznos", set_value("iznos"));
		echo "</td><td>";
		echo form_error("iznos", "<font color='red'>","</font>");
		echo "</td><td>";
		echo "<label for='online'>Online</label><input type='radio' id='online' name='vrsta' value='online' checked='checked'/>";
		echo "</td><td>";
		echo "<label for='brzi'>Brzi tiket</label><input type='radio' id='brzi' name='vrsta' value='brzi'/>";
		echo "</td><td>";
		echo form_submit("submit", "uplati tiket");
		echo "</td></tr></table>";
		echo form_close();
	}else{
		//nikada ne bi trebalo da udje u ovu granu
		echo "Nema Utakmica";
	}
	
	echo form_open(site_url("Registrovani/promenaBrzog"),"method=POST");
	echo "<br><br><br>";
	echo "<table style='border: 1px solid black;'>";
	echo "<tr><td>";
	echo "ID brzog tiketa:</td><td>";
	echo form_input("brzi_promena_id", set_value("brzi_promena_id"));
	echo "</td><td>";
	echo form_submit("submit", "promeni brzi tiket");
	echo "</td></tr></table>";
	echo form_close();

?>