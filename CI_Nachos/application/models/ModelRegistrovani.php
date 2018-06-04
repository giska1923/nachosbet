<?php
	
	class ModelRegistrovani extends CI_Model{

		public function __construct(){
			parent::__construct();
		}

		public function dohvatiUtakmice(){
			$query=$this->db->where("Ishod", NULL);
			$query=$this->db->get('Utakmice');
			$result=$query->result();
			return $result;
   		}
		
		public function dohvatiStanje($id){
			$this->db->where("IDKorisnik", $id);
			$query=$this->db->get('Registrovani');
			$result=$query->row();
			return $result->Racun;
		}
		
		public function kreiranjeOnline(){
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
			$dataOnline=array(
	        	'IDTiket'=>$insert_id,
	        	'Vreme_kraja'=>$date
	        );
	        
	        $this->db->insert('Online', $dataOnline);

			return $insert_id;
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
		
		public function proveraRacun($iznos){
			$id=$this->session->userdata('korisnik')->IDKorisnik;
			$this->db->where('IDKorisnik', $id);
			$this->db->from('Registrovani');
			$query=$this->db->get();
			$result=$query->row();
			
			if($iznos<=$result->Racun){
				$novi=$result->Racun-$iznos;
				$dataRacun=array(
					'Racun'=>$novi
				);
				
				$this->db->where('IDKorisnik', $id);
				$this->db->update('Registrovani', $dataRacun);
				return TRUE;
			}
			return FALSE;
		}
		
		public function azurirajOnline($idTiketa, $ukupnaKvota, $vreme, $iznos){
			$data = array(
				'Ukup_kvota' => $ukupnaKvota,
				'Uplata' => $iznos
			);

			$this->db->where("IDTiket", $idTiketa);
			$this->db->update('Tiket', $data);
			
			$dataOnline = array(
				'Vreme_kraja' => $vreme
			);

			$this->db->where("IDTiket", $idTiketa);
			$this->db->update('Online', $dataOnline);
			
			$id=$this->session->userdata('korisnik')->IDKorisnik;
			$dataOdigrani = array(
				'IDTiket' => $idTiketa,
				'IDKorisnik' => $id
			);
			
			$this->db->insert('Odigrani', $dataOdigrani);
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
		
		public function azuriranjePromeneRegistrovani($idBrzog, $ukupnaKvota, $iznos){
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
		
		public function odigraneUtakmice($id){
	        $this->db->where("IDKorisnik", $id);
	        $this->db->from('Odigrani');
	        $query=$this->db->get();		
			$tiketi=$query->result();
			if(empty($tiketi)){
				return NULL;
			}
			
			$cnt=0;
			$niz=array();
			
			foreach($tiketi as $tiket){
				$niz[$cnt]=$tiket->IDTiket;
				$cnt+=1;
			}
			$this->db->where_in("IDTiket",$niz);
			$this->db->from('Na_tiketu');
			$ret=$this->db->get();
	        return $ret->result();
		}
		
		public function stornirajTiket($id){
			$this->db->where("IDTiket", $id);
	        $this->db->delete('Na_tiketu');
			
	        $this->db->where("IDTiket", $id);
	        $this->db->delete('Odigrani');
			
	        $this->db->where("IDTiket", $id);
	        $this->db->delete('Online');
			
			$this->db->where("IDTiket",$id);
			$this->db->from('Tiket');
			$res=$this->db->get();
			$iznos=$res->row()->Uplata;
			
	        $this->db->where("IDTiket", $id);
	        $this->db->delete('Tiket');
			
			$idK=$this->session->userdata('korisnik')->IDKorisnik;
			$this->db->where("IDKorisnik",$idK);
			$this->db->from('Registrovani');
			$res=$this->db->get();
			$iznosStari=$res->row()->Racun;
			$iznos+=$iznosStari;
			$data = array(
				'Racun' => $iznos
			);

			$this->db->where("IDKorisnik", $idK);
			$this->db->update('Registrovani', $data);
		}
	}

?>