-- MariaDB dump 10.19  Distrib 10.5.15-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: nachweis2_db
-- ------------------------------------------------------
-- Server version	10.5.15-MariaDB-0+deb11u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `id_project_filepath`
--

DROP TABLE IF EXISTS `id_project_filepath`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `id_project_filepath` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project` varchar(100) DEFAULT NULL,
  `filepath` varchar(100) DEFAULT NULL,
  `search` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `id_project_filepath`
--

LOCK TABLES `id_project_filepath` WRITE;
/*!40000 ALTER TABLE `id_project_filepath` DISABLE KEYS */;
/*!40000 ALTER TABLE `id_project_filepath` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kommentare_id_datum_stunden`
--

DROP TABLE IF EXISTS `kommentare_id_datum_stunden`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kommentare_id_datum_stunden` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datum` date DEFAULT NULL,
  `kommentar_1` varchar(500) DEFAULT NULL,
  `kommentar_2` varchar(500) DEFAULT NULL,
  `kommentar_3` varchar(500) DEFAULT NULL,
  `kommentar_4` varchar(500) DEFAULT NULL,
  `kommentar_5` varchar(500) DEFAULT NULL,
  `einzelstunde_1` float DEFAULT NULL,
  `einzelstunde_2` float DEFAULT NULL,
  `einzelstunde_3` float DEFAULT NULL,
  `einzelstunde_4` float DEFAULT NULL,
  `einzelstunde_5` float DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `datum` (`datum`),
  KEY `kommentare_id_datum_stunden_ibfk` (`user_id`),
  CONSTRAINT `kommentare_id_datum_stunden_ibfk` FOREIGN KEY (`user_id`) REFERENCES `name_vorname_starttimestamp` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kommentare_id_datum_stunden`
--

LOCK TABLES `kommentare_id_datum_stunden` WRITE;
/*!40000 ALTER TABLE `kommentare_id_datum_stunden` DISABLE KEYS */;
/*!40000 ALTER TABLE `kommentare_id_datum_stunden` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nachweis`
--

DROP TABLE IF EXISTS `nachweis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nachweis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lfd_nr` int(11) DEFAULT NULL,
  `teil_ausbildungsberuf_buchstabe` char(1) DEFAULT NULL,
  `teil_ausbildungsberuf_beschreibung` varchar(500) DEFAULT NULL,
  `fertigkeiten` varchar(500) DEFAULT NULL,
  `fertigkeiten_buchstabe` varchar(1) DEFAULT NULL,
  `checked` tinyint(1) DEFAULT NULL,
  `woche_von` int(11) DEFAULT NULL,
  `woche_bis` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nachweis`
--

LOCK TABLES `nachweis` WRITE;
/*!40000 ALTER TABLE `nachweis` DISABLE KEYS */;
INSERT INTO `nachweis` VALUES (1,1,'A','Planen, Vorbereiten und Durchführen von Arbeitsaufgaben in Abstimmung mit den kundenspezifischen Geschäfts- und Leistungsprozessen (§ 4 Absatz 2 Nummer 1)','Grundsätze und Methoden des Projektmanagements anwenden','a',NULL,NULL,NULL),(2,1,'A','Planen, Vorbereiten und Durchführen von Arbeitsaufgaben in Abstimmung mit den kundenspezifischen Geschäfts- und Leistungsprozessen (§ 4 Absatz 2 Nummer 1)','Auftragsunterlagen und Durchführbarkeit des Auftragsprüfen, insbesondere in Hinblick auf rechtliche, wirtschaftliche und terminliche Vorgaben, und den Auftrag mit denbetrieblichen Prozessen und Möglichkeiten abstimmen','b',NULL,NULL,NULL),(3,1,'A','Planen, Vorbereiten und Durchführen von Arbeitsaufgaben in Abstimmung mit den kundenspezifischen Geschäfts- und Leistungsprozessen (§ 4 Absatz 2 Nummer 1)','Zeitplan und Reihenfolge der Arbeitsschritte für den eigenen Arbeitsbereich festlegen','c',NULL,NULL,NULL),(4,1,'A','Planen, Vorbereiten und Durchführen von Arbeitsaufgaben in Abstimmung mit den kundenspezifischen Geschäfts- und Leistungsprozessen (§ 4 Absatz 2 Nummer 1)','Termine planen und abstimmen sowie Terminüberwachung durchführen','d',NULL,NULL,NULL),(5,1,'A','Planen, Vorbereiten und Durchführen von Arbeitsaufgaben in Abstimmung mit den kundenspezifischen Geschäfts- und Leistungsprozessen (§ 4 Absatz 2 Nummer 1)','Probleme analysieren und als Aufgabe definieren sowie Lösungsalternativen entwickeln und beurteilen12','e',NULL,NULL,NULL),(6,1,'A','Planen, Vorbereiten und Durchführen von Arbeitsaufgaben in Abstimmung mit den kundenspezifischen Geschäfts- und Leistungsprozessen (§ 4 Absatz 2 Nummer 1)','Arbeits- und Organisationsmittel wirtschaftlich und ökologisch unter Berücksichtigung der vorhandenen Ressourcen und der Budgetvorgaben einsetzen','f',NULL,NULL,NULL),(7,1,'A','Planen, Vorbereiten und Durchführen von Arbeitsaufgaben in Abstimmung mit den kundenspezifischen Geschäfts- und Leistungsprozessen (§ 4 Absatz 2 Nummer 1)','Aufgaben im Team sowie mit internen und externen Kunden und Kundinnen planen und abstimmen','g',NULL,NULL,NULL),(8,1,'A','Planen, Vorbereiten und Durchführen von Arbeitsaufgaben in Abstimmung mit den kundenspezifischen Geschäfts- und Leistungsprozessen (§ 4 Absatz 2 Nummer 1)','betriebswirtschaftlich relevante Daten erheben und bewerten und dabei Geschäfts- und Leistungsprozesse berücksichtigen','h',NULL,NULL,NULL),(9,1,'A','Planen, Vorbereiten und Durchführen von Arbeitsaufgaben in Abstimmung mit den kundenspezifischen Geschäfts- und Leistungsprozessen (§ 4 Absatz 2 Nummer 1)','2Informieren und Beratenvon Kunden und Kundinnen(§ 4 Absatz 2 Nummer 2)eigene Vorgehensweise sowie die Aufgabendurchführungim Team reflektieren und bei der Verbesserung der Arbeitsprozesse mitwirken','i',NULL,NULL,NULL),(10,2,'A','Informieren und Beraten von Kunden und Kundinnen (§ 4 Absatz 2 Nummer 2)','im Rahmen der Marktbeobachtung Preise, Leistungen und Konditionen von Wettbewerbern vergleichen','a',NULL,NULL,NULL),(11,2,'A','Informieren und Beraten von Kunden und Kundinnen (§ 4 Absatz 2 Nummer 2)','Bedarfe von Kunden und Kundinnen feststellen sowie Zielgruppen unterscheiden','b',NULL,NULL,NULL),(12,2,'A','Informieren und Beraten von Kunden und Kundinnen (§ 4 Absatz 2 Nummer 2)','Kunden und Kundinnen unter Beachtung von Kommunikationsregeln informieren und Sachverhalte präsentieren unddabei deutsche und englische Fachbegriffe anwenden3','c',NULL,NULL,NULL),(13,2,'A','Informieren und Beraten von Kunden und Kundinnen (§ 4 Absatz 2 Nummer 2)','Maßnahmen für Marketing und Vertrieb unterstützen','d',NULL,NULL,NULL),(14,2,'A','Informieren und Beraten von Kunden und Kundinnen (§ 4 Absatz 2 Nummer 2)','Informationsquellen auch in englischer Sprache aufgabenbezogen auswerten und für die Kundeninformation nutzen','e',NULL,NULL,NULL),(15,2,'A','Informieren und Beraten von Kunden und Kundinnen (§ 4 Absatz 2 Nummer 2)','Gespräche situationsgerecht führen und Kunden und Kundinnen unter Berücksichtigung der Kundeninteressen beraten','f',NULL,NULL,NULL),(16,2,'A','Informieren und Beraten von Kunden und Kundinnen (§ 4 Absatz 2 Nummer 2)','Kundenbeziehungen unter Beachtung rechtlicher Regelungen und betrieblicher Grundsätze gestalten2','g',NULL,NULL,NULL),(17,2,'A','Informieren und Beraten von Kunden und Kundinnen (§ 4 Absatz 2 Nummer 2)','Daten und Sachverhalte interpretieren, multimedial aufbereiten und situationsgerecht unter Nutzung digitaler Werkzeuge und unter Berücksichtigung der betrieblichen Vorgaben präsentieren3Beurteilen marktgängiger IT-Systeme und kundenspezifischer Lösungen(§ 4 Absatz 2 Nummer 3)','h',NULL,NULL,NULL),(18,3,'A','Beurteilen marktgängiger IT-Systeme und kundenspezifischer Lösungen (§ 4 Absatz 2 Nummer 3)','marktgängige IT-Systeme für unterschiedliche Einsatzbereiche hinsichtlich Leistungsfähigkeit, Wirtschaftlichkeitund Barrierefreiheit beurteilen','a',NULL,NULL,NULL),(19,3,'A','Beurteilen marktgängiger IT-Systeme und kundenspezifischer Lösungen (§ 4 Absatz 2 Nummer 3)','Angebote zu IT-Komponenten, IT-Produkten und ITDienstleistungen einholen und bewerten sowie Spezifikationen und Konditionen vergleichen','b',NULL,NULL,NULL),(20,3,'A','Beurteilen marktgängiger IT-Systeme und kundenspezifischer Lösungen (§ 4 Absatz 2 Nummer 3)','technologische Entwicklungstrends von IT-Systemen feststellen sowie ihre wirtschaftlichen, sozialen und beruflichen Auswirkungen aufzeigen','c',NULL,NULL,NULL),(21,3,'A','Beurteilen marktgängiger IT-Systeme und kundenspezifischer Lösungen (§ 4 Absatz 2 Nummer 3)','Veränderungen von Einsatzfeldern für IT-Systeme aufgrund technischer, wirtschaftlicher und gesellschaftlicher Entwicklungen feststellen SZG Fachinformatiker Anwendungsentwicklung- 2-105Postitionvermittelt Lfd.Nr.zu vermittelnde Fertigkeiten, Kenntnisse und Fähigkeiten4Teil des Ausbildungsberufsbildes Entwickeln, Erstellen und Betreuen von ITLösungen(§ 4 Absatz 2 Nummer 4)zu vermittelnde Fertigkeiten, Kenntnisse und Fähigkeiten','d',NULL,NULL,NULL),(22,4,'A','Entwickeln, Erstellen und Betreuen von ITLösungen (§ 4 Absatz 2 Nummer 4)','IT-Systeme zur Bearbeitung betrieblicher Fachaufgabenanalysieren sowie unter Beachtung insbesondere von Lizenzmodellen, Urheberrechten und Barrierefreiheit konzeptionieren, konfigurieren, testen und dokumentieren1. bis 18.Monat19. bis 36.Monat5','a',NULL,NULL,NULL),(23,4,'A','Entwickeln, Erstellen und Betreuen von ITLösungen (§ 4 Absatz 2 Nummer 4)','Programmiersprachen, insbesondere prozedurale undobjektorientierte Programmiersprachen, unterscheiden','b',NULL,NULL,NULL),(24,4,'A','Entwickeln, Erstellen und Betreuen von ITLösungen (§ 4 Absatz 2 Nummer 4)','systematisch Fehler erkennen, analysieren und beheben','c',NULL,NULL,NULL),(25,4,'A','Entwickeln, Erstellen und Betreuen von ITLösungen (§ 4 Absatz 2 Nummer 4)','Algorithmen formulieren und Anwendungen in einer Programmiersprache erstellen7','d',NULL,NULL,NULL),(26,4,'A','Entwickeln, Erstellen und Betreuen von ITLösungen (§ 4 Absatz 2 Nummer 4)','Datenbankmodelle unterscheiden, Daten organisieren undspeichern sowie Abfragen erstellen5Durchführen und Dokumentieren von qualitätssichernden Maßnahmen(§ 4 Absatz 2 Nummer 5)','e',NULL,NULL,NULL),(27,5,'A','Durchführen und Dokumentieren von qualitätssichernden Maßnahmen (§ 4 Absatz 2 Nummer 5)','betriebliche Qualitätssicherungssysteme im eigenen Arbeitsbereich anwenden und Qualitätssicherungsmaßnahmen projektbegleitend durchführen und dokumentieren4','a',NULL,NULL,NULL),(28,5,'A','Durchführen und Dokumentieren von qualitätssichernden Maßnahmen (§ 4 Absatz 2 Nummer 5)','Ursachen von Qualitätsmängeln systematisch feststellen,beseitigen und dokumentieren8','b',NULL,NULL,NULL),(29,5,'A','Durchführen und Dokumentieren von qualitätssichernden Maßnahmen (§ 4 Absatz 2 Nummer 5)','im Rahmen eines Verbesserungsprozesses die Zielerreichung kontrollieren, insbesondere einen Soll-Ist-Vergleichdurchführen6Umsetzen, Integrierenund Prüfen von Maßnahmen zur IT-Sicherheitund zum Datenschutz(§ 4 Absatz 2 Nummer 6)','c',NULL,NULL,NULL),(30,6,'A','Umsetzen, Integrieren und Prüfen von Maßnahmen zur IT-Sicherheit und zum Datenschutz (§ 4 Absatz 2 Nummer 6)','betriebliche Vorgaben und rechtliche Regelungen zur ITSicherheit und zum Datenschutz einhalten','a',NULL,NULL,NULL),(31,6,'A','Umsetzen, Integrieren und Prüfen von Maßnahmen zur IT-Sicherheit und zum Datenschutz (§ 4 Absatz 2 Nummer 6)','Sicherheitsanforderungen von IT-Systemen analysierenund Maßnahmen zur IT-Sicherheit ableiten, abstimmen,umsetzen und evaluieren6','b',NULL,NULL,NULL),(32,6,'A','Umsetzen, Integrieren und Prüfen von Maßnahmen zur IT-Sicherheit und zum Datenschutz (§ 4 Absatz 2 Nummer 6)','Bedrohungsszenarien erkennen und Schadenspotenzialeunter Berücksichtigung wirtschaftlicher und technischer Kriterien einschätzen','c',NULL,NULL,NULL),(33,6,'A','Umsetzen, Integrieren und Prüfen von Maßnahmen zur IT-Sicherheit und zum Datenschutz (§ 4 Absatz 2 Nummer 6)','Kunden und Kundinnen im Hinblick auf die Anforderungenan die IT-Sicherheit und den Datenschutz beraten6','d',NULL,NULL,NULL),(34,6,'A','Umsetzen, Integrieren und Prüfen von Maßnahmen zur IT-Sicherheit und zum Datenschutz (§ 4 Absatz 2 Nummer 6)','Wirksamkeit und Effizienz der umgesetzten Maßnahmenzur IT-Sicherheit und zum Datenschutz prüfen7Erbringen der Leistungenund Auftragsabschluss(§ 4 Absatz 2 Nummer 7)','e',NULL,NULL,NULL),(35,7,'A','Erbringen der Leistungen und Auftragsabschluss (§ 4 Absatz 2 Nummer 7)','Leistungen nach betrieblichen und vertraglichen Vorgabendokumentieren','a',NULL,NULL,NULL),(36,7,'A','Erbringen der Leistungen und Auftragsabschluss (§ 4 Absatz 2 Nummer 7)','Leistungserbringung unter Berücksichtigung der organisatorischen und terminlichen Vorgaben mit Kunden und Kundinnen abstimmen und kontrollieren','b',NULL,NULL,NULL),(37,7,'A','Erbringen der Leistungen und Auftragsabschluss (§ 4 Absatz 2 Nummer 7)','Veränderungsprozesse begleiten und unterstützen','c',NULL,NULL,NULL),(38,7,'A','Erbringen der Leistungen und Auftragsabschluss (§ 4 Absatz 2 Nummer 7)','Kunden und Kundinnen in die Nutzung von Produkten und Dienstleistungen einweisen7','d',NULL,NULL,NULL),(39,7,'A','Erbringen der Leistungen und Auftragsabschluss (§ 4 Absatz 2 Nummer 7)','Leistungen und Dokumentationen an Kunden und Kundinnen übergeben sowie Abnahmeprotokolle anfertigen','e',NULL,NULL,NULL),(40,7,'A','Erbringen der Leistungen und Auftragsabschluss (§ 4 Absatz 2 Nummer 7)','Kosten für erbrachte Leistungen erfassen sowie im Zeitvergleich und im Soll-Ist-Vergleich bewerten8Betreiben von ITSystemen(§ 4 Absatz 2 Nummer 8)','f',NULL,NULL,NULL),(41,8,'A','Betreiben von ITSystemen (§ 4 Absatz 2 Nummer 8)','Netzwerkkonzepte für unterschiedliche Anwendungsgebiete unterscheiden','a',NULL,NULL,NULL),(42,8,'A','Betreiben von ITSystemen (§ 4 Absatz 2 Nummer 8)','Datenaustausch von vernetzten Systemen realisieren','b',NULL,NULL,NULL),(43,8,'A','Betreiben von ITSystemen (§ 4 Absatz 2 Nummer 8)','Verfügbarkeit und Ausfallwahrscheinlichkeiten analysierenund Lösungsvorschläge unterbreiten3','c',NULL,NULL,NULL),(44,8,'A','Betreiben von ITSystemen (§ 4 Absatz 2 Nummer 8)','Maßnahmen zur präventiven Wartung und zur Störungsvermeidung einleiten und durchführen','d',NULL,NULL,NULL),(45,8,'A','Betreiben von ITSystemen (§ 4 Absatz 2 Nummer 8)','Störungsmeldungen aufnehmen und analysieren sowie Maßnahmen zur Störungsbeseitigung ergreifen SZG Fachinformatiker Anwendungsentwicklung- 3-3Postitionvermittelt Lfd.Nr.Zeitliche Richtwertein Wochen im Teil des Ausbildungsberufsbildeszu vermittelnde Fertigkeiten, Kenntnisse und Fähigkeiten1. bis 18.Monat19. bis 36.Monat Postitionvermittelt Lfd.Nr.Zeitliche Richtwertein Wochen im','e',NULL,NULL,NULL),(46,8,'A','Betreiben von ITSystemen (§ 4 Absatz 2 Nummer 8)','Dokumentationen zielgruppengerecht und barrierefrei anfertigen, bereitstellen und pflegen, insbesondere technische Dokumentationen, System- sowie Benutzerdokumentationen910Inbetriebnehmen von Speicherlösungen(§ 4 Absatz 2 Nummer 9)','f',NULL,NULL,NULL),(47,9,'A','Inbetriebnehmen von Speicherlösungen (§ 4 Absatz 2 Nummer 9)','Sicherheitsmechanismen, insbesondere Zugriffsmöglichkeiten und -rechte, festlegen und implementieren','a',NULL,NULL,NULL),(48,9,'A','Inbetriebnehmen von Speicherlösungen (§ 4 Absatz 2 Nummer 9)','Speicherlösungen, insbesondere Datenbanksysteme,integrieren Programmieren von Softwarelösungen','b',NULL,NULL,NULL),(49,10,'A','(§ 4 Absatz 2 Nummer 10)','Programmspezifikationen festlegen, Datenmodelle und Strukturen aus fachlichen Anforderungen ableiten sowie Schnittstellen festlegen','a',NULL,NULL,NULL),(50,10,'A','(§ 4 Absatz 2 Nummer 10)','Programmiersprachen auswählen und unterschiedliche Programmiersprachen anwenden(§ 4 Absatz 2 Nummer 10)55','b',NULL,NULL,NULL),(51,10,'A','(§ 4 Absatz 2 Nummer 10)','Teilaufgaben von IT-Systemen automatisieren10','c',NULL,NULL,NULL),(52,1,'B','Konzipieren und Umsetzen von kundenspezifischen Softwareanwendungen (§ 4 Absatz 3 Nummer 1)','1zu vermittelnde Fertigkeiten, Kenntnisse und Fähigkeiten Teil des Ausbildungsberufsbildes Konzipieren und Umsetzen von kundenspezifischen Softwareanwendungen(§ 4 Absatz 3 Nummer 1)1. bis 18.Monat19. bis 36.Monata) Vorgehensmodelle und -methoden sowie Entwicklungsumgebungen und -bibliotheken auswählen und einsetzen','a',NULL,NULL,NULL),(53,1,'B','Konzipieren und Umsetzen von kundenspezifischen Softwareanwendungen (§ 4 Absatz 3 Nummer 1)','Analyse- und Designverfahren anwenden15','b',NULL,NULL,NULL),(54,1,'B','Konzipieren und Umsetzen von kundenspezifischen Softwareanwendungen (§ 4 Absatz 3 Nummer 1)','Benutzerschnittstellen ergonomisch gestalten und an Kundenanforderungen anpassen','c',NULL,NULL,NULL),(55,1,'B','Konzipieren und Umsetzen von kundenspezifischen Softwareanwendungen (§ 4 Absatz 3 Nummer 1)','Anwendungslösungen unter Berücksichtigung der bestehenden Systemarchitektur entwerfen und realisieren','d',NULL,NULL,NULL),(56,1,'B','Konzipieren und Umsetzen von kundenspezifischen Softwareanwendungen (§ 4 Absatz 3 Nummer 1)','bestehende Anwendungslösungen anpassen25','e',NULL,NULL,NULL),(57,1,'B','Konzipieren und Umsetzen von kundenspezifischen Softwareanwendungen (§ 4 Absatz 3 Nummer 1)','Datenaustausch zwischen Systemen realisieren und unterschiedliche Datenquellen nutzen','f',NULL,NULL,NULL),(58,1,'B','Konzipieren und Umsetzen von kundenspezifischen Softwareanwendungen (§ 4 Absatz 3 Nummer 1)','komplexe Abfragen aus unterschiedlichen Datenquellendurchführen und Datenbestandsberichte erstellen2Sicherstellen der Qualitätvon Softwareanwendungen(§ 4 Absatz 3 Nummer 2)','g',NULL,NULL,NULL),(59,2,'B','Sicherstellen der Qualität von Softwareanwendungen (§ 4 Absatz 3 Nummer 2)','Sicherheitsaspekte bei der Entwicklung von Softwareanwendungen berücksichtigen','a',NULL,NULL,NULL),(60,2,'B','Sicherstellen der Qualität von Softwareanwendungen (§ 4 Absatz 3 Nummer 2)','Datenintegrität mithilfe von Werkzeugen sicherstellen5','b',NULL,NULL,NULL),(61,2,'B','Sicherstellen der Qualität von Softwareanwendungen (§ 4 Absatz 3 Nummer 2)','Modultests erstellen und durchführen','c',NULL,NULL,NULL),(62,2,'B','Sicherstellen der Qualität von Softwareanwendungen (§ 4 Absatz 3 Nummer 2)','Werkzeuge zur Versionsverwaltung einsetzen','d',NULL,NULL,NULL),(63,2,'B','Sicherstellen der Qualität von Softwareanwendungen (§ 4 Absatz 3 Nummer 2)','Testkonzepte erstellen und Tests durchführen sowie Testergebnisse bewerten und dokumentieren','e',NULL,NULL,NULL),(64,2,'B','Sicherstellen der Qualität von Softwareanwendungen (§ 4 Absatz 3 Nummer 2)','Daten und Sachverhalte aus Tests multimedial aufbereitenund situationsgerecht unter Nutzung digitaler Werkzeugeund unter Beachtung der betrieblichen Vorgaben präsentieren SZG Fachinformatiker Anwendungsentwicklung- 4-7Postitionvermittelt.Lfd.Nr.Zeitliche Richtwertein Wochen im','f',NULL,NULL,NULL),(65,1,'F','Berufsbildung sowie Arbeits- und Tarifrecht (§ 4 Absatz 7 Nummer 1)','1Teil des Ausbildungsberufsbildeszu vermittelnde Fertigkeiten, Kenntnisse und Fähigkeiten Berufsbildung sowie Arbeits- und Tarifrecht(§ 4 Absatz 7 Nummer 1)a) wesentliche Inhalte und Bestandteile des Ausbildungsvertrages darstellen, Rechte und Pflichten aus dem Ausbildungsvertrag feststellen und Aufgaben der Beteiligten imdualen System beschreiben1. bis 18.Monat19. bis 36.Monat','a',NULL,NULL,NULL),(66,1,'F','Berufsbildung sowie Arbeits- und Tarifrecht (§ 4 Absatz 7 Nummer 1)','den betrieblichen Ausbildungsplan mit der Ausbildungsordnung vergleichen','b',NULL,NULL,NULL),(67,1,'F','Berufsbildung sowie Arbeits- und Tarifrecht (§ 4 Absatz 7 Nummer 1)','arbeits-, sozial- und mitbestimmungsrechtliche Vorschriften so wie für den Arbeitsbereich geltende Tarif- und Arbeitszeitregelungen beachten','c',NULL,NULL,NULL),(68,1,'F','Berufsbildung sowie Arbeits- und Tarifrecht (§ 4 Absatz 7 Nummer 1)','Positionen der eigenen Entgeltabrechnung erklären','d',NULL,NULL,NULL),(69,1,'F','Berufsbildung sowie Arbeits- und Tarifrecht (§ 4 Absatz 7 Nummer 1)','Chancen und Anforderungen des lebensbegleitenden Lernens für die berufliche und persönliche Entwicklung begründen und die eigenen Kompetenzen weiterentwickeln','e',NULL,NULL,NULL),(70,1,'F','Berufsbildung sowie Arbeits- und Tarifrecht (§ 4 Absatz 7 Nummer 1)','Lern- und Arbeitstechniken sowie Methoden des selbstgesteuerten Lernens anwenden und beruflich relevante Informationsquellen nutzen','f',NULL,NULL,NULL),(71,1,'F','Berufsbildung sowie Arbeits- und Tarifrecht (§ 4 Absatz 7 Nummer 1)','berufliche Aufstiegs- und Weiterentwicklungsmöglichkeitendarstellen2Aufbau und Organisationdes Ausbildungsbetriebes(§ 4 Absatz 7 Nummer 2)','g',NULL,NULL,NULL),(72,2,'F','Aufbau und Organisation des Ausbildungsbetriebes (§ 4 Absatz 7 Nummer 2)','die Rechtsform und den organisatorischen Aufbau des Ausbildungsbetriebes mit seinen Aufgaben und Zuständigkeiten sowie die Zusammenhänge zwischen den Geschäftsprozessen erläutern','a',NULL,NULL,NULL),(73,2,'F','Aufbau und Organisation des Ausbildungsbetriebes (§ 4 Absatz 7 Nummer 2)','Beziehungen des Ausbildungsbetriebes und seiner Beschäftigten zu Wirtschaftsorganisationen, Berufsvertretungen und Gewerkschaften nennen','b',NULL,NULL,NULL),(74,2,'F','Aufbau und Organisation des Ausbildungsbetriebes (§ 4 Absatz 7 Nummer 2)','Grundlagen, Aufgaben und Arbeitsweise der betriebsverfassungsrechtlichen Organe des Ausbildungsbetriebes beschreiben3Sicherheit und Gesundheitsschutz bei der Arbeit(§ 4 Absatz 7 Nummer 3)während dergesamten Ausbildung','c',NULL,NULL,NULL),(75,3,'F','Sicherheit und Gesundheitsschutz bei der Arbeit (§ 4 Absatz 7 Nummer 3)','Gefährdung von Sicherheit und Gesundheit am Arbeitsplatz feststellen und Maßnahmen zur Vermeidung der Gefährdung ergreifen','a',NULL,NULL,NULL),(76,3,'F','Sicherheit und Gesundheitsschutz bei der Arbeit (§ 4 Absatz 7 Nummer 3)','berufsbezogene Arbeitsschutz- und Unfallverhütungsvorschriften anwenden','b',NULL,NULL,NULL),(77,3,'F','Sicherheit und Gesundheitsschutz bei der Arbeit (§ 4 Absatz 7 Nummer 3)','Verhaltensweisen bei Unfällen beschreiben sowie erste Maßnahmen einleiten','c',NULL,NULL,NULL),(78,3,'F','Sicherheit und Gesundheitsschutz bei der Arbeit (§ 4 Absatz 7 Nummer 3)','Vorschriften des vorbeugenden Brandschutzes anwendensowie Verhaltensweisen bei Bränden beschreiben und Maßnahmen zur Brandbekämpfung ergreifen4Umweltschutz(§ 4 Absatz 7 Nummer 4)Zur Vermeidung betriebsbedingter Umweltbelastungen imberuflichen Einwirkungsbereich beitragen, insbesondere','d',NULL,NULL,NULL),(79,4,'F','Umweltschutz (§ 4 Absatz 7 Nummer 4)','mögliche Umweltbelastungen durch den Ausbildungsbetrieb und seinen Beitrag zum Umweltschutz an Beispielenerklären','a',NULL,NULL,NULL),(80,4,'F','Umweltschutz (§ 4 Absatz 7 Nummer 4)','für den Ausbildungsbetrieb geltende Regelungen des Umweltschutzes anwenden','b',NULL,NULL,NULL),(81,4,'F','Umweltschutz (§ 4 Absatz 7 Nummer 4)','Möglichkeiten der wirtschaftlichen und umweltschonenden Energie- und Materialverwendung nutzen','c',NULL,NULL,NULL),(82,4,'F','Umweltschutz (§ 4 Absatz 7 Nummer 4)','Abfälle vermeiden sowie Stoffe und Materialien einer umweltschonenden Entsorgung zuführen5Vernetztes Zusammenarbeiten unter Nutzungdigitaler Medien(§ 4 Absatz 7 Nummer 5)','d',NULL,NULL,NULL),(83,5,'F','Vernetztes Zusammenarbeiten unter Nutzung digitaler Medien (§ 4 Absatz 7 Nummer 5)','gegenseitige Wertschätzung unter Berücksichtigung gesellschaftlicher Vielfalt bei betrieblichen Abläufen praktizieren SZG Fachinformatiker Anwendungsentwicklung- 5-3Postitionvermittelt Lfd.Nr.Zeitliche Richtwertein Wochen im Teil des Ausbildungsberufsbildeszu vermittelnde Fertigkeiten, Kenntnisse und Fähigkeiten','a',NULL,NULL,NULL),(84,5,'F','Vernetztes Zusammenarbeiten unter Nutzung digitaler Medien (§ 4 Absatz 7 Nummer 5)','Strategien zum verantwortungsvollen Umgang mit digitalen Medien anwenden und im virtuellen Raum unter Wahrungder Persönlichkeitsrechte Dritter zusammenarbeiten','b',NULL,NULL,NULL),(85,5,'F','Vernetztes Zusammenarbeiten unter Nutzung digitaler Medien (§ 4 Absatz 7 Nummer 5)','insbesondere bei der Speicherung, Darstellung und Weitergabe digitaler Inhalte die Auswirkungen des eigenen Kommunikations- und Informationsverhaltens berücksichtigen','c',NULL,NULL,NULL),(86,5,'F','Vernetztes Zusammenarbeiten unter Nutzung digitaler Medien (§ 4 Absatz 7 Nummer 5)','bei der Beurteilung, Entwicklung, Umsetzung und Betreuung von IT-Lösungen ethische Aspekte reflektieren SZG Fachinformatiker Anwendungsentwicklung- 6-1. bis 18.Monat19. bis 36.Monat Postitionvermittelt Lfd.Nr.Zeitliche Richtwertein Wochen im','d',NULL,NULL,NULL);
/*!40000 ALTER TABLE `nachweis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nachweis_to_time_category`
--

DROP TABLE IF EXISTS `nachweis_to_time_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nachweis_to_time_category` (
  `nachweis_id` int(11) NOT NULL,
  `time_category_id` int(11) NOT NULL,
  `richtwert_wochen` int(11) NOT NULL,
  KEY `nachweis_id` (`nachweis_id`),
  KEY `time_category_id` (`time_category_id`),
  CONSTRAINT `nachweis_to_time_category_ibfk_1` FOREIGN KEY (`nachweis_id`) REFERENCES `nachweis` (`id`) ON DELETE CASCADE,
  CONSTRAINT `nachweis_to_time_category_ibfk_2` FOREIGN KEY (`time_category_id`) REFERENCES `time_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nachweis_to_time_category`
--

LOCK TABLES `nachweis_to_time_category` WRITE;
/*!40000 ALTER TABLE `nachweis_to_time_category` DISABLE KEYS */;
INSERT INTO `nachweis_to_time_category` VALUES (2,1,12),(3,1,12),(4,1,12),(5,1,12),(6,1,12),(7,1,12),(8,1,12),(9,1,12),(10,1,3),(11,1,3),(12,1,3),(13,1,3),(14,1,3),(15,2,2),(16,2,2),(17,2,2),(18,1,10),(19,1,10),(20,2,5),(21,2,5),(22,1,5),(23,1,5),(24,2,7),(25,2,7),(26,2,7),(27,1,4),(28,2,8),(29,2,8),(30,1,6),(31,1,6),(32,2,6),(33,2,6),(34,2,6),(35,1,7),(36,1,7),(37,1,7),(38,1,7),(39,1,7),(40,1,7),(41,1,3),(42,1,3),(43,1,3),(44,1,3),(45,2,3),(46,2,3),(47,2,5),(48,2,5),(49,1,5),(50,1,5),(51,2,10),(52,1,15),(55,2,25),(53,1,15),(54,1,15),(56,2,25),(57,2,25),(58,2,25),(59,1,5),(60,1,5),(61,1,5),(62,2,7),(63,2,7),(64,2,7),(83,1,3),(84,1,3),(85,1,3),(86,1,3);
/*!40000 ALTER TABLE `nachweis_to_time_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nachweisdatei_wochennr_id`
--

DROP TABLE IF EXISTS `nachweisdatei_wochennr_id`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nachweisdatei_wochennr_id` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wochennr` int(11) DEFAULT NULL,
  `nachweisdatei` longblob DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `signiert` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nachweisdatei_wochennr_id`
--

LOCK TABLES `nachweisdatei_wochennr_id` WRITE;
/*!40000 ALTER TABLE `nachweisdatei_wochennr_id` DISABLE KEYS */;
/*!40000 ALTER TABLE `nachweisdatei_wochennr_id` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `name_vorname_starttimestamp`
--

DROP TABLE IF EXISTS `name_vorname_starttimestamp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `name_vorname_starttimestamp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `vorname` varchar(20) DEFAULT NULL,
  `starttimestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `name_vorname_starttimestamp`
--

LOCK TABLES `name_vorname_starttimestamp` WRITE;
/*!40000 ALTER TABLE `name_vorname_starttimestamp` DISABLE KEYS */;
/*!40000 ALTER TABLE `name_vorname_starttimestamp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `remarks`
--

DROP TABLE IF EXISTS `remarks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `remarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `woche` int(11) DEFAULT NULL,
  `zeile` int(11) DEFAULT NULL,
  `spalte` int(11) DEFAULT NULL,
  `bemerkung` varchar(38) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `un_remark` (`woche`,`zeile`,`spalte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `remarks`
--

LOCK TABLES `remarks` WRITE;
/*!40000 ALTER TABLE `remarks` DISABLE KEYS */;
/*!40000 ALTER TABLE `remarks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag_nachweise`
--

DROP TABLE IF EXISTS `tag_nachweise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag_nachweise` (
  `tag_id` int(11) DEFAULT NULL,
  `kommentarnummer` int(11) DEFAULT NULL,
  `nachweis_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  UNIQUE KEY `unique_const` (`tag_id`,`nachweis_id`),
  KEY `tag_id` (`tag_id`),
  KEY `nachweis_id` (`nachweis_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tag_nachweise_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `kommentare_id_datum_stunden` (`id`),
  CONSTRAINT `tag_nachweise_ibfk_2` FOREIGN KEY (`nachweis_id`) REFERENCES `nachweis` (`id`),
  CONSTRAINT `tag_nachweise_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `name_vorname_starttimestamp` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag_nachweise`
--

LOCK TABLES `tag_nachweise` WRITE;
/*!40000 ALTER TABLE `tag_nachweise` DISABLE KEYS */;
/*!40000 ALTER TABLE `tag_nachweise` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `time_categories`
--

DROP TABLE IF EXISTS `time_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `time_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `woche_start` int(11) DEFAULT NULL,
  `woche_end` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time_categories`
--

LOCK TABLES `time_categories` WRITE;
/*!40000 ALTER TABLE `time_categories` DISABLE KEYS */;
INSERT INTO `time_categories` VALUES (1,0,72),(2,73,144);
/*!40000 ALTER TABLE `time_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `woche_ausbildungsnachweisnr`
--

DROP TABLE IF EXISTS `woche_ausbildungsnachweisnr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `woche_ausbildungsnachweisnr` (
  `woche` int(11) DEFAULT NULL,
  `ausbildungsnachweisnr` int(11) DEFAULT NULL,
  UNIQUE KEY `woche` (`woche`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `woche_ausbildungsnachweisnr`
--

LOCK TABLES `woche_ausbildungsnachweisnr` WRITE;
/*!40000 ALTER TABLE `woche_ausbildungsnachweisnr` DISABLE KEYS */;
/*!40000 ALTER TABLE `woche_ausbildungsnachweisnr` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-14 14:50:21
