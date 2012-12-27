CREATE TABLE IF NOT EXISTS `#__jxiforms_input` (
 `input_id` 		INT(11)		NOT NULL AUTO_INCREMENT,
 `title` 		VARCHAR(255) 	NOT NULL ,
 `description` 		TEXT		DEFAULT NULL, 
 `post_url`     	VARCHAR(255)	NOT NULL,
 `redirect_url` 	VARCHAR(255)	DEFAULT NULL,
 `published` 		TINYINT(1) 	DEFAULT 1,
 `params`		TEXT 		DEFAULT NULL,  
  PRIMARY KEY (`input_id`)
)
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8 ;


CREATE  TABLE IF NOT EXISTS `#__jxiforms_config` (
  `config_id`		INT(11)		NOT NULL AUTO_INCREMENT,
  `key`    		VARCHAR(255) 	NOT NULL,
  `value`  		TEXT		DEFAULT NULL,
   PRIMARY KEY (`config_id`),
   UNIQUE INDEX `idx_key` (`key` ASC) 
 ) 
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8 ;


CREATE  TABLE IF NOT EXISTS `#__jxiforms_action` (
  `action_id`		INT(11)		NOT NULL AUTO_INCREMENT,
  `title`    		VARCHAR(255) 	NOT NULL,
  `type`  		VARCHAR(50) 	NOT NULL,
  `description`		TEXT 		DEFAULT NULL,
  `core_params`		TEXT		DEFAULT NULL,
  `action_params` 	TEXT 		DEFAULT NULL,
  `for_all_inputs`		TINYINT(1)	DEFAULT 0,
  `published` 		TINYINT(1) 	DEFAULT 1,
  `ordering`   		INT(11) 	NOT NULL DEFAULT 0,
  `data`			TEXT		DEFAULT NULL,
   PRIMARY KEY (`action_id`),
   INDEX `idx_type` (`type` ASC),
   INDEX `idx_for_all_inputs` (`for_all_inputs`)
 ) 
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8 ;


CREATE  TABLE IF NOT EXISTS `#__jxiforms_inputaction` (
  `inputaction_id`	INT(11) 	NOT NULL AUTO_INCREMENT,
  `input_id`     	INT(11)		NOT NULL ,
  `action_id`     	INT(11)		NOT NULL ,
   PRIMARY KEY (`inputaction_id`),
   INDEX `idx_input_id` (`input_id` ASC),
   INDEX `idx_action_id` (`action_id` ASC)
 ) 
ENGINE = MyISAM 
DEFAULT CHARACTER SET = utf8;


CREATE TABLE IF NOT EXISTS `#__jxiforms_log` (
  `log_id`		INT(11)		NOT NULL AUTO_INCREMENT,
  `level`		INT(11) 	NOT NULL,
  `user_id` 		INT(11)		NOT NULL,
  `class`		VARCHAR(100) 	NOT NULL,
  `object_id`		INT(11) 	NOT NULL,
  `message`		TEXT		DEFAULT NULL,
  `user_ip` 		VARCHAR(50)	NOT NULL,
  `created_date`	DATETIME	NOT NULL,
  `token`		VARCHAR(255)    DEFAULT NULL,
  `status`		INT(11) 	DEFAULT '0',
  PRIMARY KEY (`log_id`),
  INDEX `idx_level` (`level` ASC),
  INDEX `idx_class` (`class` ASC)
) 
ENGINE = MyISAM 
DEFAULT CHARACTER SET = utf8;
