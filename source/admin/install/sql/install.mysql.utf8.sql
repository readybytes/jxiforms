CREATE TABLE IF NOT EXISTS `#__uglyforms_input` (
 `input_id` 		INT(11)		NOT NULL AUTO_INCREMENT,
 `title` 		VARCHAR(255) 	NOT NULL ,
 `description` 		TEXT		DEFAULT NULL, 
 `redirect_url` 	VARCHAR(255)	DEFAULT NULL,
 `published` 		TINYINT(1) 	DEFAULT 1,
 `params`		TEXT 		DEFAULT NULL,  
  PRIMARY KEY (`input_id`)
)
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8 ;


CREATE  TABLE IF NOT EXISTS `#__uglyforms_config` (
  `config_id`		INT(11)		NOT NULL AUTO_INCREMENT,
  `key`    		VARCHAR(255) 	NOT NULL,
  `value`  		TEXT		DEFAULT NULL,
   PRIMARY KEY (`config_id`),
   UNIQUE INDEX `idx_key` (`key` ASC) 
 ) 
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8 ;


CREATE  TABLE IF NOT EXISTS `#__uglyforms_action` (
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


CREATE  TABLE IF NOT EXISTS `#__uglyforms_inputaction` (
  `inputaction_id`	INT(11) 	NOT NULL AUTO_INCREMENT,
  `input_id`     	INT(11)		NOT NULL ,
  `action_id`     	INT(11)		NOT NULL ,
   PRIMARY KEY (`inputaction_id`),
   INDEX `idx_input_id` (`input_id` ASC),
   INDEX `idx_action_id` (`action_id` ASC)
 ) 
ENGINE = MyISAM 
DEFAULT CHARACTER SET = utf8;


CREATE TABLE IF NOT EXISTS `#__uglyforms_log` (
  `log_id`		INT(11)		NOT NULL AUTO_INCREMENT,
  `message`		TEXT		NOT NULL,
  `reference_id`	INT(11) 	DEFAULT NULL,
  `reference_type`	VARCHAR(100)	DEFAULT NULL,
  `data_id`		INT(11)		DEFAULT NULL,
  `created_date`	DATETIME	NOT NULL,
  PRIMARY KEY (`log_id`),
  INDEX `idx_data_id` (`data_id` ASC),
  INDEX `idx_reference_id` (`reference_id` ASC),
  INDEX `idx_reference_type` (`reference_type` ASC)
) 
ENGINE = MyISAM 
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `#__uglyforms_queue` (
  `queue_id`		INT(11)			NOT NULL AUTO_INCREMENT,
  `input_id`		INT(11) 		NOT NULL,
  `action_id` 		INT(11)			NOT NULL,
  `approved`		TINYINT(1) 		DEFAULT 1,
  `approval_key`	VARCHAR(255)	DEFAULT NULL,
  `status`			INT(4) 			DEFAULT 0,
  `data_id`		INT(11) 		NOT NULL,
  `created_date`	DATETIME		NOT NULL,
  `params` 			TEXT			DEFAULT NULL,
  PRIMARY KEY (`queue_id`),
  INDEX `idx_input_id` (`input_id` ASC),
  INDEX `idx_action_id` (`action_id` ASC),
  INDEX `idx_approved` (`approved` ASC),
  INDEX `idx_status` (`status` ASC)
) 
ENGINE = MyISAM 
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `#__uglyforms_inputhtml` (
  `inputhtml_id`		INT(11)			NOT NULL AUTO_INCREMENT,
  `html`		TEXT	 		DEFAULT NULL,
  `json` 		TEXT			DEFAULT NULL,
  `input_id`		INT(11)			NOT NULL,
  `created_date`	DATETIME		NOT NULL,
  PRIMARY KEY (`inputhtml_id`),
  INDEX `idx_input_id` (`input_id` ASC)
) 
ENGINE = MyISAM 
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `#__uglyforms_data` (
  `data_id`		INT(11)			NOT NULL AUTO_INCREMENT,
  `data`		TEXT	 		DEFAULT NULL,
  `attachment` 		TEXT			DEFAULT NULL,
  `input_id`		INT(11)			NOT NULL,
  `user_ip`		VARCHAR(50) 		NOT NULL,
  `created_date`	DATETIME		NOT NULL,
  PRIMARY KEY (`data_id`),
  INDEX `idx_input_id` (`input_id` ASC)
) 
ENGINE = MyISAM 
DEFAULT CHARACTER SET = utf8;


