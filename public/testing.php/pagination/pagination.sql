--
-- Table structure for table `records`
--

CREATE TABLE IF NOT EXISTS `records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27;

--
-- Dumping data for table `records`
--

INSERT INTO `records` (`id`, `name`, `active`) VALUES
(1, 'Emily', 1),
(2, 'Kayla', 1),
(3, 'Alyssa', 1),
(4, 'Chloe', 1),
(5, 'Hannah', 1),
(6, 'Ashley', 1),
(7, 'POPPY', 1),
(8, 'BETHANY', 1),
(9, 'JASMINE', 1),
(10, 'ELIZABETH ', 1),
(11, 'ALEC', 1),
(12, 'ALFRED', 1),
(13, 'ALLYN', 1),
(14, 'ALTON', 1),
(15, 'ALYCE', 1),
(16, 'ALYX', 1),
(17, 'AMERY', 1),
(18, 'AMIE', 1),
(19, 'AMITY', 1),
(20, 'ANDI', 1),
(21, 'ANDIE', 1),
(22, 'ANGEL', 1),
(23, 'ARIC ', 1),
(24, 'ARN', 1),
(25, 'ARYANA ', 1),
(26, 'AILA', 1);
