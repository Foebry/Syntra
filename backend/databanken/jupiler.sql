CREATE SCHEMA jupiler;

USE jupiler;

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `wedstrijd`
-- ----------------------------
DROP TABLE IF EXISTS `wedstrijd`;
CREATE TABLE `wedstrijd` (
  `wed_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `wed_datum` date DEFAULT NULL,
  `wed_uur` time DEFAULT NULL,
  `wed_dag_id` mediumint(9) DEFAULT NULL,
  `wed_tea_home` mediumint(9) DEFAULT NULL,
  `wed_tea_visit` mediumint(9) DEFAULT NULL,
  `wed_goals_home` mediumint(9) DEFAULT NULL,
  `wed_goals_visit` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`wed_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wedstrijd
-- ----------------------------
INSERT INTO `wedstrijd` VALUES ('1', '2017-01-14', '15:00:00', '6', '3', '1', '2', '0');
INSERT INTO `wedstrijd` VALUES ('2', '2017-01-14', '15:00:00', '6', '2', '4', '3', '1');
INSERT INTO `wedstrijd` VALUES ('3', '2017-01-15', '18:00:00', '6', '5', '6', '1', '1');

-- ----------------------------
-- Table structure for `seizoen`
-- ----------------------------
DROP TABLE IF EXISTS `seizoen`;
CREATE TABLE `seizoen` (
  `sei_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `sei_jaar_van` mediumint(9) DEFAULT NULL,
  `sei_jaar_tot` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`sei_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of seizoen
-- ----------------------------
INSERT INTO `seizoen` VALUES ('1', '2016', '2017');
INSERT INTO `seizoen` VALUES ('2', '2017', '2018');
INSERT INTO `seizoen` VALUES ('3', '2018', '2019');

-- ----------------------------
-- Table structure for `speeldag`
-- ----------------------------
DROP TABLE IF EXISTS `speeldag`;
CREATE TABLE `speeldag` (
  `dag_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `dag_seizoen` mediumint(9) DEFAULT NULL,
  `dag_nr` mediumint(9) NOT NULL,
  PRIMARY KEY (`dag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of speeldag
-- ----------------------------
INSERT INTO `speeldag` VALUES ('1', '1', '1');
INSERT INTO `speeldag` VALUES ('2', '1', '2');
INSERT INTO `speeldag` VALUES ('3', '1', '3');
INSERT INTO `speeldag` VALUES ('4', '1', '4');
INSERT INTO `speeldag` VALUES ('5', '1', '5');
INSERT INTO `speeldag` VALUES ('6', '1', '6');
INSERT INTO `speeldag` VALUES ('7', '1', '7');
INSERT INTO `speeldag` VALUES ('8', '1', '8');
INSERT INTO `speeldag` VALUES ('9', '1', '9');
INSERT INTO `speeldag` VALUES ('10', '1', '10');
INSERT INTO `speeldag` VALUES ('11', '1', '11');
INSERT INTO `speeldag` VALUES ('12', '1', '12');

-- ----------------------------
-- Table structure for `team`
-- ----------------------------
DROP TABLE IF EXISTS `team`;
CREATE TABLE `team` (
  `tea_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `tea_naam` varchar(255) NOT NULL,
  `tea_stadion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tea_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of team
-- ----------------------------
INSERT INTO `team` VALUES ('1', 'Club Brugge', 'Jan Breydel');
INSERT INTO `team` VALUES ('2', 'Anderlecht', 'Constant Vanden Stockstadion');
INSERT INTO `team` VALUES ('3', 'Standard', 'Sclessin');
INSERT INTO `team` VALUES ('4', 'Lokeren', 'Daknam');
INSERT INTO `team` VALUES ('5', 'Zulte-Waregem', 'Essevee');
INSERT INTO `team` VALUES ('6', 'Charleroi', null);
