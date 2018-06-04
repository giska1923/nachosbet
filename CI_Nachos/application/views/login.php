<?php

	echo form_open(site_url("Gost/ulogujse"),"method=POST");
	if(isset($poruka)){
		echo "<font color='red'>$poruka</font><br>";
	}
	echo "<table><tr><td>Korisnicko ime:<td>";
	echo form_input("korime", set_value("korime"));
	echo "</td><td>";
	echo form_error("korime", "<font color='red'>","</font>");
	echo "</td></tr>";
	echo "<tr><td>Lozinka:</td><td>";
	echo form_password("lozinka");
	echo "</td><td>";
	echo form_error("lozinka","<font color='red'>", "</font>");
	echo "</td></tr><tr><td>";
	echo "Admin<input type='checkbox' name='jeAdmin' value='jeste'/></td><td>";
	echo form_submit("submit", "Log in");
	echo "</td></tr></table>";

?>