<?php

	if(isset($poruka)){
		echo $poruka;
	}

	echo form_open(site_url("Admin/obrisiPonudu"),"method=POST");
	echo form_submit("submit", "obrisi ponudu");
	echo form_close();
	
	//Dodavanje sluzbenika forma
	echo form_open(site_url("Admin/dodajSluzbenika"),"method=POST");
	echo "<table><tr><td>Ime:</td><td>";
	echo form_input("ime", set_value("ime"));
	echo "</td><td>";
	echo form_error("ime", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>Prezime:<td>";
	echo form_input("prezime", set_value("prezime"));
	echo "</td><td>";
	echo form_error("prezime", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>Username:<td>";
	echo form_input("username", set_value("username"));
	echo "</td><td>";
	echo form_error("username", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>Password:</td><td>";
	echo form_password("password");
	echo "</td><td>";
	echo form_error("password","<font color='red'>", "</font>");
	echo "</td></tr><tr><td>";
	echo "<tr><td>JMBG:<td>";
	echo form_input("JMBG", set_value("JMBG"));
	echo "</td><td>";
	echo form_error("JMBG", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>Plata:<td>";
	echo form_input("plata", set_value("plata"));
	echo "</td><td>";
	echo form_error("plata", "<font color='red'>","</font>");
	echo "</td></tr><td>";
	echo form_submit("submit", "dodaj sluzbenika");
	echo "</td></tr></table>";
	echo form_close();

	//Brisanje sluzbenika forma
	echo form_open(site_url("Admin/obrisiSluzbenika"),"method=POST");
	echo "<table><tr><td>Ime:</td><td>";
	echo form_input("obrisi_ime", set_value("obrisi_ime"));
	echo "</td><td>";
	echo form_error("obrisi_ime", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>Prezime:<td>";
	echo form_input("obrisi_prezime", set_value("obrisi_prezime"));
	echo "</td><td>";
	echo form_error("obrisi_prezime", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>JMBG:<td>";
	echo form_input("obrisi_JMBG", set_value("obrisi_JMBG"));
	echo "</td><td>";
	echo form_error("obrisi_JMBG", "<font color='red'>","</font>");
	echo "</td></tr><tr><td>";
	echo form_submit("submit", "obrisi sluzbenika");
	echo "</td></tr></table>";
	echo form_close();

	//Dodavanje utakmice forma
	echo form_open(site_url("Admin/dodajUtakmicu"),"method=POST");
	echo "<table><tr><td>Tim 1:</td><td>";
	echo form_input("tim1", set_value("tim1"));
	echo "</td><td>";
	echo form_error("tim1", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>Tim 2:</td><td>";
	echo form_input("tim2", set_value("tim2"));
	echo "</td><td>";
	echo form_error("tim2", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>Vreme:<td>";
	echo form_input("vreme", set_value("vreme"));
	echo "</td><td>";
	echo form_error("vreme", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>Kvota ishod 1:</td><td>";
	echo form_input("jedan", set_value("jedan"));
	echo "</td><td>";
	echo form_error("jedan","<font color='red'>", "</font>");
	echo "</td></tr>";
	echo "<tr><td>Kvota ishod X:</td><td>";
	echo form_input("iks", set_value("iks"));
	echo "</td><td>";
	echo form_error("iks","<font color='red'>", "</font>");
	echo "</td></tr>";
	echo "<tr><td>Kvota ishod 2:</td><td>";
	echo form_input("dva", set_value("dva"));
	echo "</td><td>";
	echo form_error("dva","<font color='red'>", "</font>");
	echo "</td></tr><tr><td>";
	echo form_submit("submit", "dodaj Utakmicu");
	echo "</td></tr></table>";
	echo form_close();

	//Pormeni utakmicu forma
	echo form_open(site_url("Admin/promeniUtakmicu"),"method=POST");
	echo "<table><tr><td>Tim 1:</td><td>";
	echo form_input("promeni_tim1", set_value("promeni_tim1"));
	echo "</td><td>";
	echo form_error("promeni_tim1", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>Tim 2:</td><td>";
	echo form_input("promeni_tim2", set_value("promeni_tim2"));
	echo "</td><td>";
	echo form_error("promeni_tim2", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>Vreme:<td>";
	echo form_input("promeni_vreme", set_value("promeni_vreme"));
	echo "</td><td>";
	echo form_error("promeni_vreme", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>Kvota ishod 1:</td><td>";
	echo form_input("promeni_jedan", set_value("promeni_jedan"));
	echo "</td><td>";
	echo form_error("promeni_jedan","<font color='red'>", "</font>");
	echo "</td></tr>";
	echo "<tr><td>Kvota ishod X:</td><td>";
	echo form_input("promeni_iks", set_value("promeni_iks"));
	echo "</td><td>";
	echo form_error("promeni_iks","<font color='red'>", "</font>");
	echo "</td></tr>";
	echo "<tr><td>Kvota ishod 2:</td><td>";
	echo form_input("promeni_dva", set_value("promeni_dva"));
	echo "</td><td>";
	echo form_error("promeni_dva","<font color='red'>", "</font>");
	echo "</td></tr><tr><td>";
	echo form_submit("submit", "promeni Utakmicu");
	echo "</td></tr></table>";
	echo form_close();

	echo "<br><br>Sluzbenici:";
	if(isset($sluzbenici)){
		
		echo "<table>";
		foreach($sluzbenici as $sluzbenik){
			echo "<tr><td>".$sluzbenik->Ime."</td><td>".$sluzbenik->Prezime."</td><td>".$sluzbenik->JMBG."</td></tr>";
		}
		echo "</table>";
	}else{
		//nikada ne bi trebalo da udje u ovu granu
		echo "Nema sluzbenika";
	}

	echo "<br><br>Utakmice:";
	if(isset($utakmice)){
		
		echo "<table>";
		foreach($utakmice as $utakmica){
			echo "<tr><td>".$utakmica->Tim1."</td><td>".$utakmica->Tim2."</td><td>".$utakmica->Vreme."</td><td>".$utakmica->Jedan."</td><td>".$utakmica->Iks."</td><td>".$utakmica->Dva."</td></tr>";
		}
		echo "</table>";
	}else{
		//nikada ne bi trebalo da udje u ovu granu
		echo "Nema Utakmica";
	}

?>