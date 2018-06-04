<?php
	
	class Gost extends CI_Controller{
		
		private $utakmice;
		
		public function __construct(){
			parent::__construct();
			$this->load->model("ModelGost");
		}

		public function prikazi($glavniDeo, $data=NULL){
			$this->load->view("sablon/header_gost.php", $data);
			$this->load->view($glavniDeo, $data);
			$this->load->view("sablon/footer.php");
		}
		
		public function index($poruka=NULL){
			$this->utakmice=$this->ModelGost->dohvatiUtakmice();
			if($poruka==NULL){
				$this->prikazi("gostMain.php", array('utakmice'=>$this->utakmice));
			}else{
				$this->prikazi("gostMain.php", array('utakmice'=>$this->utakmice, 'poruka'=>$poruka));
			}
		}

		public function kreiranjeBrzog(){
			$iznos=$this->input->post("brzi_iznos");
			$ukupnaKvota=1.0;
			$vremePocetka=0;
			$vremePocetkaSek=0;
			$this->utakmice=$this->ModelGost->dohvatiUtakmice();
			$kreiran=FALSE;
			$idBrzog = 0;
			foreach ($this->utakmice as $utakmica) {
				
				if(isset($_POST["".$utakmica->IDUtakmice])){
					if(!$kreiran){
						$kreiran = TRUE;
						$idBrzog = $this->ModelGost->kreiranjeBrzog();
					}
					if($vremePocetka==0) {
						$vremePocetka=$utakmica->Vreme;
						$vremePocetkaSek=date_timestamp_get(date_create($utakmica->Vreme));
					} 
					else {
						$vremeSek = date_timestamp_get(date_create($utakmica->Vreme));
						if($vremeSek < $vremePocetkaSek){
							$vremePocetka=$utakmica->Vreme;
							$vremePocetkaSek=date_timestamp_get(date_create($utakmica->Vreme));
						}
					}
					$odigrano=$_POST["".$utakmica->IDUtakmice];
					$kvota=$this->ModelGost->dohvatiKvotu($utakmica->IDUtakmice, $odigrano);
					$ukupnaKvota=$ukupnaKvota * $kvota;
					$this->ModelGost->dodajNaTiket($idBrzog, $utakmica->IDUtakmice, $odigrano);
				}
			}
			if($kreiran==TRUE){
				$this->ModelGost->azurirajBrzi($idBrzog, $ukupnaKvota, $vremePocetka, $iznos);
				$this->index("ID vaseg brzog tiketa: ".$idBrzog);
			}
			else{
				$this->index("Niste izabrali ni jednu utakmicu");
			}
		}
		
		public function promenaBrzog(){
			$this->form_validation->set_rules("brzi_promena_id", "ID", "required");
			$this->form_validation->set_message("required", "Polje {field} je ostalo prazno");
			
			$id=$this->input->post("brzi_promena_id");

			if($this->form_validation->run()){
				$tiket=$this->ModelGost->dohvatiBrzi($id);
				if($tiket==NULL){
					$this->index("Pogresan id");
					return;
				}
				$this->prikazi("promenaBrzogGost.php", array('tiket'=>$tiket,'id'=>$id));
			}else{
				$this->index("Niste uneli id brzog tiketa");
			}
		}

		public function azuriranjePromeneGost(){
			$this->form_validation->set_rules("brzi_iznos_promena", "Iznos", "required");
			$this->form_validation->set_message("required", "Polje {field} je ostalo prazno");
			
			$id=$this->input->post("skriveno");
			$tiket=$this->ModelGost->dohvatiBrzi($id);
			
			if($this->form_validation->run()){
				$iznos=$this->input->post("brzi_iznos_promena");
				$ukupnaKvota=1.0;
				foreach ($tiket as $utakmica) {
					
					if(isset($_POST["".$utakmica->IDUtakmice."_promena"])){
						$odigrano=$_POST["".$utakmica->IDUtakmice."_promena"];
						$kvota=$this->ModelGost->dohvatiKvotu($utakmica->IDUtakmice, $odigrano);
						$ukupnaKvota=$ukupnaKvota * $kvota;
						$this->ModelGost->promeniNaTiketu($id, $utakmica->IDUtakmice, $odigrano);
					}
				}
				$this->ModelGost->azuriranjePromeneGost($id, $ukupnaKvota, $iznos);
				$this->index("Uspesno promenjen brzi tiket");
			}
			else{
				$this->prikazi("promenaBrzogGost.php", array('tiket'=>$tiket,'id'=>$id));
			}
		}
		
		public function login($poruka=NULL){
			$this->prikazi("login.php",array('poruka'=>$poruka));
		}
		
		public function ulogujse(){
			$this->form_validation->set_rules("korime","Korisnicko ime", "required");
			$this->form_validation->set_rules("lozinka","Lozinka", "required");
			$this->form_validation->set_message("required", "Polje {field} je ostalo prazno");
			if($this->form_validation->run()){
				if(isset($_POST["jeAdmin"])){
					$username=$this->input->post("korime");
					$password=$this->input->post("lozinka");
					if($this->ModelGost->loginAdmin($username, $password)==TRUE){
						$this->session->set_userdata('admin_username', $username);
						redirect("Admin");
					}else{
						$this->login("Neispravni podaci");
					}
				}
				else{
					if(!$this->ModelGost->dohvatiGosta($this->input->post("korime"))){
						$this->login("Neispravno Korisnicko ime");
					}else if(!$this->ModelGost->ispravanPassword($this->input->post('lozinka'))){
						$this->login("Neispravna Lozinka");
					}else{
						$korisnik=$this->ModelGost->korisnik;
						$this->session->set_userdata('korisnik', $korisnik);
						if($korisnik->nijeSluzbenik==1){
							redirect("Registrovani");
						}else{
							redirect("Sluzbenik");
						}
					}
				}
			}else{
				$this->login();
			}
			
		}
	}

?>