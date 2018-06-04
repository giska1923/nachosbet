<?php

	class Admin extends CI_Controller{

		public function __construct(){
			parent::__construct();
			$this->load->model("ModelAdmin");
		}
		
		public function prikazi($glavniDeo, $data=NULL){
			$this->load->view("sablon/header_admin.php", $data);
			$this->load->view($glavniDeo, $data);
			$this->load->view("sablon/footer.php");
		}

		public function index($poruka=NULL){
			$sluzbenici=$this->ModelAdmin->dohvatiSluzbenike();
			$utakmice=$this->ModelAdmin->dohvatiUtakmice();
			if($poruka==NULL){
				$this->prikazi("adminMain.php", array('sluzbenici'=>$sluzbenici, 'utakmice'=>$utakmice, 'admin'=>$this->session->userdata('admin_username')));
			}else{
				$this->prikazi("adminMain.php", array('sluzbenici'=>$sluzbenici, 'poruka'=>$poruka, 'utakmice'=>$utakmice, 'admin'=>$this->session->userdata('admin_username')));
			}		
		}

		public function dodajSluzbenika(){
			$this->form_validation->set_rules("ime", "Ime", "required");
			$this->form_validation->set_rules("prezime", "Prezime", "required");
			$this->form_validation->set_rules("username", "Username", "required");
			$this->form_validation->set_rules("password", "Password", "required");
			$this->form_validation->set_rules("JMBG", "JMBG", "required");
			$this->form_validation->set_rules("plata", "Plata", "required");
			$this->form_validation->set_message("required", "Polje {field} je ostalo prazno");

			if($this->form_validation->run()){
				$ime=$this->input->post("ime");
				$prezime=$this->input->post("prezime");
				$username=$this->input->post("username");
				$password=$this->input->post("password");
				$nijeSluzbenik=0;
				$JMBG=$this->input->post("JMBG");
				$plata=$this->input->post("plata");
				
				if($this->ModelAdmin->dodajSluzbenika($ime, $prezime, $username, $password, $nijeSluzbenik, $JMBG, $plata) == NULL){
					$this->index("JMBG ili username nisu jedinstveni");
					return;
				}
			}
			$this->index();
		}

		public function obrisiSluzbenika(){
			$this->form_validation->set_rules("obrisi_ime", "Ime", "required");
			$this->form_validation->set_rules("obrisi_prezime", "Prezime", "required");
			$this->form_validation->set_rules("obrisi_JMBG", "JMBG", "required");
			$this->form_validation->set_message("required", "Polje {field} je ostalo prazno");

			if($this->form_validation->run()){
				$ime=$this->input->post("obrisi_ime");
				$prezime=$this->input->post("obrisi_prezime");
				$JMBG=$this->input->post("obrisi_JMBG");
				if($this->ModelAdmin->obrisiSluzbenika($ime, $prezime, $JMBG)==NULL){
					$this->index("Uneti sluzbenik ne postoji u bazi");
					return;
				}
			}
			$this->index();
		}

		public function dodajUtakmicu(){
			$this->form_validation->set_rules("tim1", "Tim 1", "required");
			$this->form_validation->set_rules("tim2", "Tim 2", "required");
			$this->form_validation->set_rules("vreme", "Vreme", "required");
			$this->form_validation->set_rules("jedan", "Jedan", "required");
			$this->form_validation->set_rules("iks", "X", "required");
			$this->form_validation->set_rules("dva", "Dva", "required");
			$this->form_validation->set_message("required", "Polje {field} je ostalo prazno");

			if($this->form_validation->run()){
				$tim1=$this->input->post("tim1");
				$tim2=$this->input->post("tim2");
				$vreme=$this->input->post("vreme");
				$jedan=$this->input->post("jedan");
				$iks=$this->input->post("iks");
				$dva=$this->input->post("dva");
				$this->ModelAdmin->dodajUtakmicu($tim1, $tim2, $vreme, $jedan, $iks, $dva);
			}
			$this->index();
   		}

   		public function promeniUtakmicu(){
   			$this->form_validation->set_rules("promeni_tim1", "Tim 1", "required");
			$this->form_validation->set_rules("promeni_tim2", "Tim 2", "required");
			$this->form_validation->set_rules("promeni_vreme", "Vreme", "required");
			$this->form_validation->set_rules("promeni_jedan", "Jedan", "required");
			$this->form_validation->set_rules("promeni_iks", "X", "required");
			$this->form_validation->set_rules("promeni_dva", "Dva", "required");
			$this->form_validation->set_message("required", "Polje {field} je ostalo prazno");

			if($this->form_validation->run()){
				$tim1=$this->input->post("promeni_tim1");
				$tim2=$this->input->post("promeni_tim2");
				$vreme=$this->input->post("promeni_vreme");
				$jedan=$this->input->post("promeni_jedan");
				$iks=$this->input->post("promeni_iks");
				$dva=$this->input->post("promeni_dva");
				
				if($this->ModelAdmin->promeniUtakmicu($tim1, $tim2, $vreme, $jedan, $iks, $dva)==NULL){
					$this->index("Uneta utakmica ne postoji u bazi");
					return;
				}
			}
			$this->index();
   		}
		
		public function azurirajPonudu(){
			$utakmice=$this->ModelAdmin->dohvatiUtakmice();
			$this->prikazi("adminAzuriranje.php", array('utakmice' => $utakmice, 'admin'=>$this->session->userdata('admin_username')));
		}
		
		public function azuriranjeUtakmica(){
			$utakmice=$this->ModelAdmin->dohvatiUtakmice();
			foreach ($utakmice as $utakmica) {				//apdejtuje Ishode
				$odigrano=$_POST["".$utakmica->IDUtakmice];
				$this->ModelAdmin->postaviIshod($utakmica->IDUtakmice,$odigrano);
			}
			$this->ModelAdmin->postaviDobitne();
			
			$tiketi=$this->ModelAdmin->dohvatiTikete();
			
			foreach($tiketi as $tiket){
				$naTiketu=$this->ModelAdmin->dohvatiNaTiketu($tiket->IDTiket);
				
				foreach($naTiketu as $stavka){
					$tekma=$this->ModelAdmin->dohvatiUtakmicu($stavka->IDUtakmice);
					
					if($stavka->Odigrano != $tekma->Ishod){
						$this->ModelAdmin->oboriTiket($stavka->IDTiket);
						break;
					}
				}
			}
			
			$this->index();
		}

		public function obrisiPonudu(){
			$this->ModelAdmin->azurirajRacune();
			$this->ModelAdmin->obrisiPonudu();
			$this->index();
		}
		
		public function izlogujse(){
			$this->session->unset_userdata("admin_username");
			$this->session->sess_destroy();
			redirect("Gost");
		}
	}

?>