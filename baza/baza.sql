
CREATE TABLE [Admin]
( 
	[username]           varchar(20)  NOT NULL ,
	[password]           varchar(20)  NOT NULL ,
	CONSTRAINT [XPKAdmin] PRIMARY KEY  CLUSTERED ([username] ASC)
)
go

CREATE TABLE [Brzi]
( 
	[IDTiket]            integer  NOT NULL ,
	[Vreme_pocetka]      datetime  NOT NULL ,
	CONSTRAINT [XPKBrzi] PRIMARY KEY  CLUSTERED ([IDTiket] ASC)
)
go

CREATE TABLE [Korisnik]
( 
	[IDKorisnik]         integer  NOT NULL  IDENTITY ( 1,3 ) ,
	[Ime]                varchar(20)  NOT NULL ,
	[Prezime]            varchar(20)  NOT NULL ,
	[username]           varchar(20)  NOT NULL ,
	[password]           varchar(20)  NOT NULL ,
	[nijeSluzbenik]      bit  NOT NULL ,
	[JMBG]               char(13)  NOT NULL ,
	CONSTRAINT [XPKKorisnik] PRIMARY KEY  CLUSTERED ([IDKorisnik] ASC)
)
go

CREATE TABLE [Na_tiketu]
( 
	[IDTiket]            integer  NOT NULL ,
	[Odigrano]           char  NULL 
	CONSTRAINT [ishod_30837925]
		CHECK  ( [Odigrano]='1' OR [Odigrano]='2' OR [Odigrano]='X' ),
	[IDUtakmice]         integer  NOT NULL ,
	CONSTRAINT [XPKNa_tiketu] PRIMARY KEY  CLUSTERED ([IDTiket] ASC,[IDUtakmice] ASC)
)
go

CREATE TABLE [Odigrani]
( 
	[IDTiket]            integer  NOT NULL ,
	[IDKorisnik]         integer  NOT NULL ,
	[dobitan]            bit  NULL ,
	CONSTRAINT [XPKOdigrani] PRIMARY KEY  CLUSTERED ([IDTiket] ASC,[IDKorisnik] ASC)
)
go

CREATE TABLE [Online]
( 
	[IDTiket]            integer  NOT NULL ,
	[Vreme_kraja]        datetime  NOT NULL ,
	CONSTRAINT [XPKOnline] PRIMARY KEY  CLUSTERED ([IDTiket] ASC)
)
go

CREATE TABLE [Registrovani]
( 
	[IDKorisnik]         integer  NOT NULL ,
	[Racun]              integer  NULL ,
	CONSTRAINT [XPKRegistrovani] PRIMARY KEY  CLUSTERED ([IDKorisnik] ASC)
)
go

CREATE TABLE [Sluzbenik]
( 
	[IDSluzbenik]        integer  NOT NULL ,
	[Plata]              integer  NULL ,
	CONSTRAINT [XPKSluzbenik] PRIMARY KEY  CLUSTERED ([IDSluzbenik] ASC)
)
go

CREATE TABLE [Tiket]
( 
	[IDTiket]            integer  NOT NULL  IDENTITY ( 1,3 ) ,
	[Ukup_kvota]         float  NOT NULL ,
	[Uplata]             integer  NOT NULL ,
	CONSTRAINT [XPKTiket] PRIMARY KEY  CLUSTERED ([IDTiket] ASC)
)
go

CREATE TABLE [Utakmice]
( 
	[IDUtakmice]         integer  NOT NULL  IDENTITY ( 1,3 ) ,
	[Tim1]               varchar(20)  NOT NULL ,
	[Tim2]               varchar(20)  NOT NULL ,
	[Vreme]              datetime  NOT NULL ,
	[1]                  float  NOT NULL ,
	[X]                  float  NOT NULL ,
	[2]                  float  NOT NULL ,
	[Ishod]              char  NULL 
	CONSTRAINT [ishod_1599545314]
		CHECK  ( [Ishod]='1' OR [Ishod]='2' OR [Ishod]='X' ),
	CONSTRAINT [XPKUtakmice] PRIMARY KEY  CLUSTERED ([IDUtakmice] ASC)
)
go


ALTER TABLE [Brzi]
	ADD CONSTRAINT [R_3] FOREIGN KEY ([IDTiket]) REFERENCES [Tiket]([IDTiket])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go


ALTER TABLE [Na_tiketu]
	ADD CONSTRAINT [R_11] FOREIGN KEY ([IDTiket]) REFERENCES [Tiket]([IDTiket])
		ON DELETE NO ACTION
		ON UPDATE NO ACTION
go

ALTER TABLE [Na_tiketu]
	ADD CONSTRAINT [R_14] FOREIGN KEY ([IDUtakmice]) REFERENCES [Utakmice]([IDUtakmice])
		ON DELETE NO ACTION
		ON UPDATE NO ACTION
go


ALTER TABLE [Odigrani]
	ADD CONSTRAINT [R_9] FOREIGN KEY ([IDTiket]) REFERENCES [Online]([IDTiket])
		ON DELETE NO ACTION
		ON UPDATE NO ACTION
go

ALTER TABLE [Odigrani]
	ADD CONSTRAINT [R_10] FOREIGN KEY ([IDKorisnik]) REFERENCES [Registrovani]([IDKorisnik])
		ON DELETE NO ACTION
		ON UPDATE NO ACTION
go


ALTER TABLE [Online]
	ADD CONSTRAINT [R_4] FOREIGN KEY ([IDTiket]) REFERENCES [Tiket]([IDTiket])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go


ALTER TABLE [Registrovani]
	ADD CONSTRAINT [R_2] FOREIGN KEY ([IDKorisnik]) REFERENCES [Korisnik]([IDKorisnik])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go


ALTER TABLE [Sluzbenik]
	ADD CONSTRAINT [R_1] FOREIGN KEY ([IDSluzbenik]) REFERENCES [Korisnik]([IDKorisnik])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go
