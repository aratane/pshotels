RENAME TABLE `ps_hotels`.`psh_touches` TO `ps_hotels`.`psh_room_touches`;

CREATE TABLE `psh_hotel_touches` (
  `hotel_touch_id` varchar(255) NOT NULL,
  `hotel_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `psh_hotel_touches`
  ADD PRIMARY KEY (`hotel_touch_id`);

ALTER TABLE `psh_room_touches` CHANGE `touch_id` `room_touch_id` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;