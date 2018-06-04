<?php

	if(isset($tiket)){
		echo form_open(site_url("Gost/azuriranjePromeneGost"),"method=POST");
		echo "<table style='border: 1px solid black;'>";
		foreach($tiket as $utakmica){
			echo "<tr><td style='border: 1px solid black;'>".$utakmica->Vreme."</td><td style='border: 1px solid black;'>".$utakmica->Tim1."</td><td style='border: 1px solid black;'>".$utakmica->Tim2."</td><td style='border: 1px solid black;'>".$utakmica->Jedan."<input type='radio' name='".$utakmica->IDUtakmice."_promena' value='Jedan'/></td><td style='border: 1px solid black;'>".$utakmica->Iks."<input type='radio' name='".$utakmica->IDUtakmice."_promena' checked='checked' value='Iks'/></td><td style='border: 1px solid black;'>".$utakmica->Dva."<input type='radio' name='".$utakmica->IDUtakmice."_promena' value='Dva'/></td>";
		}
		echo "<tr><td>";
		echo "Iznos:</td><td>";
		echo form_input("brzi_iznos_promena", set_value("brzi_iznos_promena"));
		echo "</td><td>";
		echo form_submit("submit", "promeni brzi");
		echo "</td><td colspan='3'>";
		echo form_error("brzi_iznos_promena", "<font color='red'>","</font>");
		echo "</td></tr></table>";
		echo "<input type='hidden' name='skriveno' value='".$id."'>";
		echo form_close();
	}else{
		//nikada ne bi trebalo da udje u ovu granu
		echo "Nema Utakmica";
	}
	
?>