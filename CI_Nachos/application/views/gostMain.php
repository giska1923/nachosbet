<?php

	if(isset($poruka)){
		echo $poruka;
	}

	if(isset($utakmice)){
		// foreach($sluzbenici as $sluzbenik){
		// 	echo "$sluzbenik->IDKorisnik";
		// }
		echo form_open(site_url("Gost/kreiranjeBrzog"),"method=POST");
		echo "<table style='border: 1px solid black;'>";
		foreach($utakmice as $utakmica){
			echo "<tr><td style='border: 1px solid black;'>".$utakmica->Vreme."</td><td style='border: 1px solid black;'>".$utakmica->Tim1."</td><td style='border: 1px solid black;'>".$utakmica->Tim2."</td><td style='border: 1px solid black;'>".$utakmica->Jedan."<input type='radio' name='".$utakmica->IDUtakmice."' value='Jedan'/></td><td style='border: 1px solid black;'>".$utakmica->Iks."<input type='radio' name='".$utakmica->IDUtakmice."' value='Iks'/></td><td style='border: 1px solid black;'>".$utakmica->Dva."<input type='radio' name='".$utakmica->IDUtakmice."' value='Dva'/></td>";
		}
		echo "<tr><td>";
		echo "Iznos:</td><td>";
		echo form_input("brzi_iznos", set_value("brzi_iznos"));
		echo "</td><td colspan='4'>";
		echo form_submit("submit", "uplati brzi");
		echo "</td></tr></table>";
		echo form_close();
	}else{
		//nikada ne bi trebalo da udje u ovu granu
		echo "Nema Utakmica";
	}
	
	echo form_open(site_url("Gost/promenaBrzog"),"method=POST");
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