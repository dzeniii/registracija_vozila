SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE IF NOT EXISTS kategorija (
  kategorija varchar(10) NOT NULL,
  naziv_kategorije varchar(25) NOT NULL,
  cijena_tehničkog decimal(10,2) NOT NULL,
  PRIMARY KEY (kategorija)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO kategorija VALUES
('L1', 'Motorcikl i tricikl', 21.50),
('L3', 'Motorcikl i tricikl', 26.00),
('L6', 'Četverocikl', 31.00),
('M1', 'Putničko', 47.00),
('M2', 'Autobus', 64.00),
('M3', 'Autobus', 77.00),
('N1', 'Teretno', 56.00);

CREATE TABLE IF NOT EXISTS osiguranje (
  broj_police int NOT NULL,
  društvo varchar(30) NOT NULL,
  vozilo int NOT NULL,
  premija decimal(10,2) NOT NULL,
  rok_trajanja date NOT NULL,
  suma decimal(10,2) NOT NULL,
  PRIMARY KEY (broj_police),
  KEY vozilo (vozilo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO osiguranje VALUES
(82680878, 'UNIQA osiguranje d.d. Sarajevo', 3, 600.00, '2025-04-03', 1500.00),
(454277960, 'ASA CENTRAL osiguranje d.d. Sa', 1, 400.00, '2024-06-02', 1200.00);

CREATE TABLE IF NOT EXISTS registracija (
  registarska_oznaka varchar(7) NOT NULL,
  datum_izdavanja date NOT NULL,
  mjesto_izdavanja varchar(25) NOT NULL,
  vozilo int NOT NULL,
  rok_trajanja date NOT NULL,
  PRIMARY KEY (registarska_oznaka),
  KEY vozilo (vozilo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO registracija VALUES
('J17O335', '2023-05-01', 'Doboj Istok', 1, '2024-05-01'),
('K33T522', '2024-06-12', 'Kalesija', 3, '2025-06-12');

CREATE TABLE IF NOT EXISTS vlasnik (
  lična_karta varchar(9) NOT NULL,
  ime varchar(20) NOT NULL,
  prezime varchar(25) NOT NULL,
  općina varchar(30) DEFAULT NULL,
  mjesto varchar(30) DEFAULT NULL,
  adresa varchar(30) NOT NULL,
  PRIMARY KEY (lična_karta)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO vlasnik VALUES
('', '', '', '', '', ''),
('08B4EF232', 'Selman', 'Džambić', 'Gračanica', 'Lukavica', 'Ograđenica bb'),
('151502592', 'Kerim', 'Dautović', 'Doboj Istok', 'Brijesnica Velika', 'Ćil 25'),
('4608C6BE7', 'Marko', 'Subašić', 'Ilidža', '', 'Željeznička 85'),
('925623B23', 'Mahir', 'Ibrahimović', 'Gračanica', 'Gračanica', 'Mula Mustafe Bašeskije 6'),
('934E52KE2', 'Samir', 'Hadžić', 'Gračanica', 'Malešići', 'Malešići BB'),
('BD6EBDB13', 'Mirela', 'Trepanović', 'Tuzla', 'Tuzla', '6. bosanske brigade 23');

CREATE TABLE IF NOT EXISTS vozilo (
  vozilo_id int NOT NULL AUTO_INCREMENT,
  marka varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  tip varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  model varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  broj_šasije varchar(17) NOT NULL,
  masa decimal(10,2) DEFAULT NULL,
  zapremina decimal(10,2) NOT NULL,
  snaga int NOT NULL,
  gorivo varchar(15) NOT NULL,
  godište year NOT NULL,
  boja varchar(15) NOT NULL,
  kategorija varchar(10) NOT NULL,
  vlasnik varchar(9) NOT NULL,
  PRIMARY KEY (vozilo_id),
  KEY vlasnik (vlasnik),
  KEY kategorija (kategorija)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO vozilo VALUES
(1, 'Volkswagen', '19E', 'Golf', '3VWFL81H1TM061571', NULL, 1589.00, 51, 'Dizel', '1985', 'Zelena', 'M1', 'BD6EBDB13'),
(3, 'Mercedes', '0 303', 'S 320 CDI', 'WDBRF64J35F582383', 1925.00, 3222.00, 150, 'Dizel', '2003', 'Crna', 'L1', '08B4EF232');


ALTER TABLE osiguranje
  ADD CONSTRAINT osiguranje_ibfk_1 FOREIGN KEY (vozilo) REFERENCES vozilo (vozilo_id);

ALTER TABLE registracija
  ADD CONSTRAINT registracija_ibfk_1 FOREIGN KEY (vozilo) REFERENCES vozilo (vozilo_id);

ALTER TABLE vozilo
  ADD CONSTRAINT vozilo_ibfk_1 FOREIGN KEY (vlasnik) REFERENCES vlasnik (lična_karta),
  ADD CONSTRAINT vozilo_ibfk_2 FOREIGN KEY (kategorija) REFERENCES kategorija (kategorija) ON DELETE RESTRICT ON UPDATE RESTRICT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
