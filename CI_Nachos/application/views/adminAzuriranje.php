<?php

	if(isset($utakmice)){
		// foreach($sluzbenici as $sluzbenik){
		// 	echo "$sluzbenik->IDKorisnik";
		// }
		echo form_open(site_url("Admin/azuriranjeUtakmica"),"method=POST");
		echo "<table style='border: 1px solid black;'>";
		foreach($utakmice as $utakmica){
			echo "<tr><td style='border: 1px solid black;'>".$utakmica->Vreme."</td><td style='border: 1px solid black;'>".$utakmica->Tim1."</td><td style='border: 1px solid black;'>".$utakmica->Tim2."</td><td style='border: 1px solid black;'>".$utakmica->Jedan."<input type='radio' name='".$utakmica->IDUtakmice."' value='Jedan'/></td><td style='border: 1px solid black;'>".$utakmica->Iks."<input type='radio' checked='checked' name='".$utakmica->IDUtakmice."' value='Iks'/></td><td style='border: 1px solid black;'>".$utakmica->Dva."<input type='radio' name='".$utakmica->IDUtakmice."' value='Dva'/></td>";
		}
		echo "<tr><td>";
		echo form_submit("submit", "azuriraj");
		echo "</td></tr></table>";
		echo form_close();
	}else{
		//nikada ne bi trebalo da udje u ovu granu
		echo "Nema Utakmica";
	}
	
?>