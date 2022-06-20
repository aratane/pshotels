ALTER TABLE `psh_about` CHANGE `currency_symbol` `currency_symbol` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '$';

ALTER TABLE `psh_about` CHANGE `currency_short_form` `currency_short_form` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'USD';

ALTER TABLE `psh_favourites` CHANGE `room_id` `hotel_id` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `psh_hotels`  ADD `is_recommended` BOOLEAN NOT NULL DEFAULT FALSE  AFTER `hotel_check_out`;