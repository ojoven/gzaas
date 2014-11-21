-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 22-11-2014 a las 00:35:53
-- Versión del servidor: 5.5.34
-- Versión de PHP: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `gzaas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apikeys`
--

CREATE TABLE IF NOT EXISTS `apikeys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `apiKey` varchar(12) COLLATE utf8_bin NOT NULL,
  `web` varchar(125) COLLATE utf8_bin NOT NULL,
  `contact` varchar(125) COLLATE utf8_bin NOT NULL,
  `date` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apikey_message`
--

CREATE TABLE IF NOT EXISTS `apikey_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `apiKey` varchar(12) COLLATE utf8_bin NOT NULL,
  `idMessage` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `back_color_message`
--

CREATE TABLE IF NOT EXISTS `back_color_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador backcolor_mensaje',
  `idM` int(11) NOT NULL COMMENT 'identificador mensaje',
  `backColor` varchar(6) NOT NULL COMMENT 'backcolor (hexadecimal)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `back_color_message`
--

INSERT INTO `back_color_message` (`id`, `idM`, `backColor`) VALUES
(1, 2, '390031');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `color_message`
--

CREATE TABLE IF NOT EXISTS `color_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador color_mensaje',
  `idM` int(11) NOT NULL COMMENT 'identificador mensaje',
  `color` varchar(6) NOT NULL COMMENT 'color (hexadecimal)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `color_message`
--

INSERT INTO `color_message` (`id`, `idM`, `color`) VALUES
(1, 1, '444444'),
(2, 2, 'ff0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fonts`
--

CREATE TABLE IF NOT EXISTS `fonts` (
  `idF` int(11) NOT NULL COMMENT 'ideniticador del metaTag Font',
  `inUse` tinyint(1) NOT NULL DEFAULT '1',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `font` varchar(32) NOT NULL COMMENT 'fuente (hashtag)',
  `idHashtag` int(11) NOT NULL COMMENT 'identificador del hashtag asociado',
  `fontFamily` varchar(255) NOT NULL COMMENT 'fuente a utilizar',
  `fontFace` tinyint(1) NOT NULL,
  `stylesheet` varchar(64) NOT NULL,
  `size` float(3,2) NOT NULL COMMENT 'tamaño relativo frente a arial',
  `fontServer` int(2) NOT NULL,
  `designer` varchar(64) DEFAULT NULL,
  `urlDesigner1` varchar(255) DEFAULT NULL,
  `urlDesigner2` varchar(255) DEFAULT NULL,
  `description` varchar(32) NOT NULL,
  `exclusive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idF`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `fonts`
--

INSERT INTO `fonts` (`idF`, `inUse`, `featured`, `font`, `idHashtag`, `fontFamily`, `fontFace`, `stylesheet`, `size`, `fontServer`, `designer`, `urlDesigner1`, `urlDesigner2`, `description`, `exclusive`) VALUES
(1, 1, 0, 'arial', 1, '''Arial''', 0, '', 1.00, 0, NULL, NULL, NULL, 'Arial', 0),
(2, 0, 0, 'contra', 2, '''ContraRegular''', 1, 'Contra', 1.00, 1, 'Apostrophic Labs', 'http://www.fontsquirrel.com/foundry/Apostrophic-Labs', 'http://moorstation.org/typoasis/designers/lab/index.htm', 'Contra', 0),
(3, 1, 0, 'verdana', 3, '''Verdana''', 0, '', 1.00, 0, NULL, NULL, NULL, 'Verdana', 0),
(4, 1, 0, 'georgia', 4, '''Georgia''', 0, '', 1.00, 0, NULL, NULL, NULL, 'Georgia', 0),
(5, 0, 0, 'comicsans', 5, '''Comic Sans'',''Comic Sans MS''', 0, '', 1.00, 0, NULL, NULL, NULL, 'Comic Sans', 0),
(6, 1, 0, 'times', 6, '''Times New Roman''', 0, '', 1.00, 0, NULL, NULL, NULL, 'Times New Roman', 0),
(7, 0, 0, 'qikki', 7, '''QikkiRegRegular''', 1, 'Qikki', 1.15, 1, 'Joanne Taylor', 'http://www.fontsquirrel.com/foundry/Joanne-Taylor', NULL, 'Qikki', 0),
(8, 0, 0, '1942report', 8, '''1942report1942report''', 1, '1942report', 1.00, 1, 'Johan Holmdahl', 'http://www.fontsquirrel.com/foundry/Johan-Holmdahl', NULL, '1942Report', 0),
(9, 1, 0, 'chunkfive', 9, '''ChunkFiveRegular''', 1, 'ChunkFive', 1.00, 1, 'The League of Moveable Type', 'http://www.fontsquirrel.com/foundry/The-League-of-Moveable-Type', 'http://www.theleagueofmoveabletype.com', 'ChunkFive', 0),
(10, 0, 0, 'communist', 10, '''CommunistRegular''', 1, 'Communist', 1.00, 1, 'Shamrock', 'http://www.fontsquirrel.com/foundry/Shamrock', 'http://www.shamrocking.com', 'Communist', 0),
(11, 0, 0, 'englandhand', 11, '''EnglandHandDBRegular''', 1, 'EnglandHand', 1.00, 1, 'DATA BECKER GmbH', 'http://www.fontsquirrel.com/foundry/DATA-BECKER-GmbH', NULL, 'EnglandHand', 0),
(12, 0, 0, 'firsttest', 12, '''firsttestRegular''', 1, 'FirstTest', 1.00, 1, 'Tup Wanders', 'http://www.fontsquirrel.com/foundry/Tup-Wanders', 'http://www.tupwanders.nl', 'FirstTest', 0),
(13, 0, 0, 'gladifilthefte', 13, '''GladifilthefteGladifilthefte''', 1, 'Gladifilthefte', 1.00, 1, 'Tup Wanders', 'http://www.fontsquirrel.com/foundry/Tup-Wanders', 'http://www.tupwanders.nl', 'Gladifilthefte', 0),
(14, 1, 0, 'journal', 14, '''JournalRegular''', 1, 'Journal', 0.70, 1, 'Fontourist', 'http://www.fontsquirrel.com/foundry/Fontourist', 'http://www.fontourist.com/', 'Journal', 0),
(15, 0, 0, 'knowyourproduct', 15, '''KnowYourProductRegular''', 1, 'KnowYourProduct', 1.70, 1, 'Vic Fieger', 'http://www.fontsquirrel.com/foundry/Vic-Fieger', 'http://www.vicfieger.com', 'KnowYourProduct', 0),
(16, 1, 0, 'kulminoituva', 16, '''KulminoituvaRegular''', 1, 'Kulminoituva', 1.00, 1, 'junkohanhero', 'http://www.fontsquirrel.com/foundry/junkohanhero', 'http://www.junkohanhero.com/fontit.htm', 'Kulminoituva', 0),
(17, 1, 1, 'lobster', 17, '''Lobster13Regular''', 1, 'Lobster', 1.00, 1, 'Pablo Impallari', 'http://www.fontsquirrel.com/foundry/Pablo-Impallari', 'http://www.impallari.com', 'Lobster', 0),
(18, 0, 0, 'momstypewriter', 18, '''MomsTypewriterRegular''', 1, 'MomsTypewriter', 1.00, 1, 'Christoph Mueller', 'http://www.fontsquirrel.com/foundry/Christoph-Mueller', 'http://www.cuci.nl/~nonsuch/free.htm', 'MomsTypewriter', 0),
(19, 0, 0, 'nervousrex', 19, '''NervousRexRegular''', 1, 'NervousRex', 1.00, 1, 'Vic Fieger', 'http://www.fontsquirrel.com/foundry/Vic-Fieger', 'http://www.vicfieger.com', 'NervousRex', 0),
(20, 0, 0, 'pincoyablack', 20, '''PincoyablackBlack''', 1, 'PincoyaBlack', 1.00, 1, 'Daniel Hernández', 'http://www.fontsquirrel.com/foundry/Daniel-Hernandez', 'http://estudiocalderon.cl/', 'PincoyaBlack', 0),
(21, 0, 0, 'plexifont', 21, '''PlexifontBVRegular''', 1, 'Plexifont', 1.00, 1, 'Blue Vinyl Fonts', 'http://www.fontsquirrel.com/foundry/Blue-Vinyl-Fonts', 'http://www.bvfonts.com', 'Plexifont', 0),
(22, 1, 0, 'riesling', 22, '''RieslingRegular''', 1, 'Riesling', 0.75, 1, 'Bright Ideas', 'http://www.fontsquirrel.com/foundry/Bright-Ideas', NULL, 'Riesling', 0),
(23, 1, 0, 'speakeasy', 23, '''SFSpeakeasyRegular''', 1, 'Speakeasy', 1.10, 1, 'ShyFonts', 'http://www.fontsquirrel.com/foundry/ShyFonts', NULL, 'Speakeasy', 0),
(24, 1, 0, 'tangerine', 24, '''TangerineRegular''', 1, 'Tangerine', 0.60, 1, 'Toshi Omagari', 'http://www.fontsquirrel.com/foundry/Toshi-Omagari', NULL, 'Tangerine', 0),
(25, 0, 0, 'tiza', 25, '''TizaRegular''', 1, 'Tiza', 1.40, 1, 'Pablo Caro', 'http://www.fontsquirrel.com/foundry/Pablo-Caro', 'http://www.nuevostudio.com/', 'Tiza', 0),
(26, 1, 0, 'ubuntutitle', 26, '''UbuntuTitle''', 1, 'UbuntuTitle', 0.80, 1, 'Andrew Fitzsimon', 'http://www.fontsquirrel.com/foundry/Andrew-Fitzsimon', NULL, 'UbuntuTitle', 0),
(27, 0, 0, 'undercover', 27, '''UndercoverRegular''', 1, 'Undercover', 2.00, 1, 'pizzadude.dk', 'http://www.fontsquirrel.com/foundry/pizzadude.dk', 'http://www.pizzadude.dk', 'Undercover', 0),
(28, 1, 0, 'slackey', 28, '''Slackey''', 1, 'Slackey:regular', 1.50, 2, 'Sideshow', 'http://code.google.com/webfonts/designer?designer=Sideshow', 'http://squidart.com/', 'Slackey', 0),
(29, 1, 1, 'allan', 29, '''Allan''', 1, 'Allan:bold', 1.00, 2, 'Anton Koovit', 'http://code.google.com/webfonts/designer?designer=Anton+Koovit', 'http://anton.korkork.com/', 'Allan', 0),
(30, 0, 0, 'allertastencil', 30, '''Allerta Stencil''', 1, 'Allerta+Stencil:regular', 1.00, 2, 'Matt McInerney', 'http://code.google.com/webfonts/designer?designer=Matt+McInerney', 'http://pixelspread.com', 'Allerta Stencil', 0),
(31, 1, 0, 'anonymouspro', 31, '''Anonymous Pro''', 1, 'Anonymous+Pro:regular,italic,bold,bolditalic', 1.00, 2, 'Mark Simonson', 'http://code.google.com/webfonts/designer?designer=Mark+Simonson', 'http://www.ms-studio.com', 'Anonymous Pro', 0),
(32, 0, 0, 'arvo', 32, '''Arvo''', 1, 'Arvo:regular,italic,bold,bolditalic', 1.00, 2, 'Anton Koovit', 'http://code.google.com/webfonts/designer?designer=Anton+Koovit', 'http://anton.korkork.com/', 'Arvo', 0),
(33, 1, 0, 'bentham', 33, '''Bentham''', 1, 'Bentham:regular', 1.00, 2, 'Ben Weiner', 'http://code.google.com/webfonts/designer?designer=Ben+Weiner', 'http://www.readingtype.org.uk', 'Bentham', 0),
(34, 0, 0, 'buda', 34, '''Buda''', 1, 'Buda:300', 1.00, 2, 'Adèle Antignac', 'http://code.google.com/webfonts/designer?designer=Ad%C3%A8le+Antignac', 'http://adele.antignac.free.fr/', 'Buda', 0),
(35, 1, 0, 'cabin', 35, '''Cabin''', 1, 'Cabin:bold', 1.00, 2, 'Pablo Impallari', 'http://code.google.com/webfonts/designer?designer=Pablo+Impallari', 'http://www.impallari.com/', 'Cabin', 0),
(36, 1, 1, 'calligraffitti', 36, '''Calligraffitti''', 1, 'Calligraffitti:regular', 1.00, 2, 'Open Window', 'http://code.google.com/webfonts/designer?designer=Open+Window', 'http://new.myfonts.com/foundry/Open_Window/', 'Calligraffitti', 0),
(37, 1, 1, 'chewy', 37, '''Chewy''', 1, 'Chewy:regular', 1.00, 2, 'Sideshow', 'http://code.google.com/webfonts/designer?designer=Sideshow', 'http://squidart.com/', 'Chewy', 0),
(38, 0, 0, 'coda', 38, '''Coda''', 1, 'Coda:800', 2.00, 2, 'Vernon Adams', 'http://code.google.com/webfonts/designer?designer=Vernon+Adams', 'http://www.newtypography.co.uk', 'Coda', 0),
(39, 1, 0, 'comingsoon', 39, '''Coming Soon''', 1, 'Coming+Soon:regular', 1.00, 2, 'Open Window', 'http://code.google.com/webfonts/designer?designer=Open+Window', 'http://new.myfonts.com/foundry/Open_Window/', 'Coming Soon', 0),
(40, 0, 0, 'copse', 40, '''Copse''', 1, 'Copse:regular', 1.00, 2, 'Dan Rhatigan', 'http://code.google.com/webfonts/designer?designer=Dan+Rhatigan', 'http://ultrasparky.org', 'Copse', 0),
(41, 1, 0, 'bloody', 41, '''BloodyNormal''', 1, 'Bloody', 1.00, 1, 'James Fordyce', 'http://www.fontsquirrel.com/foundry/James-Fordyce', NULL, 'Bloody', 0),
(42, 1, 0, 'kranky', 42, '''Kranky''', 1, 'Kranky:regular', 1.00, 2, 'Sideshow', 'http://code.google.com/webfonts/designer?designer=Sideshow', 'http://squidart.com/', 'Kranky', 0),
(43, 1, 0, 'sniglet', 43, '''Sniglet''', 1, 'Sniglet:800', 1.00, 2, 'Haley Fiege', 'http://www.google.com/webfonts/designer?designer=Haley+Fiege', 'http://www.kingdomofawesome.com', 'Sniglet', 0),
(44, 1, 0, 'reeniebeanie', 44, '''Reenie Beanie''', 1, 'Reenie+Beanie:regular', 1.00, 2, 'James Grieshaber', 'http://www.google.com/webfonts/designer?designer=James+Grieshaber', 'http://en.wikipedia.org/wiki/James_Grieshaber', 'Reenie Beanie', 0),
(45, 0, 0, 'sunshiney', 45, '''Sunshiney''', 1, 'Sunshiney:regular', 1.00, 2, 'Sideshow', 'http://code.google.com/webfonts/designer?designer=Sideshow', 'http://squidart.com/', 'Sunshiney', 0),
(46, 1, 0, 'permanentmarker', 46, '''Permanent Marker''', 1, 'Permanent+Marker:regular', 1.00, 2, 'Font Diner', 'http://www.google.com/webfonts/designer?designer=Font+Diner', 'http://www.fontdiner.com', 'Permanent Marker', 0),
(47, 1, 0, 'mountainsofchristmas', 47, '''Mountains of Christmas''', 1, 'Mountains+of+Christmas:regular', 1.00, 2, 'Tart Workshop', 'http://www.google.com/webfonts/designer?designer=Tart+Workshop', 'http://www.tartworkshop.com', 'Mountains of Christmas', 0),
(48, 1, 1, 'luckiestguy', 48, '''Luckiest Guy''', 1, 'Luckiest+Guy:regular', 1.00, 2, 'Astigmatic', 'http://www.google.com/webfonts/designer?designer=Astigmatic', 'http://www.astigmatic.com', 'Luckiest Guy', 0),
(49, 1, 0, 'orbitron', 49, '''OrbitronLight''', 1, 'Orbitron', 1.00, 1, 'The League of Moveable Type', 'http://www.fontsquirrel.com/foundry/The-League-of-Moveable-Type', 'http://www.theleagueofmoveabletype.com', 'Orbitron', 0),
(50, 0, 0, 'orbitronmedium', 50, '''OrbitronMedium''', 1, 'Orbitron', 1.00, 1, 'The League of Moveable Type', 'http://www.fontsquirrel.com/foundry/The-League-of-Moveable-Type', 'http://www.theleagueofmoveabletype.com', 'Orbitron Medium', 0),
(51, 0, 0, 'orbitronbold', 51, '''OrbitronBold''', 1, 'Orbitron', 1.00, 1, 'The League of Moveable Type', 'http://www.fontsquirrel.com/foundry/The-League-of-Moveable-Type', 'http://www.theleagueofmoveabletype.com', 'Orbitron Bold', 0),
(52, 0, 0, 'orbitronblack', 52, '''OrbitronBlack''', 1, 'Orbitron', 1.00, 1, 'The League of Moveable Type', 'http://www.fontsquirrel.com/foundry/The-League-of-Moveable-Type', 'http://www.theleagueofmoveabletype.com', 'Orbitron Black', 0),
(53, 1, 1, 'museoslab', 53, '''MuseoSlab500''', 1, 'MuseoSlab', 1.00, 1, 'Exljbris', 'http://www.fontsquirrel.com/foundry/Exljbris', 'http://www.josbuivenga.demon.nl/', 'Museo Slab', 0),
(54, 1, 0, 'fenwickoutline', 54, '''FenwickOutline''', 1, 'FenwickOutline', 1.00, 1, 'Typodermic', 'http://www.fontsquirrel.com/foundry/Typodermic', 'http://www.typodermic.com', 'Fenwick Outline', 0),
(55, 1, 1, 'grutchshaded', 55, '''GrutchShadedRegular''', 1, 'GrutchShaded', 1.00, 1, 'Steeve Gruson', 'http://www.fontsquirrel.com/foundry/Steeve-Gruson', NULL, 'Grutch Shaded', 0),
(56, 0, 0, 'museosans', 56, '''MuseoSans500''', 1, 'MuseoSans', 1.00, 1, 'Exljbris', 'http://www.fontsquirrel.com/foundry/Exljbris', 'http://www.josbuivenga.demon.nl/', 'Museo Sans', 0),
(57, 1, 0, 'slapstickcomic', 57, '''SFSlapstickComicRegular''', 1, 'SlapstickComic', 1.00, 1, 'ShyFonts', 'http://www.fontsquirrel.com/foundry/ShyFonts', NULL, 'Slapstick Comic', 0),
(58, 1, 0, 'tribeca', 58, '''TribecaRegular''', 1, 'Tribeca', 1.50, 1, 'Dieter Steffmann', 'http://www.fontsquirrel.com/foundry/Dieter-Steffmann', 'http://www.steffmann.de', 'Tribeca', 0),
(59, 1, 0, '3dumb', 59, '''3DumbRegular''', 1, '3Dumb', 1.00, 1, 'Tension Type', 'http://www.fontsquirrel.com/foundry/Tension-Type', NULL, '3Dumb', 0),
(60, 0, 0, '2dumb', 60, '''2DumbRegular''', 1, '3Dumb', 1.00, 1, 'Tension Type', 'http://www.fontsquirrel.com/foundry/Tension-Type', NULL, '2Dumb', 0),
(61, 1, 1, 'comiczine', 61, '''ComicZineOTRegular''', 1, 'ComicZine', 1.00, 1, 'Blue Vinyl Fonts', 'http://www.fontsquirrel.com/foundry/Blue-Vinyl-Fonts', 'http://www.bvfonts.com', 'Comic Zine', 0),
(62, 1, 0, 'impactlabel', 62, '''ImpactLabelRegular''', 1, 'ImpactLabel', 1.00, 1, 'Tension Type', 'http://www.fontsquirrel.com/foundry/Tension-Type', NULL, 'Impact Label', 0),
(63, 1, 0, 'impactlabelrev', 63, '''ImpactLabelReversedRegular''', 1, 'ImpactLabel', 1.00, 1, 'Tension Type', 'http://www.fontsquirrel.com/foundry/Tension-Type', NULL, 'Impact Label Reversed', 0),
(64, 0, 0, 'radioland', 64, '''RadiolandRegular''', 1, 'Radioland', 1.00, 1, 'pizzadude.dk', 'http://www.fontsquirrel.com/foundry/pizzadude.dk', 'http://www.pizzadude.dk', 'Radioland', 0),
(65, 1, 0, 'distantgalaxy', 65, '''DistantGalaxyRegular''', 1, 'DistantGalaxy', 1.00, 1, 'ShyFonts', 'http://www.fontsquirrel.com/foundry/ShyFonts', NULL, 'Distant Galaxy', 0),
(66, 1, 0, 'damion', 66, '''Damion''', 1, 'Damion:regular', 1.00, 2, 'Vernon Adams', 'http://www.google.com/webfonts/designer?designer=Vernon+Adams', 'http://www.newtypography.co.uk/', 'Damion', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `font_message`
--

CREATE TABLE IF NOT EXISTS `font_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador fuente_mensaje',
  `idM` int(11) NOT NULL COMMENT 'identificador mensaje',
  `idF` int(11) NOT NULL COMMENT 'identificador de fuente',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `font_message`
--

INSERT INTO `font_message` (`id`, `idM`, `idF`) VALUES
(1, 1, 33),
(2, 2, 48);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `launchers`
--

CREATE TABLE IF NOT EXISTS `launchers` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador',
  `idM` int(11) NOT NULL COMMENT 'identificador del mensaje al que está asociado',
  `launcher` varchar(115) NOT NULL COMMENT 'texto del lanzador',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_options`
--

CREATE TABLE IF NOT EXISTS `menu_options` (
  `idM` int(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  `metaTag` varchar(32) NOT NULL,
  PRIMARY KEY (`idM`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `menu_options`
--

INSERT INTO `menu_options` (`idM`, `description`, `metaTag`) VALUES
(1, 'menu.fonts', 'menu.fonts.mt'),
(2, 'menu.font.color', 'menu.font.color.mt'),
(3, 'menu.background.color', 'menu.background.color.mt'),
(4, 'menu.background.pattern', 'menu.background.pattern.mt'),
(5, 'menu.shadow', 'menu.shadow.mt'),
(50, 'menu.styles', 'menu.styles.mt');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador',
  `urlKey` varchar(7) CHARACTER SET utf8 NOT NULL,
  `message` varchar(3840) CHARACTER SET utf8 NOT NULL COMMENT 'mensaje / gagasaas',
  `date` datetime NOT NULL COMMENT 'fecha',
  `ip` varchar(16) CHARACTER SET utf8 NOT NULL COMMENT 'ip',
  `visibility` tinyint(1) NOT NULL,
  `inblacklist` tinyint(1) NOT NULL,
  `languageUser` varchar(2) CHARACTER SET utf8 NOT NULL,
  `api` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `messages`
--

INSERT INTO `messages` (`id`, `urlKey`, `message`, `date`, `ip`, `visibility`, `inblacklist`, `languageUser`, `api`) VALUES
(1, 'Tvnok7', 'Hello World!', '2014-11-22 00:33:30', '127.0.0.1', 1, 0, 'es', 0),
(2, 'b5rSbn8', 'And another gzaas! Yay!', '2014-11-22 00:34:29', '127.0.0.1', 1, 0, 'es', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `message_visits`
--

CREATE TABLE IF NOT EXISTS `message_visits` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador visita',
  `idM` int(11) NOT NULL COMMENT 'identificador consejo',
  `date` datetime NOT NULL COMMENT 'fecha y hora visita',
  `ip` varchar(16) NOT NULL COMMENT 'ip visita',
  `urlFrom` varchar(255) DEFAULT NULL COMMENT 'url desde la que se recibe la visita',
  `gsFrom` tinyint(1) NOT NULL COMMENT 'boolean: la visita ha sido recibida tras random explore',
  `embedded` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `message_visits`
--

INSERT INTO `message_visits` (`id`, `idM`, `date`, `ip`, `urlFrom`, `gsFrom`, `embedded`) VALUES
(1, 1, '2014-11-22 00:33:50', '127.0.0.1', 'http://gzaas.local.host/preview/preview?gs_form=Hello+World%21&font=&color=&backColor=&pattern=&style=s_cloudy1&shadows=0+0+8px+%23fff%2C+0+0+13px+%23fff%2C+0+0+22px+%2300f&visibility=1&launcher=&from=preview', 0, 0),
(2, 2, '2014-11-22 00:34:31', '127.0.0.1', 'http://gzaas.local.host/preview/preview?gs_form=And+another+gzaas%21+Yay%21&font=&color=&backColor=&pattern=&style=s_grouncha&shadows=&visibility=1&launcher=&from=preview', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patterns`
--

CREATE TABLE IF NOT EXISTS `patterns` (
  `idP` int(11) NOT NULL COMMENT 'identificador del patrón',
  `pattern` varchar(32) NOT NULL COMMENT 'pattern (hashtag)',
  `idHashtag` int(11) NOT NULL COMMENT 'identificador del hashtag',
  `url` varchar(255) NOT NULL COMMENT 'url de la imagen patrón',
  `idServer` int(3) NOT NULL COMMENT 'identificador del servicio que presta los patrones',
  `server` varchar(255) DEFAULT '' COMMENT 'nombre del servicio que presta los patrones',
  `urlBack` varchar(255) DEFAULT NULL COMMENT 'url del link-back',
  `designer` varchar(64) DEFAULT NULL,
  `urlDesigner1` varchar(255) DEFAULT NULL,
  `urlDesigner2` varchar(255) DEFAULT NULL,
  `description` varchar(32) NOT NULL,
  `exclusive` tinyint(1) NOT NULL DEFAULT '0',
  `featured` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `patterns`
--

INSERT INTO `patterns` (`idP`, `pattern`, `idHashtag`, `url`, `idServer`, `server`, `urlBack`, `designer`, `urlDesigner1`, `urlDesigner2`, `description`, `exclusive`, `featured`) VALUES
(1, 'backskulls', 3001, 'skulls.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-449.html" title="Skulls Pattern 01" target="_blank">Skulls Pattern 01</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Skulls', 0, 0),
(2, 'backblackboard', 3002, 'blackboard.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-301.html" title="Math Background 01" target="_blank">Math Background 01</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Blackboard', 0, 0),
(3, 'backclouds', 3003, 'clouds.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-10.html" title="Clouds Background 01" target="_blank">Clouds Background 01</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Clouds', 0, 1),
(4, 'backpolkadot', 3004, 'polkadot.gif', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-215.html" title="Polka Dots 05" target="_blank">Polka Dots 05</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Polka Dot', 0, 0),
(5, 'backplaid', 3005, 'plaid.gif', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-304.html" title="Plaid Background 10" target="_blank">Plaid Background 10</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Plaid', 0, 0),
(6, 'backcitric', 3006, 'citric.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-337.html" title="Abstract Pattern 21" target="_blank">Abstract Pattern 21</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Citric', 0, 0),
(7, 'backpeace', 3007, 'peace.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-338.html" title="Peace Background 02" target="_blank">Peace Background 02</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Peace', 0, 0),
(8, 'backpolkadot2', 3008, 'polkadot2.gif', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-371.html" title="Polka Dots 14" target="_blank">Polka Dots 14</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Polka Dot 2', 0, 1),
(9, 'backbluemosaic', 3009, 'bluemosaic.gif', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-420.html" title="Mosaic Pattern 05" target="_blank">Mosaic Pattern 05</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Blue Mosaic', 0, 0),
(10, 'backbirthday', 3010, 'birthday.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-120.html" title="Birthday Background 01" target="_blank">Birthday Background 01</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Birthday', 0, 0),
(11, 'backcoffee', 3011, 'coffee.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-222.html" title="Coffee Bean Background 01" target="_blank">Coffee Bean Background 01</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Coffee', 0, 0),
(12, 'backgrass', 3012, 'grass.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-428.html" title="Grass Pattern 02" target="_blank">Grass Pattern 02</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Grass', 0, 0),
(13, 'backgrass2', 3013, 'grass2.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-40.html" title="Grass Pattern 01" target="_blank">Grass Pattern 01</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Grass 2', 0, 0),
(14, 'backhalloween', 3014, 'halloween.gif', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-447.html" title="Halloween Background 06" target="_blank">Halloween Background 06</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Halloween', 0, 0),
(15, 'backhalloween2', 3015, 'halloween2.gif', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-446.html" title="Halloween Background 05" target="_blank">Halloween Background 05</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Halloween 2', 0, 0),
(16, 'backhearts', 3016, 'hearts.gif', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-461.html" title="Hearts Pattern 01" target="_blank">Hearts Pattern 01</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Hearts', 0, 1),
(17, 'backhearts2', 3017, 'hearts2.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-179.html" title="Valentine''s Day 01" target="_blank">Valentine''s Day 01</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Hearts 2', 0, 0),
(18, 'backmetal', 3018, 'metal.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-114.html" title="Metal Floor Background 01" target="_blank">Metal Floor Background 01</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Metal', 0, 0),
(19, 'backwall', 3019, 'wall.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-28.html" title="Brick Texture 01" target="_blank">Brick Texture 01</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Wall', 0, 0),
(20, 'backwall2', 3020, 'wall2.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-33.html" title="Brick Texture 02" target="_blank">Brick Texture 02</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Wall 2', 0, 0),
(21, 'backwall3', 3021, 'wall3.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-231.html" title="Brick Texture 03" target="_blank">Brick Texture 03</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Wall 3', 0, 0),
(22, 'backpaper', 3022, 'oldpaper.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com/detail/link-76.html" title="Old Paper Background 01" target="_blank">Old Paper Background 01</a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Old Paper', 0, 0),
(23, 'backpaper2', 3023, 'oldpaper2.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com" title="Background Labs"><img src="http://www.backgroundlabs.com/images/backgroundlabs88x15.gif" border="0" alt="Background Labs"/></a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Old Paper 2', 0, 0),
(24, 'backparty', 3024, 'party.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com" title="Background Labs"><img src="http://www.backgroundlabs.com/images/backgroundlabs88x15.gif" border="0" alt="Background Labs"/></a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Party', 0, 0),
(25, 'backrock', 3025, 'rock.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com" title="Background Labs"><img src="http://www.backgroundlabs.com/images/backgroundlabs88x15.gif" border="0" alt="Background Labs"/></a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Rock (Stone)', 0, 0),
(26, 'backskulls2', 3026, 'skulls2.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com" title="Background Labs"><img src="http://www.backgroundlabs.com/images/backgroundlabs88x15.gif" border="0" alt="Background Labs"/></a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Skulls 2', 0, 0),
(27, 'backstars', 3027, 'stars.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com" title="Background Labs"><img src="http://www.backgroundlabs.com/images/backgroundlabs88x15.gif" border="0" alt="Background Labs"/></a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Stars', 0, 1),
(28, 'backwater', 3028, 'water.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com" title="Background Labs"><img src="http://www.backgroundlabs.com/images/backgroundlabs88x15.gif" border="0" alt="Background Labs"/></a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Water', 0, 0),
(29, 'backwickerwork', 3029, 'wickerwork.gif', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com" title="Background Labs"><img src="http://www.backgroundlabs.com/images/backgroundlabs88x15.gif" border="0" alt="Background Labs"/></a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Wickerwork', 0, 0),
(30, 'backwickerwork2', 3030, 'wickerwork2.gif', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com" title="Background Labs"><img src="http://www.backgroundlabs.com/images/backgroundlabs88x15.gif" border="0" alt="Background Labs"/></a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Wickerwork 2', 0, 0),
(31, 'backwood', 3031, 'wood.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com" title="Background Labs"><img src="http://www.backgroundlabs.com/images/backgroundlabs88x15.gif" border="0" alt="Background Labs"/></a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Wood', 0, 0),
(32, 'backzebra', 3032, 'zebra.jpg', 1, 'BackgroundLabs', '<a href="http://www.backgroundlabs.com" title="Background Labs"><img src="http://www.backgroundlabs.com/images/backgroundlabs88x15.gif" border="0" alt="Background Labs"/></a>', 'BackgroundLabs', 'http://backgroundlabs.com', NULL, 'Zebra', 0, 1),
(1001, 'backicecubes', 4001, 'icecubes.png', 2, 'ColourLovers', 'http://www.colourlovers.com/pattern/210651/ice_cubes', 'Skyblue2u', 'http://www.colourlovers.com/lover/Skyblue2u', NULL, 'Ice Cubes', 0, 1),
(1002, 'backpinkweave', 4002, 'pinkribbonweave.png', 2, 'ColourLovers', 'http://www.colourlovers.com/pattern/96345/pink_ribbon_weave', 'Skyblue2u', 'http://www.colourlovers.com/lover/Skyblue2u', NULL, 'Pink Ribbon Weave', 0, 0),
(1003, 'backcloudsimpressions', 4003, 'cloudsimpressions.png', 2, 'ColourLovers', 'http://www.colourlovers.com/pattern/176757/Clouds_Impressions', 'Skyblue2u', 'http://www.colourlovers.com/lover/Skyblue2u', NULL, 'Clouds Impressions', 0, 0),
(1004, 'backdariusdare', 4004, 'dariusdare.png', 2, 'ColourLovers', 'http://www.colourlovers.com/pattern/3267/Darius_Dare', 'faded jeans', 'http://www.colourlovers.com/lover/faded%20jeans', NULL, 'Darius Dare', 0, 0),
(1005, 'backexploitation', 4005, 'exploitationofideas.png', 2, 'ColourLovers', 'http://www.colourlovers.com/pattern/109242/ExploitationOfIdeas\r\nhttp://www.colourlovers.com/pattern/109242/ExploitationOfIdeas\r\nhttp://www.colourlovers.com/pattern/109242/ExploitationOfIdeas', 'Chi', 'http://www.colourlovers.com/lover/Chi', NULL, 'ExploitationOfIdeas', 0, 0),
(1006, 'backflaunt', 4006, 'flauntmydeuxcent.png', 2, 'ColourLovers', 'http://www.colourlovers.com/pattern/1013881/FlauntMyDeuxCent', 'latigrewatson', 'http://www.colourlovers.com/lover/latigrewatson', 'http://www.flickr.com/people/straycat3/', 'FlauntMyDeuxCent', 0, 0),
(1007, 'backchocolat', 4007, 'lecygneduchocolat.png', 2, 'ColourLovers', 'http://www.colourlovers.com/pattern/88194/le_cygne_du_chocolat', 'eighthmuse', 'http://www.colourlovers.com/lover/eighthmuse', NULL, 'Le cygne du chocolat', 0, 0),
(1008, 'backtartan', 4008, 'meltneapolitantartan.png', 2, 'ColourLovers', 'http://www.colourlovers.com/pattern/1267/MeltNeapolitanTartan', 'retsof', 'http://www.colourlovers.com/lover/retsof', 'http://www.myspace.com/retsoftware', 'Melt Neapolitan Tartan', 0, 0),
(1009, 'backnavaho', 4009, 'navaho.png', 2, 'ColourLovers', 'http://www.colourlovers.com/pattern/465753/Navaho', 'miice', 'http://www.colourlovers.com/lover/miice', 'http://www.myoats.com/users/Miice', 'Navaho', 0, 0),
(1010, 'backpat', 4010, 'pat.png', 2, 'ColourLovers', 'http://www.colourlovers.com/pattern/50713/pat', 'florc', 'http://www.colourlovers.com/lover/florc', NULL, 'Pat', 0, 0),
(1011, 'backcorn', 4011, 'poppingcorn.png', 2, 'ColourLovers', 'http://www.colourlovers.com/pattern/6346/Popping_Corn', 'Steph6', 'http://www.colourlovers.com/lover/Steph6', NULL, 'Popping Corn', 0, 0),
(1012, 'backprisca', 4012, 'prisca.png', 2, 'ColourLovers', 'http://www.colourlovers.com/pattern/89366/Prisca', 'shsh', 'http://www.colourlovers.com/lover/shsh', NULL, 'Prisca', 0, 0),
(1013, 'backsaturday', 4013, 'saturdaywarmth.png', 2, 'ColourLovers', 'http://www.colourlovers.com/pattern/582552/saturday_warmth', 'logochic', 'http://www.colourlovers.com/lover/logochic', 'http://logochic.net/', 'Saturday Warmth', 0, 1),
(1014, 'backseamartini', 4014, 'seamartinifantasy.png', 2, 'ColourLovers', 'http://www.colourlovers.com/pattern/159124/Sea_Martini_Fantasy', 'Skyblue2u', 'http://www.colourlovers.com/lover/Skyblue2u', NULL, 'Sea Martini Fantasy', 0, 0),
(1015, 'backsucksyouin', 4015, 'sucksyouin.png', 2, 'ColourLovers', 'http://www.colourlovers.com/pattern/1074/sucks_you_in', 'technicolorrr', 'http://www.colourlovers.com/lover/technicolorrr', 'http://twitter.com/spinningsea', 'Sucks You In', 0, 0),
(1016, 'backsugarcloud', 4016, 'sugarcloud.png', 2, 'ColourLovers', 'http://www.colourlovers.com/pattern/101050/powdered_sugar_cloud', 'Skyblue2u', 'http://www.colourlovers.com/lover/Skyblue2u', NULL, 'Powdered Sugar Cloud', 0, 0),
(1017, 'backsorrow', 4017, 'wavesofsorrow.png', 2, 'ColourLovers', 'http://www.colourlovers.com/pattern/90096/waves_of_sorrow', 'Skyblue2u', 'http://www.colourlovers.com/lover/Skyblue2u', NULL, 'Waves of sorrow', 0, 0),
(1018, 'backwhenwe', 4018, 'whenweparted.png', 2, 'ColourLovers', 'http://www.colourlovers.com/pattern/1101098/When_We_Parted', 'sunmeadow', 'http://www.colourlovers.com/lover/sunmeadow', NULL, 'When We Parted', 0, 0),
(1019, 'backnotblack', 4019, 'notjustblack.png', 2, 'ColourLovers', 'http://www.colourlovers.com/pattern/425299/Not_just_black', 'annajak', 'http://www.colourlovers.com/lover/annajak', NULL, 'Not Just Black', 0, 0),
(1020, 'backstripeswork', 4020, 'stripescouldwork.png', 2, 'ColourLovers', 'http://www.colourlovers.com/pattern/67522/stripes_could_work\r\n', 'luffly', 'http://www.colourlovers.com/lover/luffly', NULL, 'Stripes Could Work', 0, 0),
(1021, 'backrisingtemps', 4021, 'risingtemps.png', 2, 'ColourLovers', 'http://www.colourlovers.com/pattern/971659/rising_temps', 'twister', '\r\nhttp://www.colourlovers.com/lover/twister', NULL, 'Rising Temps', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pattern_message`
--

CREATE TABLE IF NOT EXISTS `pattern_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador pattern_mensaje',
  `idM` int(11) NOT NULL COMMENT 'identificador mensaje',
  `idP` int(11) NOT NULL COMMENT 'identificador de pattern',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `pattern_message`
--

INSERT INTO `pattern_message` (`id`, `idM`, `idP`) VALUES
(1, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shadow_message`
--

CREATE TABLE IF NOT EXISTS `shadow_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador shadow_message',
  `idM` int(11) NOT NULL COMMENT 'identificador mensaje',
  `shadow` varchar(30) NOT NULL COMMENT 'valor de shadow',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `shadow_message`
--

INSERT INTO `shadow_message` (`id`, `idM`, `shadow`) VALUES
(1, 2, '-5px 0 0 #000000'),
(2, 2, ' 5px 0 0 #000000'),
(3, 2, ' 0 -5px 0 #000000'),
(4, 2, ' 0 5px 0 #000000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `styles`
--

CREATE TABLE IF NOT EXISTS `styles` (
  `idS` int(11) NOT NULL COMMENT 'identificador del estilo',
  `style` varchar(32) NOT NULL COMMENT 'hashtag asociado',
  `description` varchar(255) NOT NULL COMMENT 'nombre del estilo',
  `font` varchar(32) NOT NULL COMMENT 'fuente utilizada (#hashtag)',
  `color` varchar(7) NOT NULL COMMENT 'color de fuente (ffc933 || fff)',
  `backColor` varchar(7) DEFAULT NULL COMMENT 'color de fondo (ffc933 || fff)',
  `shadow` varchar(256) DEFAULT NULL COMMENT 'text-shadow (2px 2px 5px #fff)',
  `pattern` varchar(32) DEFAULT NULL COMMENT 'textura de fondo (#hashtag)',
  `designer` varchar(128) DEFAULT NULL COMMENT 'creador del estilo',
  `urlBackDesigner` varchar(255) DEFAULT NULL COMMENT 'urlBack Diseñador del estilo',
  `publicUse` tinyint(1) NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '1',
  `idHashtag` int(11) NOT NULL COMMENT 'identificador del hashtag asociado',
  PRIMARY KEY (`idS`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `styles`
--

INSERT INTO `styles` (`idS`, `style`, `description`, `font`, `color`, `backColor`, `shadow`, `pattern`, `designer`, `urlBackDesigner`, `publicUse`, `featured`, `idHashtag`) VALUES
(1, 's_chunky1', 'Chunky Yellow', 'chunkfive', '000000', 'ffe303', NULL, NULL, 'ojoven', 'http://twitter.com/ojoven', 1, 1, 20001),
(2, 's_cloudy1', 'Cloudy Clear', 'bentham', '444444', NULL, '2px 2px 2px #fff', 'backclouds', 'ojoven', 'http://twitter.com/ojoven', 1, 1, 20002),
(3, 's_bloody1', 'Bloody & Scary', 'bloody', 'c10202', NULL, NULL, 'backskulls', 'ojoven', 'http://twitter.com/ojoven', 1, 0, 20003),
(4, 's_chewy1', 'Chewy love', 'chewy', 'ffffff', 'FE28A2', NULL, NULL, 'ojoven', 'http://twitter.com/ojoven', 1, 1, 20004),
(5, 's_comic1', 'Simple Comic', 'comiczine', '444', 'fcfcfc', NULL, NULL, 'ojoven', 'http://twitter.com/ojoven', 1, 1, 20005),
(6, 's_diary1', 'My Diary', 'journal', '000', NULL, '2px 2px 2px #fff', 'backpaper', 'ojoven', 'http://twitter.com/ojoven', 1, 0, 20006),
(7, 's_impactred', 'You failed!', 'impactlabel', '000', 'ff0000', NULL, NULL, 'ojoven', 'http://twitter.com/ojoven', 1, 1, 20007),
(8, 's_wooden1', 'Wooden Signature', 'reeniebeanie', '000', NULL, NULL, 'backwood', 'ojoven', 'http://twitter.com/ojoven', 1, 0, 0),
(9, 's_ilikewall', 'I like my wall', 'cabin', 'fff', '00287b', NULL, NULL, 'ojoven', 'http://twitter.com/ojoven', 1, 0, 20009),
(10, 's_neon1', 'City wild', 'fenwickoutline', 'fff', '000', '0 0 8px #fff, 0 0 13px #fff, 0 0 22px #00f', NULL, 'ojoven', 'http://twitter.com/ojoven', 1, 1, 20010),
(11, 's_basque', 'Kaixo laguna', 'allan', 'f00', '00cb00', '6px 0 0 #FFFFFF, 0 6px 0 #FFFFFF, -6px 0 0 #FFFFFF, 0 -6px 0 #FFFFFF', NULL, 'ojoven', 'http://twitter.com/ojoven', 1, 1, 20011),
(12, 's_smart', 'I''m smart', 'museoslab', '#999', NULL, NULL, 'backwickerwork', 'ojoven', 'http://twitter.com/ojoven', 1, 0, 0),
(13, 's_goal', 'Goal!', 'slapstickcomic', 'fff', NULL, NULL, 'backgrass2', 'ojoven', 'http://twitter.com/ojoven', 1, 0, 0),
(14, 's_blackcomic', 'Tadakada!', 'slapstickcomic', 'ffe303', '000', NULL, NULL, 'ojoven', 'http://twitter.com/ojoven', 1, 0, 0),
(15, 's_caution', 'Caution!', 'impactlabelrev', '000', 'ff0', NULL, NULL, 'ojoven', 'http://twitter.com/ojoven', 1, 0, 0),
(16, 's_grouncha', 'Grouncha', 'luckiestguy', 'ff0', '390031', '-5px 0 0 #000000, 5px 0 0 #000000, 0 -5px 0 #000000, 0 5px 0 #000000', NULL, 'ojoven', 'http://twitter.com/ojoven', 1, 1, 0),
(17, 's_followt', 'Follow me', 'chewy', 'fff', '0ff', NULL, NULL, 'ojoven', 'http://twitter.com/ojoven', 1, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `style_message`
--

CREATE TABLE IF NOT EXISTS `style_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador style_mensaje',
  `idM` int(11) NOT NULL COMMENT 'identificador mensaje',
  `idS` int(11) NOT NULL COMMENT 'identificador de style',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
