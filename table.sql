CREATE TABLE phprs.account (
	id INT auto_increment NOT NULL,
	firstName varchar(100) NOT NULL,
	lastName varchar(100) NOT NULL,
	email varchar(100) NOT NULL,
	age INT NULL,
	password varchar(100) NULL,
	PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci;

ALTER TABLE phprs.account ADD created_at DATETIME NULL;
ALTER TABLE phprs.account ADD updated_at DATETIME NULL;

