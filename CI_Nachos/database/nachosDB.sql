SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `nachosDB` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `nachosDB`;

CREATE TABLE `Admin`
(
	`username`           varchar(20) COLLATE utf8_unicode_ci  NOT NULL ,
	`password`           varchar(20) COLLATE utf8_unicode_ci NOT NULL ,
	CONSTRAINT `XPKAdmin` PRIMARY KEY  (`username` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `Brzi`
( 
	`IDTiket`            int(11)  NOT NULL ,
	`Vreme_pocetka`      datetime  NOT NULL ,
	CONSTRAINT `XPKBrzi` PRIMARY KEY  (`IDTiket` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `Korisnik`
( 
	`IDKorisnik`         int(11)  NOT NULL  AUTO_INCREMENT ,
	`Ime`                varchar(20) COLLATE utf8_unicode_ci NOT NULL ,
	`Prezime`            varchar(20) COLLATE utf8_unicode_ci NOT NULL ,
	`username`           varchar(20) COLLATE utf8_unicode_ci NOT NULL ,
	`password`           varchar(20) COLLATE utf8_unicode_ci NOT NULL ,
	`nijeSluzbenik`      tinyint(1)  NOT NULL ,
	`JMBG`               varchar(13) COLLATE utf8_unicode_ci NOT NULL ,
	CONSTRAINT `XPKKorisnik` PRIMARY KEY  (`IDKorisnik` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `Na_tiketu`
( 
	`IDTiket`            int(11)  NOT NULL ,
	`Odigrano`           varchar(1) COLLATE utf8_unicode_ci  NULL ,
	CONSTRAINT `ishod_30837925`
		CHECK  ( `Odigrano`='1' OR `Odigrano`='2' OR `Odigrano`='X' ),
	`IDUtakmice`         int(11)  NOT NULL ,
	CONSTRAINT `XPKNa_tiketu` PRIMARY KEY  (`IDTiket` ASC,`IDUtakmice` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `Odigrani`
( 
	`IDTiket`            int(11)  NOT NULL ,
	`IDKorisnik`         int(11)  NOT NULL ,
	`dobitan`            tinyint(1)  NULL DEFAULT '0',
	CONSTRAINT `XPKOdigrani` PRIMARY KEY  (`IDTiket` ASC,`IDKorisnik` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `Online`
( 
	`IDTiket`            int(11)  NOT NULL ,
	`Vreme_kraja`        datetime  NOT NULL ,
	CONSTRAINT `XPKOnline` PRIMARY KEY  (`IDTiket` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `Registrovani`
( 
	`IDKorisnik`         int(11)  NOT NULL ,
	`Racun`              int(11)  NULL DEFAULT '0',
	CONSTRAINT `XPKRegistrovani` PRIMARY KEY  (`IDKorisnik` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `Sluzbenik`
( 
	`IDSluzbenik`        int(11)  NOT NULL ,
	`Plata`              int(11)  NULL ,
	CONSTRAINT `XPKSluzbenik` PRIMARY KEY  (`IDSluzbenik` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `Tiket`
( 
	`IDTiket`            int(11)  NOT NULL  AUTO_INCREMENT ,
	`Ukup_kvota`         float(7,4)  NOT NULL ,
	`Uplata`             int(11)  NOT NULL ,
	CONSTRAINT `XPKTiket` PRIMARY KEY  (`IDTiket` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `Utakmice`
( 
	`IDUtakmice`         int(11)  NOT NULL  AUTO_INCREMENT ,
	`Tim1`               varchar(20) COLLATE utf8_unicode_ci NOT NULL ,
	`Tim2`               varchar(20) COLLATE utf8_unicode_ci NOT NULL ,
	`Vreme`              datetime  NOT NULL ,
	`Jedan`                  float(7,4)  NOT NULL ,
	`Iks`                  float(7,4)  NOT NULL ,
	`Dva`                  float(7,4)  NOT NULL ,
	`Ishod`              varchar(1) COLLATE utf8_unicode_ci NULL ,
	CONSTRAINT `ishod_1599545314`
		CHECK  ( `Ishod`='1' OR `Ishod`='2' OR `Ishod`='X' ),
	CONSTRAINT `XPKUtakmice` PRIMARY KEY  (`IDUtakmice` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `Brzi`
	ADD CONSTRAINT `R_3` FOREIGN KEY (`IDTiket`) REFERENCES Tiket(`IDTiket`)
		ON DELETE CASCADE
		ON UPDATE CASCADE;
 


ALTER TABLE `Na_tiketu`
	ADD CONSTRAINT `R_11` FOREIGN KEY (`IDTiket`) REFERENCES Tiket(`IDTiket`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION;
 

ALTER TABLE `Na_tiketu`
	ADD CONSTRAINT `R_14` FOREIGN KEY (`IDUtakmice`) REFERENCES Utakmice(`IDUtakmice`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION;
 


ALTER TABLE `Odigrani`
	ADD CONSTRAINT `R_9` FOREIGN KEY (`IDTiket`) REFERENCES Online(`IDTiket`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION;
 

ALTER TABLE `Odigrani`
	ADD CONSTRAINT `R_10` FOREIGN KEY (`IDKorisnik`) REFERENCES Registrovani(`IDKorisnik`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION;
 


ALTER TABLE `Online`
	ADD CONSTRAINT `R_4` FOREIGN KEY (`IDTiket`) REFERENCES Tiket(`IDTiket`)
		ON DELETE CASCADE
		ON UPDATE CASCADE;
 


ALTER TABLE `Registrovani`
	ADD CONSTRAINT `R_2` FOREIGN KEY (`IDKorisnik`) REFERENCES Korisnik(`IDKorisnik`)
		ON DELETE CASCADE
		ON UPDATE CASCADE;
 


ALTER TABLE `Sluzbenik`
	ADD CONSTRAINT `R_1` FOREIGN KEY (`IDSluzbenik`) REFERENCES Korisnik(`IDKorisnik`)
		ON DELETE CASCADE
		ON UPDATE CASCADE;
 

