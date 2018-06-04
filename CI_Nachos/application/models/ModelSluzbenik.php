<?php
	
	class ModelSluzbenik extends CI_Model{

		public function __construct(){
			parent::__construct();
		}

		public function uplataBrzog($id){
			$this->db->where("IDTiket", $id);
	        $this->db->from('Tiket');
	        $query=$this->db->get();			
			$brzi=$query->result();
			if(empty($brzi)){
				return NULL;
			}
			
	        $this->db->where("IDTiket", $id);
	        $this->db->delete('Na_tiketu');
			
	        $this->db->where("IDTiket", $id);
	        $this->db->delete('Tiket');
			
	        $this->db->where("IDTiket", $id);
	        $this->db->delete('Brzi');
			return 1;
		}

		public function uplataNaRacun($ime, $prezime, $JMBG, $iznos){
			$this->db->where("Ime", $ime);
			$this->db->where("Prezime", $prezime);
			$this->db->where("JMBG", $JMBG);
			$this->db->from('Korisnik');
	        $query=$this->db->get();
			if(empty($query->result())){
				return NULL;
			}
		
	        $id=$query->row()->IDKorisnik;
			
			$this->db->where("IDKorisnik", $id);
			$this->db->from('Registrovani');
	        $query=$this->db->get();
	        $racun=$query->row()->Racun;
			$racun=$racun + $iznos;
			$data = array(
				'Racun' => $racun
			);

			$this->db->where("IDKorisnik", $id);
			$this->db->update('Registrovani', $data);
			return 1;
		}

		public function isplataSaRacuna($ime, $prezime, $JMBG, $iznos){
			$this->db->where("Ime", $ime);
			$this->db->where("Prezime", $prezime);
			$this->db->where("JMBG", $JMBG);
			$this->db->from('Korisnik');
	        $query=$this->db->get();
			if(empty($query->result())){
				return 1;
			}
			
	        $id=$query->row()->IDKorisnik;
			
			$this->db->where("IDKorisnik", $id);
			$this->db->from('Registrovani');
	        $query=$this->db->get();
	        $racun=$query->row()->Racun;
			if($racun < $iznos){
				return 2;
			}
			$racun-=$iznos;
		
			$data = array(
				'Racun' => $racun
			);

			$this->db->where("IDKorisnik", $id);
			$this->db->update('Registrovani', $data);
			return 3;
		}

		public function dodajRegistrovanog($ime, $prezime, $username, $password, $nijeSluzbenik, $JMBG, $racun){
			$this->db->where("JMBG",$JMBG)->or_where("username",$username);
			$query=$this->db->get('Korisnik');
			$result=$query->result();
			
			if(!empty($result)){
				return NULL;
			}
			$dataKorisnik=array(
	        	'Ime'=>$ime,
	        	'Prezime'=>$prezime,
	        	'username'=>$username,
	        	'password'=>$password,
	        	'nijeSluzbenik'=>$nijeSluzbenik,
	        	'JMBG'=>$JMBG
	        );

	        $this->db->trans_begin();
	        $this->db->insert('Korisnik', $dataKorisnik);
	        if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
			}
			else {
				$this->db->trans_commit();
			}
	        $this->db->where("username", $username);
	        $this->db->from('Korisnik');
	        $query=$this->db->get();
	        $id=$query->row()->IDKorisnik;
			
			$dataRegistrovani=array(
	        	'IDKorisnik'=>$id,
	        	'Racun'=>$racun
	        );
	        
	        $this->db->insert('Registrovani', $dataRegistrovani);
			return 1;
		}

		public function obrisiRegistrovanog($username){
			$this->db->where("username",$username);
			$query=$this->db->get('Korisnik');
			$result=$query->result();
			
			if(empty($result)){
				return NULL;
			}
			
			$this->db->where("username", $username);
	        $this->db->from('Korisnik');
	        $query=$this->db->get();
	        $id=$query->row()->IDKorisnik;

	        $this->db->where('IDKorisnik', $id);
	        $this->db->delete('Korisnik');

	        $this->db->where('IDKorisnik', $id);
	        $this->db->delete('Registrovani');
			return 1;
		}

		public function dohvatiKorisnike(){
			$query=$this->db->where("nijeSluzbenik", 1);
			$query=$this->db->get('Korisnik');
			$result=$query->result();
			return $result;
		}
	}

?>