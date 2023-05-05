CREATE TABLE IF NOT EXISTS `test1` (
  `id` int(11) NOT NULL,
  `name` varchar(512) NOT NULL,
  `surname` varchar(512) NOT NULL,
  `id_number` varchar(512) NOT NULL,
  `date_birth` varchar(256) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `test1` ADD PRIMARY KEY (`id`);
ALTER TABLE `test1` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;