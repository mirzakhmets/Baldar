CREATE TABLE `connection` (
  `id` int(11) NOT NULL,
  `usera` int(32) NOT NULL,
  `userb` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `message` (
  `id` int(32) NOT NULL,
  `user` int(32) NOT NULL,
  `text` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `user` (
  `id` int(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `comment` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `connection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `connection_usera_index` (`usera`) USING HASH,
  ADD KEY `connection_userb_index` (`userb`) USING HASH;

ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_user_index` (`user`) USING HASH;

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name_unique_index` (`name`),
  ADD UNIQUE KEY `user_hash_unique_index` (`hash`);

ALTER TABLE `connection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `message`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

ALTER TABLE `connection`
  ADD CONSTRAINT `fk_connection_usera` FOREIGN KEY (`usera`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk_connection_userb` FOREIGN KEY (`userb`) REFERENCES `user` (`id`);

ALTER TABLE `message`
  ADD CONSTRAINT `fk_message_user` FOREIGN KEY (`user`) REFERENCES `user` (`id`);
COMMIT;
