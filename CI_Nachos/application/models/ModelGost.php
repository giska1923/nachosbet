<?php
	
	class ModelGost extends CI_Model{
		public $korisnik;
		
		public function __construct(){
			parent::__construct();
		}

		public function dohvatiUtakmice(){
			$query=$this->db->where("Ishod", NULL);
			$query=$this->db->get('Utakmice');
			$result=$query->result();
			return $result;
   		}

		public function kreiranjeBrzog(){
			$dataTiket=array(
	        	'Ukup_kvota'=>0,
	        	'Uplata'=>0
	        );

	        $this->db->trans_begin();
			$this->db->insert('Tiket', $dataTiket);
			$insert_id = $this->db->insert_id();
			
	        if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
			}
			else {
				$this->db->trans_commit();
			}
			$date=date("2099-12-12 00:00:00");
			$dataBrzi=array(
	        	'IDTiket'=>$insert_id,
	        	'Vreme_pocetka'=>$date
	        );
	        
	        $this->db->insert('Brzi', $dataBrzi);

			return $insert_id;
		}
		
		public function dodajNaTiket($idBrzog, $idUtakmice, $odigrano){
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
			$dataTiket=array(
	        	'IDTiket'=>$idBrzog,
	        	'IDUtakmice'=>$idUtakmice,
				'Odigrano'=>$odigranoCH
	        );
			$this->db->insert('Na_tiketu', $dataTiket);
		}
		
		public function promeniNaTiketu($idBrzog, $idUtakmica, $odigrano){
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
			$dataTiket=array(
				'Odigrano'=>$odigranoCH
	        );
			
			$this->db->where('IDTiket', $idBrzog);
			$this->db->where('IDUtakmice', $idUtakmica);
			$this->db->update('Na_tiketu', $dataTiket);
		}
		
		public function azurirajBrzi($idBrzog, $ukupnaKvota, $vremePocetka, $iznos){
			$data = array(
				'Ukup_kvota' => $ukupnaKvota,
				'Uplata' => $iznos
			);

			$this->db->where("IDTiket", $idBrzog);
			$this->db->update('Tiket', $data);
			
			$dataBrzi = array(
				'Vreme_pocetka' => $vremePocetka
			);

			$this->db->where("IDTiket", $idBrzog);
			$this->db->update('Brzi', $dataBrzi);
		}
		
		public function azuriranjePromeneGost($idBrzog, $ukupnaKvota, $iznos){
			$data = array(
				'Ukup_kvota' => $ukupnaKvota,
				'Uplata' => $iznos
			);

			$this->db->where("IDTiket", $idBrzog);
			$this->db->update('Tiket', $data);
		}
		
		public function dohvatiKvotu($id, $odigrano){
	        $this->db->where("IDUtakmice", $id);
	        $this->db->from('Utakmice');
	        $query=$this->db->get();
	        return $query->row()->$odigrano;
		}
		
		public function dohvatiBrzi($id){
	        $this->db->where("IDTiket", $id);
	        $this->db->from('Na_tiketu');
	        $query=$this->db->get();			
			$utakmice=$query->result();
			if(empty($utakmice)){
				return NULL;
			}
			
			$niz=array();
			$cnt=0;
			foreach($utakmice as $utakmica){
				$niz[$cnt]=$utakmica->IDUtakmice;
				$cnt=$cnt+1;
			}
			$this->db->where_in("IDUtakmice", $niz);
			$this->db->from('Utakmice');
			$ret=$this->db->get();
			return $ret->result();
		}
		
		public function loginAdmin($username, $password){
			$result=$this->db->where('username', $username)->get('Admin');
			$admin=$result->row();
			if($admin!=NULL){
				if($password==$admin->password){
					return TRUE;
				}
			}
			return FALSE;
		}
		
		public function dohvatiGosta($username){
			$result=$this->db->where('username', $username)->get('Korisnik');
			$korisnik=$result->row();
			if($korisnik!=NULL){
				$this->korisnik=$korisnik;
				return TRUE;
			}
			return FALSE;
		}
		
		public function ispravanPassword($password){
			if($this->korisnik->password==$password){
				return TRUE;
			}
			return FALSE;
		}
	}

?>