<?php
	
	class Registrovani extends CI_Controller{
		
		private $utakmice;
		
		public function __construct(){
			parent::__construct();
			$this->load->model("ModelRegistrovani");
		}
		
		public function prikazi($glavniDeo, $data=NULL){
			$this->load->view("sablon/header_registrovani.php", $data);
			$this->load->view($glavniDeo, $data);
			$this->load->view("sablon/footer.php");
		}

		public function index($poruka=NULL){
			$this->utakmice=$this->ModelRegistrovani->dohvatiUtakmice();
			$stanje=$this->ModelRegistrovani->dohvatiStanje($this->session->userdata('korisnik')->IDKorisnik);
			if($poruka==NULL){
				$this->prikazi("registrovaniMain.php", array('utakmice'=>$this->utakmice, 'korisnik'=>$this->session->userdata('korisnik'), 'stanje'=>$stanje));
			}else{
				$this->prikazi("registrovaniMain.php", array('utakmice'=>$this->utakmice, 'poruka'=>$poruka, 'korisnik'=>$this->session->userdata('korisnik'), 'stanje'=>$stanje));
			}
		}

		public function kreiranjeTiketa(){
			$this->form_validation->set_rules("iznos", "Iznos", "required");
			$this->form_validation->set_message("required", "Polje {field} je ostalo prazno");
			
			$iznos=$this->input->post("iznos");
			$ukupnaKvota=1.0;
			$vreme=0;
			$vremeSek=0;
			$this->utakmice=$this->ModelRegistrovani->dohvatiUtakmice();
			$kreiran=FALSE;
			$idTiketa = 0;
			
			if($this->form_validation->run()){
				$online;
				if($this->input->post("vrsta")=="online"){
					$online=TRUE;
				}else{
					$online=FALSE;
				}
				if(($online==TRUE && $this->ModelRegistrovani->proveraRacun($iznos)) || $online==FALSE){
						
					foreach ($this->utakmice as $utakmica) {
						if(isset($_POST["".$utakmica->IDUtakmice])){
							if(!$kreiran){
								$kreiran = TRUE;
								if($online){
									$idTiketa = $this->ModelRegistrovani->kreiranjeOnline();
								}else{
									$idTiketa = $this->ModelRegistrovani->kreiranjeBrzog();
								}
							}
							if($vreme==0) {
								$vreme=$utakmica->Vreme;
								$vremeSek=date_timestamp_get(date_create($utakmica->Vreme));
							} 
							else {
								$vremeTrenutnoSek = date_timestamp_get(date_create($utakmica->Vreme));
								if($online){	
									if($vremeTrenutnoSek > $vremeSek){
										$vreme=$utakmica->Vreme;
										$vremeSek=date_timestamp_get(date_create($utakmica->Vreme));
									}
								}else{
									if($vremeTrenutnoSek < $vremeSek){
										$vreme=$utakmica->Vreme;
										$vremeSek=date_timestamp_get(date_create($utakmica->Vreme));
									}
								}
							}
							$odigrano=$_POST["".$utakmica->IDUtakmice];
							$kvota=$this->ModelRegistrovani->dohvatiKvotu($utakmica->IDUtakmice, $odigrano);
							$ukupnaKvota=$ukupnaKvota * $kvota;
							$this->ModelRegistrovani->dodajNaTiket($idTiketa, $utakmica->IDUtakmice, $odigrano);
						}
					}
					if($online && $kreiran==TRUE){
						$this->ModelRegistrovani->azurirajOnline($idTiketa, $ukupnaKvota, $vreme, $iznos);
						$this->index();
					}else if($kreiran==TRUE){
						$this->ModelRegistrovani->azurirajBrzi($idTiketa, $ukupnaKvota, $vreme, $iznos);
						$this->index("ID vaseg brzog tiketa: ".$idTiketa);
					}
					else{
						$this->index("Niste odigrali ni jednu utakmicu");
					}
				}
				else{
					$this->index("Nemate dovoljno sredstava na racunu");
				}
			
			}
			else{
				$this->index();
			}
		}
		
		public function promenaBrzog(){
			$this->form_validation->set_rules("brzi_promena_id", "ID", "required");
			$this->form_validation->set_message("required", "Polje {field} je ostalo prazno");
			
			$id=$this->input->post("brzi_promena_id");

			if($this->form_validation->run()){
				$tiket=$this->ModelRegistrovani->dohvatiBrzi($id);
				if($tiket==NULL){
					$this->index("Pogresan id");
					return;
				}
				
				$stanje=$this->ModelRegistrovani->dohvatiStanje($this->session->userdata('korisnik')->IDKorisnik);
				$this->prikazi("promenaBrzogRegistrovani.php", array('tiket'=>$tiket,'id'=>$id, 'korisnik'=>$this->session->userdata('korisnik'), 'stanje'=>$stanje));
			}else{
				$this->index("Niste uneli id brzog tiketa");
			}
		}

		public function azuriranjePromeneRegistrovani(){
			$this->form_validation->set_rules("brzi_iznos_promena", "Iznos", "required");
			$this->form_validation->set_message("required", "Polje {field} je ostalo prazno");
			
			$id=$this->input->post("skriveno");
			$tiket=$this->ModelRegistrovani->dohvatiBrzi($id);
			
			if($this->form_validation->run()){
				$iznos=$this->input->post("brzi_iznos_promena");
				$ukupnaKvota=1.0;
				foreach ($tiket as $utakmica) {
					
					if(isset($_POST["".$utakmica->IDUtakmice."_promena"])){
						$odigrano=$_POST["".$utakmica->IDUtakmice."_promena"];
						$kvota=$this->ModelRegistrovani->dohvatiKvotu($utakmica->IDUtakmice, $odigrano);
						$ukupnaKvota=$ukupnaKvota * $kvota;
						$this->ModelRegistrovani->promeniNaTiketu($id, $utakmica->IDUtakmice, $odigrano);
					}
				}
				$this->ModelRegistrovani->azuriranjePromeneRegistrovani($id, $ukupnaKvota, $iznos);
				$this->index("Uspesno promenjen brzi tiket");
			}
			else{
				$stanje=$this->ModelRegistrovani->dohvatiStanje($this->session->userdata('korisnik')->IDKorisnik);
				$this->prikazi("promenaBrzogRegistrovani.php", array('tiket'=>$tiket,'id'=>$id, 'korisnik'=>$this->session->userdata('korisnik'), 'stanje'=>$stanje));
			}
		}
		
		public function mojiTiketi(){
			$id=$this->session->userdata('korisnik')->IDKorisnik;
			$utakmice=$this->ModelRegistrovani->odigraneUtakmice($id);
			if($utakmice==NULL){
				$this->index("Nemate odigranih tiketa");
			}
			else{
				$stanje=$this->ModelRegistrovani->dohvatiStanje($this->session->userdata('korisnik')->IDKorisnik);
				$this->prikazi("registrovaniStorniranje.php", array('utakmice'=>$utakmice, 'korisnik'=>$this->session->userdata('korisnik'), 'stanje'=>$stanje));
			}
		}
		
		public function storniranjeTiketa(){
			$this->form_validation->set_rules("brisanje_id", "ID", "required");
			$this->form_validation->set_message("required", "Polje {field} je ostalo prazno");
			
			$id=$this->input->post("brisanje_id");

			if($this->form_validation->run()){
				$this->ModelRegistrovani->stornirajTiket($id);
			}
			$this->index();
		}
		
		public function izlogujse(){
			$this->session->unset_userdata("korisnik");
			$this->session->sess_destroy();
			redirect("Gost");
		}
		
	}

?>