ALTER TABLE `psh_inquires` CHANGE `user_id` `user_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `psh_inquires`  ADD `user_email` VARCHAR(255) NOT NULL  AFTER `user_name`;

ALTER TABLE `psh_inquires` CHANGE `user_name` `inq_user_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `user_email` `inq_user_email` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;