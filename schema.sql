CREATE DATABASE yeticave
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE categories (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    name            CHAR(128) NOT NULL,
    symbol_code     CHAR(128) NOT NULL
);

CREATE TABLE lots (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    category_id     INT NOT NULL,
    user_id         INT NOT NULL,
    dt_add          TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    dt_remove       DATETIME NOT NULL,
    title           TEXT NOT NULL,
    description     TEXT,
    img_path        CHAR(128),
    sum_start       DECIMAL NOT NULL,
    bet_step        DECIMAL NOT NULL,
    user_id_winner  INT
);

CREATE INDEX dt_remove_lot ON lots(dt_remove);

CREATE TABLE bets (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    lot_id          INT NOT NULL,
    user_id         INT NOT NULL,
    dt_add          TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    sum             DECIMAL NOT NULL
);

CREATE INDEX dt_add_bet ON bets(dt_add);

CREATE TABLE users (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    dt_add          TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    name            CHAR(128) NOT NULL,
    email           CHAR(128) NOT NULL,
    password        CHAR(64) NOT NULL,
    avatar          CHAR(128),
    contact         TEXT
);

CREATE UNIQUE INDEX email_user ON users(email);
