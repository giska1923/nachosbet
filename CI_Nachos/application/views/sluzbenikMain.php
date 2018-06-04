<?php
	
	if(isset($poruka)){
		echo $poruka;
	}
	
	//forma uplacivanje brzog
	echo form_open(site_url("Sluzbenik/uplataBrzog"),"method=POST");
	echo "<table><tr><td>ID brzog tiketa:</td><td>";
	echo form_input("id_brzi", set_value("id_brzi"));
	echo "</td><td>";
	echo form_error("id_brzi", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>";
	echo form_submit("submit", "uplati brzi");
	echo "</td></tr></table>";
	echo form_close();

	//forma uplata na racun
	echo form_open(site_url("Sluzbenik/uplataNaRacun"),"method=POST");
	echo "<table><tr><td>Ime:</td><td>";
	echo form_input("uplata_ime", set_value("uplata_ime"));
	echo "</td><td>";
	echo form_error("uplata_ime", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>Prezime:</td><td>";
	echo form_input("uplata_prezime", set_value("uplata_prezime"));
	echo "</td><td>";
	echo form_error("uplata_prezime", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>JMBG:</td><td>";
	echo form_input("uplata_JMBG", set_value("uplata_JMBG"));
	echo "</td><td>";
	echo form_error("uplata_JMBG", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>Iznos:</td><td>";
	echo form_input("uplata_iznos", set_value("uplata_iznos"));
	echo "</td><td>";
	echo form_error("uplata_iznos", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>";
	echo form_submit("submit", "uplati na racun");
	echo "</td></tr></table>";
	echo form_close();

	//forma isplata sa racuna
	echo form_open(site_url("Sluzbenik/isplataSaRacuna"),"method=POST");
	echo "<table><tr><td>Ime:</td><td>";
	echo form_input("isplata_ime", set_value("isplata_ime"));
	echo "</td><td>";
	echo form_error("isplata_ime", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>Prezime:</td><td>";
	echo form_input("isplata_prezime", set_value("isplata_prezime"));
	echo "</td><td>";
	echo form_error("isplata_prezime", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>JMBG:</td><td>";
	echo form_input("isplata_JMBG", set_value("isplata_JMBG"));
	echo "</td><td>";
	echo form_error("isplata_JMBG", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>Iznos:</td><td>";
	echo form_input("isplata_iznos", set_value("isplata_iznos"));
	echo "</td><td>";
	echo form_error("isplata_iznos", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>";
	echo form_submit("submit", "isplati sa racuna");
	echo "</td></tr></table>";
	echo form_close();

	//forma dodaj registrovanog korisnika
	echo form_open(site_url("Sluzbenik/dodajRegistrovanog"),"method=POST");
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
	echo "</td></tr><td colspan='2'>";
	echo form_submit("submit", "dodaj registrovanog korisnika");
	echo "</td></tr></table>";
	echo form_close();

	//forma obrisi registrovanog korisnika
	echo form_open(site_url("Sluzbenik/obrisiRegistrovanog"),"method=POST");
	echo "<table><tr><td>Username:</td><td>";
	echo form_input("obrisi_username", set_value("obrisi_username"));
	echo "</td><td>";
	echo form_error("obrisi_username", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td colspan='2'>";
	echo form_submit("submit", "obrisi registrovanog korisnika");
	echo "</td></tr></table>";
	echo form_close();

	echo "<br><br>Registrovani korisnici:";
	if(isset($korisnici)){
		
		echo "<table>";
		foreach($korisnici as $korisnik){
			echo "<tr><td>".$korisnik->Ime."</td><td>".$korisnik->Prezime."</td><td>".$korisnik->JMBG."</td></tr>";
		}
		echo "</table>";
	}else{
		//nikada ne bi trebalo da udje u ovu granu
		echo "Nema Utakmica";
	}
?>