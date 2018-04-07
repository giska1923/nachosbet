# nachosbet

1. Uvod
1.1 Rezime
Projekat NachosBet je deo praktične nastave predmeta Principi softverskog inženjerstva. Sajt je namenjen ljubiteljima sportskih i igara na sreću. 
1.2 Namena dokumenta I ciljne grupe
Ovaj dokument definiše namenu projekta, kategoriju korisnika i osnovne funkcionalne i druge zahteve. Dokument je namenjen svim članovima projektnog tima.
2. Opis problema
S obzirom na želju ljudi da oprobaju svoju sreću u sportskoj prognozi i manjka njihovog slobodnog vremena došli smo na ideju da napravimo sajt koji bi im to olakšao. Ideja je da se ljudima omogući klađenje od kuće bez odlaska u filijalu.
3. Kategorije korisnika
3.1 Gost
Može da pregleda dnevnu ponudu i sastavi tiket (Brzi tiket) za koji mu se izgeneriše kod sa kojim može da izvrši uplatu u nekoj od poslovnica.
3.2 Registrovani korisnik 
Ima sve pogodnosti koje ima gost i uz to raspolaže novčanim sredstvima koja služe za online klađenje. Sa tim novcem može da vrši uplatu tiketa bez odlaska u filijalu. Takođe, u bilo kojoj filijali može da vrši uplatu i isplatu novca sa računa.
3.3 Administrator
Ažurira bazu podataka dnevne ponude sportskih događaja i zaposlenih službenika. Može po potrebi da ažurira i bazu podataka korisnika.
3.4 Službenik
		Ažurira bazu podataka naloga korisnika.
	
4. Opis proizvoda
4.1 Pregled arhitekture sistema
Sajt će na serverskoj strani biti realizovan preko PHP tehnologije uz korišćenje baza podataka realizovanih MySql tehnologijom.
4.2 Pregled karakteristika
Korist za korisnika:
1) Korisnici imaju preglednu sportsku ponudu
2) Pristup sa svakog personalnog računara koji je povezan na internet
3) Lako administriranje
Karakteristika koja je obezbeđuje:
1) Sistem je neprestano online, korisnik u svakom trenutku kada je povezan na internet može da pregleda tekuću ponudu
2) Interfejs zasnovan na Web browseru, HTMLu i Javascript-u ne zahteva nikakva posebna prilagođavanja na klijentskoj strani
3) Administrator pristupa odgovarajućoj bazi podataka, u zavisnosti od potrebne akcije

5. Funkcionalni zahtevi
5.1 Registracija korisnika
Službenik kreira nalog korisniku nakon provere validnosti priloženih podataka (JMBG, lična karta) unošenjem korisnika u bazu.
5.2 Prijavljivanje korisnika
		Korisnik se prijavljuje na sajt putem korisničkog imena i šifre.
5.3 Administriranje sajta
Administrator je zadužen da održava dnevnu ponudu sportskih događaja ažurnom kao i da vodi evidenciju o zaposlenim službenicima.	
5.4 Pregled dnevne ponude sportskih događaja
Svi korisnici imaju mogućnost pregleda dnevne ponude sportskih događaja u svakom trenutku.
5.5 Kreiranje brzog tiketa
Gosti sajta kao i registrovani korisnici imaju mogućnost kreiranja brzih tiketa iz dnevne ponude.
5.6 Kreiranje online tiketa
Registrovani korisnici mogu da kreiraju online tikete koristeći sredstva koja su im raspoloživa na računu.

6. Pretpostavke i ograničenja
Sistem treba isprojektovati tako da dodavanje novih dnevnih ponuda sportskih događaja bude što jednostavnije.
Jedno fizičko lice ne može kreirati više od jednog naloga niti pristupiti svom nalogu sa više različitih uređaja u istom trenutku.
7. Kvalitet
Potrebno je izvršiti funkcionalno (black-box) testiranje svih funkcija sistema. Potrebno je testirati i otpornost na greške.

8. Nefunkcionalni zahtevi
8.1 Sistemski zahtevi
Serverski deo treba da se izvršava na bilo kom Web serveru koji podržava PHP servis. Korisnički interfejs treba da bude raspoloživ za većinu poznatih internet pretraživača. Potrebno je obezbediti da prikaz strana po dizajnu bitno ne odstupa u zavisnosti od toga koji se korisnički interfejs koristi (Mozilla Firefox, Internet Explorer itd.).
8.2 Ostali zahtevi
Neophodno je obezbediti dinamičan odziv i vizuelnu dinamičnost stranice.
9. Zahtev za korisničkom dokumentacijom
9.1 Uputstva korišćenja sajta
		Potrebna su službenicima:
		1) Način kreiranja korisničkih naloga
		2) Način uplate i isplate
9.2 Označavanje	
Zaglavlje svih stranica trebalo bi da sadrži logo i naziv NachosBet sajta. 

10. Plan i prioriteti 
 
Razvoj NachosBet-a treba da se odvija iterativno. Prva verzija trebalo bi da obuhvati minimalno sledeće funkcionalnosti: 
•	Pregled ponude od strane registrovanih korisnika i gostiju
•	Dodavanje mečeva za opklade od strane administratora
•	Registrovanje novih članova od strane službenika
•	Uplata i isplata sa i na račun korisnika
