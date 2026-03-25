CREATE DATABASE stelle;

USE stelle;

CREATE TABLE costellazioni (
    id_costellazione INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE
)ENGINE InnoDB;

CREATE TABLE stelle (
    sao VARCHAR(6) PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    ascensione_retta DECIMAL(12,8) NOT NULL,
    declinazione DECIMAL(11,8) NOT NULL,
    id_costellazione INT NULL,
    FOREIGN KEY (id_costellazione) REFERENCES costellazioni(id_costellazione) ON DELETE SET NULL ON UPDATE CASCADE
)ENGINE InnoDB;

INSERT INTO costellazioni (nome) VALUES
('Andromeda'), ('Aquila'), ('Auriga'), ('Boötes'), ('Canis Major'), ('Canis Minor'),
('Carina'), ('Centaurus'), ('Cepheus'), ('Cetus'), ('Crux'), ('Cygnus'), ('Draco'),
('Eridanus'), ('Gemini'), ('Hercules'), ('Hydra'), ('Leo'), ('Lyra'), ('Ophiuchus'),
('Orion'), ('Pegasus'), ('Perseus'), ('Puppis'), ('Scorpius'), ('Taurus'), ('Ursa Major'),
('Ursa Minor'), ('Vela'), ('Virgo');

INSERT INTO stelle (sao, nome, ascensione_retta, declinazione, id_costellazione) VALUES
('151881', 'Sirius',            6.75247500,     -16.71611667,   (SELECT id_costellazione FROM costellazioni WHERE nome = 'Canis Major')),
('234480', 'Canopus',           6.39919444,     -52.69566111,   (SELECT id_costellazione FROM costellazioni WHERE nome = 'Carina')),
('252838', 'Rigil Kentaurus',   14.66011528,    -60.83397472,   (SELECT id_costellazione FROM costellazioni WHERE nome = 'Centaurus')),
('100183', 'Arcturus',          14.26100000,    19.18240833,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Boötes')),
('67174',  'Vega',              18.61564861,    38.78368889,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Lyra')),
('39624',  'Capella',           5.27815556,     45.99803139,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Auriga')),
('131907', 'Rigel',             5.24229722,     -8.20163889,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Orion')),
('113368', 'Procyon',           7.65529722,     5.22499306,     (SELECT id_costellazione FROM costellazioni WHERE nome = 'Canis Minor')),
('232481', 'Achernar',          1.62856750,     -57.23675833,   (SELECT id_costellazione FROM costellazioni WHERE nome = 'Eridanus')),
('125122', 'Altair',            19.84638889,    8.86832139,     (SELECT id_costellazione FROM costellazioni WHERE nome = 'Aquila')),
('69713',  'Deneb',             20.69080278,    45.28033889,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Cygnus')),
('113271', 'Betelgeuse',        5.91952917,     7.40706389,     (SELECT id_costellazione FROM costellazioni WHERE nome = 'Orion')),
('79607',  'Pollux',            7.75526389,     28.02619861,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Gemini')),
('95771',  'Fomalhaut',         22.95625000,    -29.62222222,   (SELECT id_costellazione FROM costellazioni WHERE nome = 'Piscis Austrinus')),
('112247', 'Beta Centauri',     14.06366667,    -60.37305556,   (SELECT id_costellazione FROM costellazioni WHERE nome = 'Centaurus')),
('68702',  'Acrux',             12.44305556,    -63.09916667,   (SELECT id_costellazione FROM costellazioni WHERE nome = 'Crux')),
('102409', 'Antares',           16.49011667,    -26.43200000,   (SELECT id_costellazione FROM costellazioni WHERE nome = 'Scorpius')),
('24916',  'Aldebaran',         4.59867778,     16.50930278,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Taurus')),
('32349',  'Spica',             13.41988222,    -11.16132139,   (SELECT id_costellazione FROM costellazioni WHERE nome = 'Virgo')),
('112961', 'Shaula',            17.56014444,    -37.10383333,   (SELECT id_costellazione FROM costellazioni WHERE nome = 'Scorpius')),
('85755',  'Regulus',           10.13953333,    11.96720833,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Leo')),
('87937',  'Adhara',            6.97694444,     -28.97211111,   (SELECT id_costellazione FROM costellazioni WHERE nome = 'Canis Major')),
('45527',  'Castor',            7.75526389,     31.88827500,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Gemini')),
('30867',  'Bellatrix',         5.41884917,     6.34970278,     (SELECT id_costellazione FROM costellazioni WHERE nome = 'Orion')),
('113368', 'Procyon B',         7.65529722,     5.22499306,     (SELECT id_costellazione FROM costellazioni WHERE nome = 'Canis Minor')),
('97603',  'Gacrux',            12.51944444,    -57.11333333,   (SELECT id_costellazione FROM costellazioni WHERE nome = 'Crux')),
('85696',  'Mimosa',            12.79527778,    -59.68888889,   (SELECT id_costellazione FROM costellazioni WHERE nome = 'Crux')),
('60718',  'Alnilam',           5.60355917,     -1.20192083,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Orion')),
('60718',  'Alnitak',           .67931250,      -1.94257222,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Orion')),
('25336',  'Alioth',            12.90048750,    55.95982139,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Ursa Major')),
('87937',  'Wezen',             7.13805556,     -26.39305556,   (SELECT id_costellazione FROM costellazioni WHERE nome = 'Canis Major')),
('95771',  'Peacock',           20.42722222,    -56.73472222,   (SELECT id_costellazione FROM costellazioni WHERE nome = 'Pavo')),
('100183', 'Dubhe',             11.06205556,    61.75087500,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Ursa Major')),
('102098', 'Merak',             11.03083333,    56.38241667,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Ursa Major')),
('44752',  'Alphard',           9.45979167,     -8.65861111,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Hydra')),
('43845',  'Regor',             8.15861111,     -47.33527778,   (SELECT id_costellazione FROM costellazioni WHERE nome = 'Vela')),
('39953',  'Naos',              8.05972222,     -40.00305556,   (SELECT id_costellazione FROM costellazioni WHERE nome = 'Puppis')),
('68702',  'Gacrux B',          12.51944444,    -57.11333333,   (SELECT id_costellazione FROM costellazioni WHERE nome = 'Crux')),
('97603',  'Menkent',           14.06366667,    -36.36983333,   (SELECT id_costellazione FROM costellazioni WHERE nome = 'Centaurus')),
('80395',  'Kochab',            14.84513889,    74.15550000,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Ursa Minor')),
('93845',  'Mirfak',            3.40538889,     49.86138889,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Perseus')),
('124897', 'Algol',             3.13583333,     40.95750000,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Perseus')),
('21421',  'Diphda',            0.72666667,     0.00000000,     (SELECT id_costellazione FROM costellazioni WHERE nome = 'Cetus')),
('116247', 'Scheat',            23.06291667,    28.08277778,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Pegasus')),
('112029', 'Markab',            23.07916667,    15.20527778,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Pegasus')),
('109176', 'Alpheratz',         0.13958333,     29.09027778,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Andromeda')),
('8886',   'Hamal',             2.11955556,     23.46241667,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Aries')),
('5536',   'Sheratan',          1.91083333,     20.80833333,    (SELECT id_costellazione FROM costellazioni WHERE nome = 'Aries')),
;