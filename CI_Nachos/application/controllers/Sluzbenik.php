<?php

	class Sluzbenik extends CI_Controller{

		public function __construct(){
			parent::__construct();
			$this->load->model("ModelSluzbenik");
		}
		
		public function prikazi($glavniDeo, $data=NULL){
			$this->load->view("sablon/header_sluzbenik.php", $data);
			$this->load->view($glavniDeo, $data);
			$this->load->view("sablon/footer.php");
		}

		public function index($poruka=NULL){
			$korisnici=$this->ModelSluzbenik->dohvatiKorisnike();
			if($poruka==NULL){
				$this->prikazi("sluzbenikMain.php", array("korisnici"=>$korisnici, 'korisnik'=>$this->session->userdata('korisnik')));
			}else{
				$this->prikazi("sluzbenikMain.php", array("korisnici"=>$korisnici, 'poruka'=>$poruka, 'korisnik'=>$this->session->userdata('korisnik')));
			}
		}

		//Milim da je ovo samo brisanje iz tabele u sustini
		public function uplataBrzog(){
			$this->form_validation->set_rules("id_brzi", "ID Tiketa", "required");
			$this->form_validation->set_message("required", "Polje {field} je ostalo prazno");

			if($this->form_validation->run()){
				$id=$this->input->post("id_brzi");
				if($this->ModelSluzbenik->uplataBrzog($id)==NULL){
					$this->index("Brzi tiket ne postoji u bazi");
					return;
				}
			}
			$this->index();
		}

		public function uplataNaRacun(){
			$this->form_validation->set_rules("uplata_ime", "Ime", "required");
			$this->form_validation->set_rules("uplata_prezime", "Prezime", "required");
			$this->form_validation->set_rules("uplata_JMBG", "JMBG", "required");
			$this->form_validation->set_rules("uplata_iznos", "Iznos", "required");
			$this->form_validation->set_message("required", "Polje {field} je ostalo prazno");

			if($this->form_validation->run()){
				$ime=$this->input->post("uplata_ime");
				$prezime=$this->input->post("uplata_prezime");
				$JMBG=$this->input->post("uplata_JMBG");
				$iznos=$this->input->post("uplata_iznos");
				
				if($iznos<=0){
					$this->index("Pogresno unet iznos");
					return;
				}
				if($this->ModelSluzbenik->uplataNaRacun($ime, $prezime, $JMBG, $iznos)==NULL){
					$this->index("Uneti korisnik ne postoji u bazi");
					return;
				}
			}
			$this->index();
		}

		public function isplataSaRacuna(){
			$this->form_validation->set_rules("isplata_ime", "Ime", "required");
			$this->form_validation->set_rules("isplata_prezime", "Prezime", "required");
			$this->form_validation->set_rules("isplata_JMBG", "JMBG", "required");
			$this->form_validation->set_rules("isplata_iznos", "Iznos", "required");
			$this->form_validation->set_message("required", "Polje {field} je ostalo prazno");

			if($this->form_validation->run()){
				$ime=$this->input->post("isplata_ime");
				$prezime=$this->input->post("isplata_prezime");
				$JMBG=$this->input->post("isplata_JMBG");
				$iznos=$this->input->post("isplata_iznos");

				$ret=$this->ModelSluzbenik->isplataSaRacuna($ime, $prezime, $JMBG, $iznos);
				if($ret==1){
					$this->index("Uneti korisnik ne postoji u bazi");
					return;
				}
				if($ret==2){
					$this->index("Korisnik nema dovoljno sredstava na racunu");
					return;
				}
			}
			$this->index();
		}

		public function dodajRegistrovanog(){
			$this->form_validation->set_rules("ime", "Ime", "required");
			$this->form_validation->set_rules("prezime", "Prezime", "required");
			$this->form_validation->set_rules("username", "Username", "required");
			$this->form_validation->set_rules("password", "Password", "required");
			$this->form_validation->set_rules("JMBG", "JMBG", "required");
			$this->form_validation->set_message("required", "Polje {field} je ostalo prazno");

			if($this->form_validation->run()){
				$ime=$this->input->post("ime");
				$prezime=$this->input->post("prezime");
				$username=$this->input->post("username");
				$password=$this->input->post("password");
				$nijeSluzbenik=1;
				$JMBG=$this->input->post("JMBG");
				$racun=0;
				
				if($this->ModelSluzbenik->dodajRegistrovanog($ime, $prezime, $username, $password, $nijeSluzbenik, $JMBG, $racun)==NULL){
					$this->index("JMBG ili username nisu jedinstveni");
					return;
				}
			}
			$this->index();
		}

		public function obrisiRegistrovanog(){
			$this->form_validation->set_rules("obrisi_username", "Username", "required");
			$this->form_validation->set_message("required", "Polje {field} je ostalo prazno");

			if($this->form_validation->run()){
				$username=$this->input->post("obrisi_username");
				if($this->ModelSluzbenik->obrisiRegistrovanog($username)==NULL){
					$this->index("Pogresno unet username");
					return;
				}
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