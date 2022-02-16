use fs_sander;

drop table if exists row;
drop table if exists grocery;
drop table if exists article;
drop table if exists stores;
drop table if exists type;
drop table if exists person;
drop table if exists units;

CREATE TABLE `units` (
  `uni_id` int(11) NOT NULL AUTO_INCREMENT,
  `uni_name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`uni_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `person` (
  `per_id` int(11) NOT NULL AUTO_INCREMENT,
  `per_firstname` varchar(30) DEFAULT NULL,
  `per_lastname` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`per_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `type` (
  `typ_id` int(11) NOT NULL AUTO_INCREMENT,
  `typ_name` varchar(30) NOT NULL,
  PRIMARY KEY (`typ_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `stores` (
  `sto_id` int(11) NOT NULL AUTO_INCREMENT,
  `sto_name` varchar(30) NOT NULL,
  `sto_typ_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`sto_id`),
  UNIQUE KEY `stores_sto_name_uindex` (`sto_name`),
  KEY `sto_typ_id` (`sto_typ_id`),
  CONSTRAINT `sto_typ_id` FOREIGN KEY (`sto_typ_id`) REFERENCES `type` (`typ_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `article` (
  `art_id` int(11) NOT NULL AUTO_INCREMENT,
  `art_name` varchar(30) NOT NULL,
  `art_code` varchar(30) NOT NULL,
  `art_uni_id` int(11) NOT NULL,
  PRIMARY KEY (`art_id`),
  KEY `art_uni_id` (`art_uni_id`),
  CONSTRAINT `art_uni_id` FOREIGN KEY (`art_uni_id`) REFERENCES `units` (`uni_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `grocery` (
  `gro_id` int(11) NOT NULL AUTO_INCREMENT,
  `gro_name` varchar(30) DEFAULT NULL,
  `gro_description` varchar(255) DEFAULT NULL,
  `gro_date` date DEFAULT NULL,
  `gro_per_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`gro_id`),
  KEY `gro_per_id_fk` (`gro_per_id`),
  CONSTRAINT `gro_per_id_fk` FOREIGN KEY (`gro_per_id`) REFERENCES `person` (`per_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `row` (
  `row_id` int(11) NOT NULL AUTO_INCREMENT,
  `row_pieces` int(11) DEFAULT NULL,
  `row_art_id` int(11) DEFAULT NULL,
  `row_gro_id` int(11) DEFAULT NULL,
  `row_sto_id` int(11) DEFAULT NULL,
  `row_pric` double NOT NULL,
  PRIMARY KEY (`row_id`),
  KEY `row_art_id_fk` (`row_art_id`),
  KEY `row_gro_id_fk` (`row_gro_id`),
  KEY `row_sto_id_fk` (`row_sto_id`),
  CONSTRAINT `row_art_id_fk` FOREIGN KEY (`row_art_id`) REFERENCES `article` (`art_id`),
  CONSTRAINT `row_gro_id_fk` FOREIGN KEY (`row_gro_id`) REFERENCES `grocery` (`gro_id`),
  CONSTRAINT `row_sto_id_fk` FOREIGN KEY (`row_sto_id`) REFERENCES `stores` (`sto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- inserts --

insert into units values
	('1','kg'),
	('2','g'),
	('3','stuk'),
	('4','l'),
	('5','blik');

insert into person values
	('1','Gerard','Den Ouden'),
	('2','Tommeke','Wat doe gij nu toch?'),
	('3','Alice','Van Wonderland'),
	('4','Tijl','Wafels'),
	('5','Els','De Pels');

insert into type values
	('1','Supermarkt'),
	('2','Wereldwinkel'),
	('3','Webwinkel'),
	('4','Kledingwinkel'),
	('5','Dierenwinkel');

insert into stores values
	('1','Carrefour','1'),
	('2','Delhaize','1'),
	('3','Albert heijn','1'),
	('4','Oxfam','2'),
	('5','Bol.com','3'),
	('6','Zalando','3'),
	('7','Amazon','3'),
	('8','Coolblue','3'),
	('9','C&A','4'),
	('10','WE-Fashion','4'),
	('11','Zara','4'),
	('12','Zeeman','4'),
	('13','Gucci','4'),
	('14','Tom & Co','5'),
	('15',"Jo's Pet Shop",'5'),
	('16','Dierenplezier','5');

insert into article values
	('1','perziken','aaaa','5'),
	('2','choco','aaab','3'),
	('3','garnalen','bbbb','1'),
	('4','Vanille-ijs','cccc','4'),
	('5','Moonrock','zzzz','2'),
	('6','bio yoghurt vol framboos','1234','3'),
	('7','bio komkommer','abcd','3'),
	('8','zonnebloemolie','ddda','4'),
	('9','pokemon sword&shield','zacd','3'),
	('10','Apple iPhone 13 256GB','yuvc','3'),
	('11','vleesthermometer','uinv','3'),
	('12','Gucci handtas','kiol','3'),
	('13','jeans broek small','ghjk','3'),
	('14','Geox sneakers 43','edfc','3'),
	('15','T-shirt large','sfcl','3'),
	('16','onderbroek medium','fgdl','3'),
	('17','Trekrugzak 50 liter','rgha','3'),
	('18','hondenvoer','gjkl','3'),
	('19','vogelvoer','qdfg','3'),
	('20','kattenvoer','mojl','3');

insert into grocery values
	('1','Tuinfeestje','Feestje om mijn verjaardag te vieren','2021-12-09','3'),
	('2','Boodschap 010','Dagelijkse boodschappen - woensdag','2022-01-19','1'),
	('3','Boodschap 009','Dagelijkse boodschappen - vrijdag','2022-01-14','1'),
	('4','Corona party','Geheim feestje tijdens corona... shhhh!','2021-12-02','2'),
	('5','Boodschappen moeder','Boodschappen doen voor mamatje','2017-05-18','5');

insert into row values
	('1','1','5','1','7','999999.99'),
	('2','10','7','2','4','1.85'),
	('3','3','3','2','2','5.1'),
	('4','1','4','2','2','6.99'),
	('5','1','11','2','2','5.85'),
	('6','2','19','3','15','9.99'),
	('7','1','8','3','1','4.95'),
	('8','2','2','3','1','5.89'),
	('9','1','9','4','5','90.9'),
	('10','3','12','4','13','1099.9'),
	('11','1','10','5','8','599.99');

