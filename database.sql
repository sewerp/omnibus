SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE `currencies`
(
    `id`     int(10) unsigned NOT NULL AUTO_INCREMENT,
    `symbol` char(10) NOT NULL,
    `factor` float unsigned NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `currencies` (`id`, `symbol`, `factor`)
VALUES (1, 'PLN', 1),
       (2, 'EURO', 3.9),
       (3, 'GBP', 5.4),
       (4, 'USD', 4.3);

CREATE TABLE `discountGroups`
(
    `id`              int(10) unsigned NOT NULL AUTO_INCREMENT,
    `title`           varchar(255) NOT NULL,
    `discountPercent` int(10) unsigned NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `discountGroups` (`id`, `title`, `discountPercent`)
VALUES (1, 'bigClient', 30),
       (2, 'smallCLient', 10),
       (3, 'regularUser', 0);

CREATE TABLE `items`
(
    `id`        int(11) unsigned NOT NULL AUTO_INCREMENT,
    `price`     float unsigned NOT NULL,
    `title`     varchar(255) NOT NULL,
    `createdAt` datetime     NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `items` (`id`, `price`, `title`, `createdAt`)
VALUES (1, 4, 'Klepki', '2016-04-19 21:38:08'),
       (2, 100, 'Filtr', '2016-04-19 21:38:08');

CREATE TABLE `priceChanges`
(
    `id`              int(10) unsigned NOT NULL AUTO_INCREMENT,
    `itemId`          int(11) unsigned NOT NULL,
    `price`           float unsigned NOT NULL,
    `currencyId`      int(10) unsigned NOT NULL,
    `discountGroupId` int(10) unsigned NOT NULL,
    `createdAt`       date NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `itemId_currencyId_discountGroupId_createdAt` (`itemId`,`currencyId`,`discountGroupId`,`createdAt`),
    KEY               `currencyId` (`currencyId`),
    KEY               `discountGroupId` (`discountGroupId`),
    CONSTRAINT `priceChanges_ibfk_1` FOREIGN KEY (`currencyId`) REFERENCES `currencies` (`id`),
    CONSTRAINT `priceChanges_ibfk_2` FOREIGN KEY (`discountGroupId`) REFERENCES `discountGroups` (`id`),
    CONSTRAINT `priceChanges_ibfk_3` FOREIGN KEY (`itemId`) REFERENCES `items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `priceChanges` (`id`, `itemId`, `price`, `currencyId`, `discountGroupId`, `createdAt`)
VALUES (182, 1, 7, 1, 1, '2023-01-24'),
       (183, 1, 9, 1, 2, '2023-01-24'),
       (184, 1, 10, 1, 3, '2023-01-24'),
       (185, 1, 1.51, 2, 1, '2023-01-24'),
       (186, 1, 1.95, 2, 2, '2023-01-24'),
       (187, 1, 2.17, 2, 3, '2023-01-24'),
       (188, 1, 1.29, 3, 1, '2023-01-24'),
       (189, 1, 1.66, 3, 2, '2023-01-24'),
       (190, 1, 1.85, 3, 3, '2023-01-24'),
       (191, 1, 1.62, 4, 1, '2023-01-24'),
       (192, 1, 2.08, 4, 2, '2023-01-24'),
       (193, 1, 2.32, 4, 3, '2023-01-24'),
       (194, 2, 70, 1, 1, '2023-01-24'),
       (195, 2, 90, 1, 2, '2023-01-24'),
       (196, 2, 100, 1, 3, '2023-01-24'),
       (197, 2, 15.21, 2, 1, '2023-01-24'),
       (198, 2, 19.55, 2, 2, '2023-01-24'),
       (199, 2, 21.73, 2, 3, '2023-01-24'),
       (200, 2, 12.95, 3, 1, '2023-01-24'),
       (201, 2, 16.65, 3, 2, '2023-01-24'),
       (202, 2, 18.51, 3, 3, '2023-01-24'),
       (203, 2, 16.27, 4, 1, '2023-01-24'),
       (204, 2, 20.92, 4, 2, '2023-01-24'),
       (205, 2, 23.25, 4, 3, '2023-01-24'),
       (206, 1, 2.8, 1, 1, '2023-01-25'),
       (207, 1, 3.6, 1, 2, '2023-01-25'),
       (208, 1, 4, 1, 3, '2023-01-25'),
       (209, 1, 0.68, 2, 1, '2023-01-25'),
       (210, 1, 0.87, 2, 2, '2023-01-25'),
       (211, 1, 0.97, 2, 3, '2023-01-25'),
       (212, 1, 0.51, 3, 1, '2023-01-25'),
       (213, 1, 0.66, 3, 2, '2023-01-25'),
       (214, 1, 0.74, 3, 3, '2023-01-25'),
       (215, 1, 0.65, 4, 1, '2023-01-25'),
       (216, 1, 0.83, 4, 2, '2023-01-25'),
       (217, 1, 0.93, 4, 3, '2023-01-25'),
       (218, 2, 70, 1, 1, '2023-01-25'),
       (219, 2, 90, 1, 2, '2023-01-25'),
       (220, 2, 100, 1, 3, '2023-01-25'),
       (221, 2, 11.85, 2, 1, '2023-01-25'),
       (222, 2, 15.24, 2, 2, '2023-01-25'),
       (223, 2, 16.94, 2, 3, '2023-01-25'),
       (224, 2, 12.95, 3, 1, '2023-01-25'),
       (225, 2, 16.65, 3, 2, '2023-01-25'),
       (226, 2, 18.51, 3, 3, '2023-01-25'),
       (227, 2, 16.27, 4, 1, '2023-01-25'),
       (228, 2, 20.92, 4, 2, '2023-01-25'),
       (229, 2, 23.25, 4, 3, '2023-01-25');

