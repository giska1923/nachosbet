<?php
	
	class ModelAdmin extends CI_Model{

		public function __construct(){
			parent::__construct();
		}

		public function dohvatiSluzbenike(){
			$query=$this->db->where("nijeSluzbenik", 0);
			$query=$this->db->get('Korisnik');
			$result=$query->result();
			return $result;
		}

		public function dodajSluzbenika($ime, $prezime, $username, $password, $nijeSluzbenik, $JMBG, $plata){
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

	        $dataSluzbenik=array(
	        	'IDSluzbenik'=>$id,
	        	'Plata'=>$plata
	        );
	        
	        $this->db->insert('Sluzbenik', $dataSluzbenik);
			return 1;
   		}

   		public function obrisiSluzbenika($ime, $prezime, $JMBG){
	        $this->db->where('Ime',$ime);
	        $this->db->where('Prezime',$prezime);
	        $this->db->where("JMBG", $JMBG);
	        $this->db->from('Korisnik');
	        $query=$this->db->get();
			if(empty($query->result())){
				return NULL;
			}
			
	        $id=$query->row()->IDKorisnik;

	        $this->db->where('Ime',$ime);
	        $this->db->where('Prezime',$prezime);
	        $this->db->where('JMBG',$JMBG);
	        $this->db->delete('Korisnik');

	        $this->db->where('IDSluzbenik', $id);
	        $this->db->delete('Sluzbenik');
			return 1;
   		}

   		public function dohvatiUtakmice(){
			$query=$this->db->where("Ishod", NULL);
			$query=$this->db->get('Utakmice');
			$result=$query->result();
			return $result;
   		}

   		public function dodajUtakmicu($tim1, $tim2, $vreme, $jedan, $iks, $dva){
   			$dataUtakmica=array(
	        	'Tim1'=>$tim1,
	        	'Tim2'=>$tim2,
	        	'Vreme'=>$vreme,
	        	'Jedan'=>$jedan,
	        	'Iks'=>$iks,
	        	'Dva'=>$dva,
	        );
	        $this->db->insert('Utakmice', $dataUtakmica);
   		}

   		public function promeniUtakmicu($tim1, $tim2, $vreme, $jedan, $iks, $dva){
			$this->db->where("Tim1", $tim1);
			$this->db->where("Tim2", $tim2);
			$this->db->where("Vreme", $vreme);
			$this->db->from('Utakmice');
	        $query=$this->db->get();
			if(empty($query->result())){
				return NULL;
			}
			
			$data = array(
				'Jedan' => $jedan,
				'Iks' => $iks,
				'Dva' => $dva,
			);

			$query=$this->db->where("Tim1", $tim1);
			$query=$this->db->where("Tim2", $tim2);
			$query=$this->db->where("Vreme", $vreme);
			$this->db->update('Utakmice', $data);
			return 1;
   		}

		public function postaviIshod($idUtakmice,$odigrano){
			$odigranoCH;
			if($odigrano == "Jedan"){
				$odigranoCH = '1';
			}
			else if($odigrano == "Iks"){
				$odigranoCH = 'X';
			}
			else{
				$odigranoCH = '2';
			}
			$data = array(
				'Ishod' => $odigranoCH
			);

			$query=$this->db->where("IDUtakmice", $idUtakmice);
			$this->db->update('Utakmice', $data);
		}
		
		public function postaviDobitne(){
			$data = array(
				'dobitan' => 1
			);
			
			$query=$this->db->where("dobitan", 0);
			$this->db->update('Odigrani', $data);
		}
		
		public function dohvatiTikete(){
			$query=$this->db->get('Tiket');
			$result=$query->result();
			return $result;			
		}
		
		public function dohvatiTiket($id){
			$this->db->where("IDTiket", $id);
			$query=$this->db->get('Tiket');
			$result=$query->row();
			return $result;			
		}
		
		public function dohvatiNaTiketu($id){
			$this->db->where("IDTiket", $id);
			$query=$this->db->get('Na_tiketu');
			$result=$query->result();
			return $result;			
		}
		
		public function dohvatiUtakmicu($id){
			$this->db->where("IDUtakmice", $id);
			$query=$this->db->get('Utakmice');
			$result=$query->row();
			return $result;	
		}
		
		public function dohvatiRegistrovanog($id){
			$this->db->where("IDKorisnik", $id);
			$query=$this->db->get('Registrovani');
			$result=$query->row();
			return $result;	
		}
		
		public function oboriTiket($id){
			$data = array(
				'dobitan' => 0
			);
			
			$query=$this->db->where("IDTiket", $id);
			$this->db->update('Odigrani', $data);			
		}
		
		public function obrisiPonudu(){
			$this->db->empty_table('Odigrani');
			$this->db->empty_table('Online');
			$this->db->empty_table('Brzi');
			$this->db->empty_table('Na_tiketu');
			$this->db->empty_table('Utakmice');
			$this->db->empty_table('Tiket');
		}
		
		public function azurirajRacune(){
			$this->db->where("dobitan", 1);
			$query=$this->db->get('Odigrani');
			$result=$query->result();
			
			foreach($result as $dobitan){
				$tiket=$this->dohvatiTiket($dobitan->IDTiket);
				$iznos=$tiket->Ukup_kvota*$tiket->Uplata;
				
				$registrovani=$this->dohvatiRegistrovanog($dobitan->IDKorisnik);
				$racun=$registrovani->Racun;
				
				$iznos=$iznos+$racun;
				
				$dataRacun=array(
					'Racun'=>$iznos
				);
				
				$this->db->where('IDKorisnik', $dobitan->IDKorisnik);
				$this->db->update('Registrovani', $dataRacun);
			}
		}
	}

?>