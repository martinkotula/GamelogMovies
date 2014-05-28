ALTER TABLE `gamelogmovies`.`movies` ADD UNIQUE `UX_MOVIE_TITLE` (`MovieTitle`, `ReviewCategoryId`)COMMENT '';

ALTER TABLE `reviews` ADD `Source` VARCHAR(255) NOT NULL ;