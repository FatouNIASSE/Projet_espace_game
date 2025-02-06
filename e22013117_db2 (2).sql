-- phpMyAdmin SQL Dump
-- version 5.0.4deb2+deb11u1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 12 déc. 2023 à 02:21
-- Version du serveur :  10.5.19-MariaDB-0+deb11u2
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `e22013117_db2`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`e22013117sql`@`%` PROCEDURE `affichage_message` (IN `id_sc` INT, OUT `message` VARCHAR(300))  BEGIN
    DECLARE nb_participants INT;
    DECLARE intituler VARCHAR(300);
    DECLARE pr_participant VARCHAR(200);
    DECLARE date_pp DATE;
   

    SET nb_participants = nbrparticipants(id_sc);

    IF nb_participants != 0 THEN
        SELECT SCE_intituler INTO intituler FROM T_SCENARIO_SCE WHERE SCE_id = id_sc;

        -- Trouver le premier participant en fonction de la date la plus ancienne
        SELECT PTS_mail, MIN(RLT_premieredate) INTO pr_participant, date_pp
        FROM T_PARTICIPANT_PTS
        JOIN T_RESULTAT_RLT USING (PTS_id)
        WHERE SCE_id = id_sc;

        SET message := CONCAT('Intitulé du scénario est ', intituler, ', le nombre de participants est ', nb_participants, ', avec le premier participant ', pr_participant, ' et la date ', date_pp);
    ELSE
        SET message := 'Aucun participant';
    END IF;
END$$

CREATE DEFINER=`e22013117sql`@`%` PROCEDURE `GetCountEtap` (OUT `Totale_etape` INT)  BEGIN
    SELECT COUNT(*) INTO Totale_etape
    FROM T_SCENARIO_SCE
    LEFT JOIN T_ETAPE_ETP USING(SCE_id);
END$$

CREATE DEFINER=`e22013117sql`@`%` PROCEDURE `ttparticipants` (IN `id_sc` INT, OUT `allparticipants` VARCHAR(300))  BEGIN
    SELECT GROUP_CONCAT(PTS_mail) INTO allparticipants
    FROM T_PARTICIPANT_PTS
    JOIN T_RESULTAT_RLT USING (PTS_id)
    WHERE SCE_id = id_sc;
END$$

--
-- Fonctions
--
CREATE DEFINER=`e22013117sql`@`%` FUNCTION `generateRandomString` () RETURNS CHAR(10) CHARSET utf8mb4 COLLATE utf8mb4_general_ci BEGIN
    DECLARE v_caracteres VARCHAR(62) DEFAULT '0123456789abcdefghijklmnopqrstuvwzyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    DECLARE v_chaineA CHAR(10) DEFAULT '';
    DECLARE i INT DEFAULT 0;

    -- Boucle pour générer la chaîne aléatoire
    FOR i IN 1..10 DO
        SET v_chaineA = CONCAT(v_chaineA, SUBSTRING(v_caracteres FROM FLOOR(RAND() * LENGTH(v_caracteres) + 1) FOR 1));
    END FOR;

    -- Retourne la chaîne générée
    RETURN v_chaineA;
END$$

CREATE DEFINER=`e22013117sql`@`%` FUNCTION `nbrparticipants` (`sc_id` INT) RETURNS INT(11) BEGIN
DECLARE NB INT DEFAULT 0;

 SELECT count(*) INTO NB 
 from T_RESULTAT_RLT  WHERE SCE_id = sc_id;
 RETURN NB ; 
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `T_ACTUALITE_ACT`
--

CREATE TABLE `T_ACTUALITE_ACT` (
  `ACT_id` int(11) NOT NULL,
  `ACT_intitule` varchar(300) NOT NULL,
  `ACT_description` varchar(300) DEFAULT NULL,
  `ACT_date` date NOT NULL,
  `ACT_etat` char(1) NOT NULL,
  `CPT_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `T_ACTUALITE_ACT`
--

INSERT INTO `T_ACTUALITE_ACT` (`ACT_id`, `ACT_intitule`, `ACT_description`, `ACT_date`, `ACT_etat`, `CPT_id`) VALUES
(1, 'Probleme technique', 'Maintenance du site', '2023-01-27', 'A', 2),
(2, 'NEW Sénario', 'Un nouveau scénarios sur le mode des intellectuelle sera bientot disponible', '2023-10-01', 'A', 3),
(3, 'Bonne Nouvelle', 'Vous avez aimé nos jeux de piste ? Partagez votre expérience et tentez de gagner des prix exclusifs. Les meilleures critiques seront récompensées !\"', '2023-10-02', 'A', 3),
(4, 'INFOS', 'Découvrez notre tout nouveau partenaire local qui a contribué à rendre nos jeux de piste encore plus passionnants. Explorez avec nous !\"', '2023-10-05', 'A', 6),
(68, 'test', 'test1', '2023-12-02', 'A', 2);

-- --------------------------------------------------------

--
-- Structure de la table `T_COMPTE_CPT`
--

CREATE TABLE `T_COMPTE_CPT` (
  `CPT_id` int(11) NOT NULL,
  `CPT_login` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `CPT_mdp` char(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `T_COMPTE_CPT`
--

INSERT INTO `T_COMPTE_CPT` (`CPT_id`, `CPT_login`, `CPT_mdp`) VALUES
(1, 'administrATeur', '0e376ad9a8da9c55fae01cda320f03c4eb1c6663fddf0d6d1f3010166b459c61'),
(2, 'Fatou221', '9fa590f97dc3099905fdedc8abedc98d5b054f150c81716fa16f2615ca218d66'),
(3, 'Khadija', '1b7e0c8616c1b6ffd4d0df3f185275dea3090064a6111026317dfb93e67ad49f'),
(4, 'birane65', '6962f36fa286f1598bcf3c104eba160823ef0885b9ce7ee5a418f106a05a8a7e'),
(5, 'sara639', 'cd9b8fe512a4ad1ed5182d54ec2dee91311758e8392d960d028374db63f1f092'),
(6, 'Soul96', '20a13e7648f3ad2ebc9dbde31186f0ab6899aba4ae4fb3599ba61f98e853190d'),
(7, 'lamine5', '87c7586cc6cb83c88e3eeec46819a0f455e0e6a2ce15de4edd1024f53d2f3bca'),
(8, 'organisATeur', 'organisATeur@'),
(32, 'OMAR', '51749fdfc9e4bf37efae79744172c7735d7cf0406589b274b15d0c64e7441198'),
(33, 'zzzzz', '51749fdfc9e4bf37efae79744172c7735d7cf0406589b274b15d0c64e7441198'),
(34, 'FRFR', '51749fdfc9e4bf37efae79744172c7735d7cf0406589b274b15d0c64e7441198'),
(35, 'momo', '01cc6b1426fe31340c25ebb21afafff8f2d758f92eb919a12c18db80d93e6d27'),
(36, 'boubou', '51749fdfc9e4bf37efae79744172c7735d7cf0406589b274b15d0c64e7441198'),
(37, 'made', '51749fdfc9e4bf37efae79744172c7735d7cf0406589b274b15d0c64e7441198'),
(38, 'nano1', 'bc197941e95274be06d7431c4e16f02565111bfbca78db586ac410f1cdbabb2c'),
(39, 'TEST', '51749fdfc9e4bf37efae79744172c7735d7cf0406589b274b15d0c64e7441198'),
(48, 'vmarctest', '787fd3f77ff041afe35c70d6e7420b2cde051ea72aa2578a3ae1657cd09c05e1'),
(50, 'mami', '51749fdfc9e4bf37efae79744172c7735d7cf0406589b274b15d0c64e7441198'),
(51, 'mkij', '51749fdfc9e4bf37efae79744172c7735d7cf0406589b274b15d0c64e7441198'),
(52, 'aya', '51749fdfc9e4bf37efae79744172c7735d7cf0406589b274b15d0c64e7441198');

--
-- Déclencheurs `T_COMPTE_CPT`
--
DELIMITER $$
CREATE TRIGGER `modpass` BEFORE INSERT ON `T_COMPTE_CPT` FOR EACH ROW BEGIN
 declare salt varchar(200);
 declare password char(64);
 set @salt = "OnRajouteDuSelPourAllongerleMDP123!!45678__Test";
 set @password = sha2(CONCAT(@salt,NEW.CPT_mdp),256);
 SET NEW.CPT_mdp = @password;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `suppression` BEFORE DELETE ON `T_COMPTE_CPT` FOR EACH ROW BEGIN
      
        DELETE FROM T_PROFIL_PRO WHERE CPT_id =OLD.CPT_id;
        DELETE FROM T_ACTUALITE_ACT WHERE CPT_id =OLD.CPT_id;
        UPDATE T_SCENARIO_SCE set CPT_id = 8 where CPT_id =OLD.CPT_id;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `T_ETAPE_ETP`
--

CREATE TABLE `T_ETAPE_ETP` (
  `ETP_id` int(11) NOT NULL,
  `ETP_intituler` varchar(300) NOT NULL,
  `ETP_code` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `ETP_description` varchar(300) NOT NULL,
  `ETP_reponse` varchar(300) NOT NULL,
  `ETP_ordre` int(11) NOT NULL,
  `SCE_id` int(11) NOT NULL,
  `RSC_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `T_ETAPE_ETP`
--

INSERT INTO `T_ETAPE_ETP` (`ETP_id`, `ETP_intituler`, `ETP_code`, `ETP_description`, `ETP_reponse`, `ETP_ordre`, `SCE_id`, `RSC_id`) VALUES
(1, 'Labyrinthe Numériques', 'Egpm56GH', 'Quel est le résultat de 5 + 7 ?', '12', 1, 1, 1),
(2, 'Énigme des Fractions', 'HDRZ23ml', 'Simplifiez la fraction 6/9.', '2/3', 2, 1, 2),
(3, 'Calculs Complexes', 'OP569ndf', 'Résolvez l\'équation : 2x + 5 = 11.', '3', 3, 1, 3),
(4, 'Le Mystère des Nombres Premiers', 'dgt3OP58', 'Trouvez le prochain nombre premier après 17.', '19', 4, 1, 4),
(5, 'Énigme Finale', 'ETVH58ml', 'Quel est le résultat de 8 x 6 - 4 ?', '44', 5, 1, 5),
(6, 'Le Portail Numérique ', 'hdryz54D', 'Quelle est la valeur binaire du nombre décimal 10 ?', '1010', 1, 2, 6),
(7, 'Code Secret', '2hd45TGF', 'Déchiffrez le code : HGFEDCBA', 'ABCDEFGH', 2, 2, 7),
(8, 'Algorithmes Magiques', 'ET58gfrt', '3.142945621938 à trois décimales près ?', '3.142', 3, 2, 8),
(9, 'Défis Informatiques', '25fe25PR', 'Trouvez la clé d\'accès au trésor : 8675309', '8675309', 4, 2, 9),
(10, 'Le Trésor Numérique', 'yrfhg158', 'Quel est le langage de programmation préféré des développeurs ?', 'PHYTON', 5, 2, 10),
(11, 'L\'Exploration des Mots', 'ytgE1254', 'Traduisez le mot anglais \"apple\" en français.', 'POMME', 1, 3, 11),
(12, 'Découverte Linguistique', '145rgbAZ', 'Traduisez la phrase anglaise \"To be \"', 'ETRE', 2, 3, 12),
(13, 'Phrases Célèbres', 'E564Rrfe', 'Traduisez l\'expression anglaise \"Break a leg\" en français.', 'MERDE', 3, 3, 13),
(14, 'Mots Croisés Anglais', '25rgRDFG', 'Trouvez la traduction française du mot anglais \"house\" dans la grille de mots croisés.', 'MAISON', 4, 3, 14),
(15, 'Trésor Linguistique', '256RYUNv', 'Traduisez la phrase anglaise \" love\" en français.', 'AMOUR', 5, 3, 15),
(16, 'Le Départ dans le Temps', 'E456azer', 'Quelle est la capitale de la France ?', 'PARIS', 1, 4, 16),
(17, 'Voyage Temporel', 'ruhf1258', 'Qui était le premier empereur de la Rome antique ?', 'JULES CESAR', 2, 4, 17),
(18, 'Énigmes Géographiques', 'ygRE1254', 'Quel océan est le plus grand du monde ?', 'OCEAN PACIFIQUE', 3, 4, 18),
(19, 'Histoire Antique', 'E452AZEf', 'Dans quelle ville antique se trouve le célèbre Colisée ?', 'ROME', 4, 4, 19),
(20, 'Trésor Historique', '45zrTGFR', 'Quel est le nom du roi de France qui a été guillotiné pendant la Révolution française ?', 'LOUIS XVI', 5, 4, 20),
(21, 'Le Portail Céleste\r\n', 'tfgj568Q', 'Quelle est la plus grande planète du système solaire?\r\n', 'JUPITER', 1, 10, 21),
(22, 'La Porte des Lois Physiques\r\n', 'hgZS14BG', ' Quelle loi de la physique décrit la tendance d\'un objet à rester au repos ou à se déplacer à vitesse constante en l\'absence de forces externes?', 'NEWTON', 1, 11, 22);

-- --------------------------------------------------------

--
-- Structure de la table `T_INDICE_IDE`
--

CREATE TABLE `T_INDICE_IDE` (
  `IDE_id` int(11) NOT NULL,
  `IDE_lien` varchar(300) NOT NULL,
  `IDE_description` varchar(300) NOT NULL,
  `IDE_niveau` char(1) NOT NULL,
  `ETP_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `T_INDICE_IDE`
--

INSERT INTO `T_INDICE_IDE` (`IDE_id`, `IDE_lien`, `IDE_description`, `IDE_niveau`, `ETP_id`) VALUES
(1, 'https://www.calculatrice.fr/', 'Un indice pour naviguer dans le labyrinthe numérique.', '2', 1),
(2, 'https://www.rapidtables.org/fr/convert/number/decimal-to-binary.html', 'Un indice sur les nombre binaire', '1', 6),
(3, 'https://www.bing.com/search?pglt=41&q=traduction+anglais+fran%C3%A7ais&cvid=b22754dc59dc47a4b657999201cc06d0&gs_lcrp=EgZjaHJvbWUqBAgAEAAyBAgAEAAyBggBEEUYOTIECAIQADIECAMQADIECAQQADIECAUQADIECAYQADIECAcQADIECAgQANIBCDU2MjlqMGoxqAIAsAIA&FORM=ANNTA1&PC=SCOOBE', 'Un indice traduction pour commencer votre voyage linguistique.', '1', 11),
(5, 'https://www.calculatrice.fr/', 'Un indice pour résoudre des fractions.', '2', 2),
(6, 'https://fr.wikipedia.org/wiki/Nombre_premier', 'Un indice pour résoudre les mystères mathématiques.', '2', 4),
(7, 'https://www.cmath.fr/', 'Un indice final pour résoudre l\'énigme final', '3', 5),
(8, 'https://www.bing.com/search?q=8675309+images&qs=UT&pq=8675309+image&sc=9-13&cvid=420EC06C15884C6DBD68CE605A3D2754&FORM=QBRE&sp=1&ghc=1&lq=0', 'un défis pour relever les défis informatiques.', '1', 9),
(9, 'https://vocabulyze.com/anglais-francais/148-120-mots-de-vocabulaire-en-anglais-pour-debutant', 'un indice visuel pour la traduction', '3', 15),
(10, 'https://fr.wikipedia.org/wiki/Capitale_de_la_France', 'un indice approprie pour trouver la capital de france', '1', 16),
(11, 'https://atlasocio.com/classements/geographie/oceans/classement-oceans-par-superficie.php', 'un indice complexe pour répondre a ce question', '3', 18),
(12, 'https://www.bing.com/images/search?q=capital+de+france&qpvt=capital+de+france&form=IGRE&first=1', 'Un indice visuel pour trouver la capitale demandée', '2', 16),
(13, 'https://www.rapidtables.org/fr/calc/math/simplifying-fractions-calculator.html', 'Indice pour trouver la fraction', '1', 2),
(14, 'https://www.lelivrescolaire.fr/page/5810482#:~:text=R%C3%A9soudre%20une%20%C3%A9quation%20consiste%20%C3%A0%20trouver%20toutes%20les,dans%20le%20but%20d%27isoler%20l%27inconnue%20d%27un%20seul%20c%C3%B4t%C3%A9.', 'Indice pour trouver la solution', '1', 3),
(15, 'https://www.bing.com/search?pglt=41&q=Quelle+est+la+valeur+de+pi&cvid=cbb6a130b2a54dd7b62804c53d797ba3&gs_lcrp=EgZjaHJvbWUyBggAEEUYOTIECAEQADIECAIQANIBCDQwNjZqMGoxqAIAsAIA&FORM=ANNTA1&PC=SCOOBE', 'Indice pour ce question', '1', 8),
(16, 'https://www.bing.com/search?q=LAGUAGE+python+image&qs=n&form=QBRE&sp=-1&lq=0&pq=laguage+python+image&sc=0-20&sk=&cvid=295173741B014623912072934213868F&ghsh=0&ghacc=0&ghpl=', 'Indice pour trouver la solution', '1', 10),
(17, 'https://www.bing.com/search?q=traduction&qs=FT&pq=tr&sc=10-2&cvid=26B71B826F9F4B06AEE7194F6A1853B9&FORM=QBRE&sp=1&ghc=1&lq=0', 'Indice pour trouver la traduction', '1', 12),
(18, 'https://www.bing.com/search?q=traduction&qs=FT&pq=tr&sc=10-2&cvid=26B71B826F9F4B06AEE7194F6A1853B9&FORM=QBRE&sp=1&ghc=1&lq=0', 'Indice pour trouver la traduction', '1', 13),
(19, 'https://www.bing.com/search?q=traduction&qs=FT&pq=tr&sc=10-2&cvid=26B71B826F9F4B06AEE7194F6A1853B9&FORM=QBRE&sp=1&ghc=1&lq=0', 'Indice pour trouver la traduction', '1', 14),
(20, 'https://www.bing.com/images/search?q=jules+c%c3%a9sar&form=HDRSC3&first=1', 'indice visuel pour trouver la solution', '2', 17),
(21, 'https://fr.wikipedia.org/wiki/Colis%C3%A9e', 'indice pour trouver la solution', '2', 19),
(22, 'https://www.bing.com/search?q=Quel+est+le+nom+du+roi+de+France+qui+a+%C3%A9t%C3%A9+guillotin%C3%A9+pendant+la+R%C3%A9volution+fran%C3%A7aise+%3F&cvid=ca0197aa5e6045b8a2f65c2d5ac28faf&gs_lcrp=EgZjaHJvbWUyBggAEEUYOdIBBzU5OGowajmoAgCwAgA&FORM=ANAB01&PC=SCOOBE', 'indice pour trouver la solution', '1', 20),
(23, 'https://www.bing.com/images/search?q=chiffre+12&form=HDRSC3&first=1', 'indice visuel pour trouver la réponse', '1', 1),
(24, 'https://fr.khanacademy.org/math/arithmetic-home/addition-subtraction', 'indice pour la solution', '3', 1);

-- --------------------------------------------------------

--
-- Structure de la table `T_PARTICIPANT_PTS`
--

CREATE TABLE `T_PARTICIPANT_PTS` (
  `PTS_id` int(11) NOT NULL,
  `PTS_mail` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `T_PARTICIPANT_PTS`
--

INSERT INTO `T_PARTICIPANT_PTS` (`PTS_id`, `PTS_mail`) VALUES
(20, 'aya111@gmail.com'),
(5, 'aya@gmail.com'),
(3, 'bibi2987@gmail.com'),
(10, 'boubou@gmail.com'),
(13, 'DID@gmail.com'),
(2, 'fallou@gmail.com'),
(11, 'mama@gmail.com'),
(6, 'mk@gmail.com'),
(1, 'moudoufall@gmail.com'),
(14, 'moy@gmail.com'),
(15, 'nn@gmail.com'),
(16, 'omar@gmail.com'),
(4, 'Omarcisse@gmail.com'),
(17, 'sabaly@gmail.com'),
(18, 'saralaye@gmail.com'),
(12, 'vivi@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `T_PROFIL_PRO`
--

CREATE TABLE `T_PROFIL_PRO` (
  `PRO_nom` varchar(80) NOT NULL,
  `PRO_prenom` varchar(80) NOT NULL,
  `PRO_role` char(1) NOT NULL,
  `PRO_validite` char(1) NOT NULL,
  `PRO_img` varchar(300) CHARACTER SET armscii8 COLLATE armscii8_general_ci NOT NULL,
  `CPT_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `T_PROFIL_PRO`
--

INSERT INTO `T_PROFIL_PRO` (`PRO_nom`, `PRO_prenom`, `PRO_role`, `PRO_validite`, `PRO_img`, `CPT_id`) VALUES
('MARC', 'Valerie', 'A', 'A', 'marc.jpg', 1),
('NIASSE', 'Fatou', 'A', 'A', 'fn.jpg', 2),
('NDIAYE', 'Khadija', 'O', 'A', 'khadija.jpg', 3),
('MBENGUE', 'Birane', 'O', 'D', '', 4),
('DIOP', 'Sara', 'O', 'A', '', 5),
('FALL', 'Soul', 'O', 'A', '', 6),
('NDIAYE', 'Lamine', 'O', 'D', '', 7),
('DIOP', 'Adia', 'O', 'A', '', 8),
('OMAR', 'OMAR', 'O', 'A', '', 32),
('VCDX', 'DEDE', 'A', 'A', '', 33),
('DDDD', 'RFDE', 'O', 'A', '', 34),
('momo', 'momo', 'A', 'A', '', 35),
('boubou', 'bbou', 'O', 'A', '', 36),
('made', 'made', 'O', 'A', '', 37),
('nano', 'nano', 'O', 'A', '', 38),
('test', 'test', 'O', 'A', '', 39),
('V.', 'MARC', 'O', 'A', '5-2023-woman.png', 48),
('imomi', 'mami', 'O', 'A', 'telecharger.jpeg', 50),
('iiii', 'mmm', 'O', 'D', 'hmm.jpg', 51),
('Aya', 'Dayi', 'O', 'A', 'cerise.jpeg', 52);

-- --------------------------------------------------------

--
-- Structure de la table `T_RESSOURCE_RSC`
--

CREATE TABLE `T_RESSOURCE_RSC` (
  `RSC_id` int(11) NOT NULL,
  `RSC_chemin` varchar(300) NOT NULL,
  `RSC_type` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `T_RESSOURCE_RSC`
--

INSERT INTO `T_RESSOURCE_RSC` (`RSC_id`, `RSC_chemin`, `RSC_type`) VALUES
(1, 'ressource1_etape1.jpg', '1'),
(2, 'ressource1_etape2.jpg', '1'),
(3, 'ressource1_etape3.jpg', '1'),
(4, 'ressource1_etape4.jpg', '1'),
(5, 'ressource1_etape5.jpg', '1'),
(6, 'ressource2_etape1.jpg', '1'),
(7, 'ressource2_etape2.jpg', '1'),
(8, 'ressource2_etape3.jpg', '1'),
(9, 'ressource2_etape4.jpg', '1'),
(10, 'ressource2_etape5.jpg', '1'),
(11, 'ressource3_etape1.jpg', '1'),
(12, 'ressource3_etape2.jpg', '1'),
(13, 'ressource3_etape3.jpg', '1'),
(14, 'ressource3_etape4.jpg', '1'),
(15, 'ressource3_etape5.jpg', '1'),
(16, 'ressource4_etape1.jpg', '1'),
(17, 'ressource4_etape2.jpg', '1'),
(18, 'ressource4_etape3.jpg', '1'),
(19, 'ressource4_etape4.jpg', '1'),
(20, 'ressource4_etape5.jpg', '1'),
(21, 'ressource5_etape1.jpg', '1'),
(22, 'ressource6_etape1.jpg', '1');

-- --------------------------------------------------------

--
-- Structure de la table `T_RESULTAT_RLT`
--

CREATE TABLE `T_RESULTAT_RLT` (
  `RLT_premieredate` date NOT NULL,
  `RLT_dernieredate` date NOT NULL,
  `RLT_niveau` char(1) NOT NULL,
  `SCE_id` int(11) NOT NULL,
  `PTS_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `T_RESULTAT_RLT`
--

INSERT INTO `T_RESULTAT_RLT` (`RLT_premieredate`, `RLT_dernieredate`, `RLT_niveau`, `SCE_id`, `PTS_id`) VALUES
('2023-09-01', '2023-09-05', '2', 1, 1),
('2023-10-01', '2023-10-04', '2', 1, 3),
('2023-12-07', '2023-12-07', '1', 1, 10),
('2023-12-07', '2023-12-07', '1', 1, 14),
('2023-12-08', '2023-12-08', '1', 1, 15),
('2023-12-08', '2023-12-08', '1', 1, 16),
('2023-12-08', '2023-12-08', '3', 1, 17),
('2023-12-11', '2023-12-11', '1', 1, 20),
('2023-12-07', '2023-12-07', '1', 2, 12),
('2023-12-08', '2023-12-08', '1', 2, 18),
('2023-09-30', '2023-09-09', '3', 3, 2),
('2023-12-07', '2023-12-07', '2', 3, 11),
('2023-12-07', '2023-12-07', '3', 4, 13);

-- --------------------------------------------------------

--
-- Structure de la table `T_SCENARIO_SCE`
--

CREATE TABLE `T_SCENARIO_SCE` (
  `SCE_id` int(11) NOT NULL,
  `SCE_intituler` varchar(300) NOT NULL,
  `SCE_code` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `SCE_description` varchar(300) NOT NULL,
  `SCE_activite` char(1) NOT NULL,
  `CPT_id` int(11) DEFAULT NULL,
  `SCE_image` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `T_SCENARIO_SCE`
--

INSERT INTO `T_SCENARIO_SCE` (`SCE_id`, `SCE_intituler`, `SCE_code`, `SCE_description`, `SCE_activite`, `CPT_id`, `SCE_image`) VALUES
(1, 'Les Énigmes Mathématiques Merveilleuses', 'ENTRE3569F', 'Les joueurs résolvent des énigmes mathématiques pour progresser, explorant un labyrinthe de nombres et découvrant des mystères liés aux mathématiques.', 'A', 3, 'MATHS.jpeg'),
(2, 'Le Royaume de l\'Informatique Enchantée', 'Jouer69Fin', 'Les joueurs se lancent dans une quête informatique épique, résolvant des codes secrets et des énigmes algorithmiques pour atteindre le trésor numérique au cSur du royaume informatique.', 'A', 5, 'info.png'),
(3, 'Le Voyage Linguistique Anglais', 'SceNAri876', 'Les joueurs partent pour un voyage linguistique dans un monde anglais rempli d\'énigmes de mots, de phrases célèbres et de découvertes linguistiques passionnantes pour accéder au trésor de la langue anglaise.', 'A', 6, 'ANG.jpg'),
(4, 'Les Explorateurs du Monde', 'EUj213POur', 'Les joueurs entreprennent une odyssée à travers le temps et l\'espace, combinant leurs connaissances en géographie et en histoire pour résoudre des énigmes épiques', 'A', 3, 'HG.jpg'),
(7, 'INTITULER1', 'SCE1_tex4', 'TEXT3', 'A', 3, 'imd.png'),
(10, 'L\'Épopée Astronomique des Génis', 'ONjOU3569F', 'Vous entrez dans un portail éthéré et êtes transporté dans une dimension céleste où les énigmes astronomiques règnent.', 'A', 6, 'phyy.jpg'),
(11, 'Le Défi des Génies du Physique', 'ONjOU1234F', 'Vous entrez dans un laboratoire futuriste où le Gardien Physique vous attend.', 'A', 8, 'pp.jpeg'),
(12, 'TestVM_041223', 'z0sDg4yrPb', 'Test de V.MARC', 'A', 48, ''),
(13, 'TestVM_041223_2', 'ClcpV36wJq', 'Test de V.MARC n° 2', 'A', 48, 'SI_L3_Nouveau2.png'),
(14, 'TestVM_041223_3', 'Sc61VEYuBp', 'Encore un autre !', 'A', 48, 'RAPPEL.png'),
(17, 'sce1', 'UizhSSdTMw', 'scenario', 'A', 48, 'cerise.jpeg'),
(20, 'Fruits', 'aiLMCmT6rN', 'Les fruits', 'A', 3, 'fr.jpg'),
(26, 'Fatou', 'mzOi3oMJik', 'Fatou nisse', 'A', 3, 'cerise.jpeg');

--
-- Déclencheurs `T_SCENARIO_SCE`
--
DELIMITER $$
CREATE TRIGGER `ameliore2` BEFORE UPDATE ON `T_SCENARIO_SCE` FOR EACH ROW BEGIN
    DECLARE message VARCHAR(300);
    DECLARE intituler VARCHAR(300);

    SET intituler := CONCAT('Scénario ', NEW.SCE_id ,' retiré');

    CALL affichage_message(NEW.SCE_id, message);
    
   

       IF (NEW.SCE_activite = 'C')  THEN
        -- Insérer une nouvelle actualité
        insert into T_ACTUALITE_ACT values  
         (NULL ,intituler , message ,  CURDATE() ,'A',  '1' );
        
      SET NEW.SCE_intituler = CONCAT(NEW.SCE_intituler, ' - Caché le ', CURDATE()) ;


      elseif OLD.SCE_activite = 'C' and NEW.SCE_activite = 'A' then
       -- Supprimer l'actualité précédemment insérée
        DELETE FROM T_ACTUALITE_ACT WHERE ACT_intitule LIKE CONCAT('%Scénario ', NEW.SCE_id, ' retiré%');

        -- Enlever la mention « - Caché le 2023-xx-yy » à lintitulé du scénario
        SET NEW.SCE_intituler =SUBSTRING_INDEX(NEW.SCE_intituler, ' - Caché le', 1);
        
        
      END IF;
    
END
$$
DELIMITER ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `T_ACTUALITE_ACT`
--
ALTER TABLE `T_ACTUALITE_ACT`
  ADD PRIMARY KEY (`ACT_id`),
  ADD KEY `fk_T_ACTUALITE_ACT_T_COMPTE_CPT1_idx` (`CPT_id`);

--
-- Index pour la table `T_COMPTE_CPT`
--
ALTER TABLE `T_COMPTE_CPT`
  ADD PRIMARY KEY (`CPT_id`),
  ADD UNIQUE KEY `CPT_pseudo_UNIQUE` (`CPT_login`);

--
-- Index pour la table `T_ETAPE_ETP`
--
ALTER TABLE `T_ETAPE_ETP`
  ADD PRIMARY KEY (`ETP_id`),
  ADD KEY `fk_T_ETAPE_ETP_T_SCENARIO_SCE1_idx` (`SCE_id`),
  ADD KEY `fk_T_ETAPE_ETP_T_RESSOURCE_RSC1_idx` (`RSC_id`);

--
-- Index pour la table `T_INDICE_IDE`
--
ALTER TABLE `T_INDICE_IDE`
  ADD PRIMARY KEY (`IDE_id`),
  ADD KEY `fk_T_INDICE_IDE_T_ETAPE_ETP1_idx` (`ETP_id`);

--
-- Index pour la table `T_PARTICIPANT_PTS`
--
ALTER TABLE `T_PARTICIPANT_PTS`
  ADD PRIMARY KEY (`PTS_id`),
  ADD UNIQUE KEY `PTS_mail_UNIQUE` (`PTS_mail`);

--
-- Index pour la table `T_PROFIL_PRO`
--
ALTER TABLE `T_PROFIL_PRO`
  ADD PRIMARY KEY (`CPT_id`),
  ADD UNIQUE KEY `CPT_id_UNIQUE` (`CPT_id`);

--
-- Index pour la table `T_RESSOURCE_RSC`
--
ALTER TABLE `T_RESSOURCE_RSC`
  ADD PRIMARY KEY (`RSC_id`);

--
-- Index pour la table `T_RESULTAT_RLT`
--
ALTER TABLE `T_RESULTAT_RLT`
  ADD PRIMARY KEY (`SCE_id`,`PTS_id`),
  ADD KEY `fk_T_RESULTAT_RLT_T_PARTICIPANT_PTS1_idx` (`PTS_id`);

--
-- Index pour la table `T_SCENARIO_SCE`
--
ALTER TABLE `T_SCENARIO_SCE`
  ADD PRIMARY KEY (`SCE_id`),
  ADD KEY `fk_T_SCENARIO_SCE_T_COMPTE_CPT1_idx` (`CPT_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `T_ACTUALITE_ACT`
--
ALTER TABLE `T_ACTUALITE_ACT`
  MODIFY `ACT_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT pour la table `T_COMPTE_CPT`
--
ALTER TABLE `T_COMPTE_CPT`
  MODIFY `CPT_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `T_ETAPE_ETP`
--
ALTER TABLE `T_ETAPE_ETP`
  MODIFY `ETP_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `T_INDICE_IDE`
--
ALTER TABLE `T_INDICE_IDE`
  MODIFY `IDE_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `T_PARTICIPANT_PTS`
--
ALTER TABLE `T_PARTICIPANT_PTS`
  MODIFY `PTS_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `T_RESSOURCE_RSC`
--
ALTER TABLE `T_RESSOURCE_RSC`
  MODIFY `RSC_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `T_SCENARIO_SCE`
--
ALTER TABLE `T_SCENARIO_SCE`
  MODIFY `SCE_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `T_ACTUALITE_ACT`
--
ALTER TABLE `T_ACTUALITE_ACT`
  ADD CONSTRAINT `fk_T_ACTUALITE_ACT_T_COMPTE_CPT1` FOREIGN KEY (`CPT_id`) REFERENCES `T_COMPTE_CPT` (`CPT_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `T_ETAPE_ETP`
--
ALTER TABLE `T_ETAPE_ETP`
  ADD CONSTRAINT `fk_T_ETAPE_ETP_T_RESSOURCE_RSC1` FOREIGN KEY (`RSC_id`) REFERENCES `T_RESSOURCE_RSC` (`RSC_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_T_ETAPE_ETP_T_SCENARIO_SCE1` FOREIGN KEY (`SCE_id`) REFERENCES `T_SCENARIO_SCE` (`SCE_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `T_INDICE_IDE`
--
ALTER TABLE `T_INDICE_IDE`
  ADD CONSTRAINT `fk_T_INDICE_IDE_T_ETAPE_ETP1` FOREIGN KEY (`ETP_id`) REFERENCES `T_ETAPE_ETP` (`ETP_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `T_PROFIL_PRO`
--
ALTER TABLE `T_PROFIL_PRO`
  ADD CONSTRAINT `fk_T_PROFIL_PRO_T_COMPTE_CPT` FOREIGN KEY (`CPT_id`) REFERENCES `T_COMPTE_CPT` (`CPT_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `T_RESULTAT_RLT`
--
ALTER TABLE `T_RESULTAT_RLT`
  ADD CONSTRAINT `fk_T_RESULTAT_RLT_T_PARTICIPANT_PTS1` FOREIGN KEY (`PTS_id`) REFERENCES `T_PARTICIPANT_PTS` (`PTS_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_T_RESULTAT_RLT_T_SCENARIO_SCE1` FOREIGN KEY (`SCE_id`) REFERENCES `T_SCENARIO_SCE` (`SCE_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `T_SCENARIO_SCE`
--
ALTER TABLE `T_SCENARIO_SCE`
  ADD CONSTRAINT `fk_T_SCENARIO_SCE_T_COMPTE_CPT1` FOREIGN KEY (`CPT_id`) REFERENCES `T_COMPTE_CPT` (`CPT_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
