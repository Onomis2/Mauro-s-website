DROP DATABASE IF EXISTS maurowebsite;

CREATE DATABASE maurowebsite;

USE maurowebsite;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(256) NOT NULL
);

CREATE TABLE images (
    image_id INT AUTO_INCREMENT PRIMARY KEY,
image LONGBLOB,
source VARCHAR(255),
tag1 INT(16),
tag2 INT(16),
tag3 INT(16),
tag4 INT(16),
tag5 INT(16),
tag6 INT(16),
tag7 INT(16),
tag8 INT(16),
tag9 INT(16),
tag10 INT(16),
tag11 INT(16),
tag12 INT(16),
tag13 INT(16),
tag14 INT(16),
tag15 INT(16),
tag16 INT(16),
tag17 INT(16),
tag18 INT(16),
tag19 INT(16),
tag20 INT(16)
);

CREATE TABLE tags (
    tag_id INT AUTO_INCREMENT PRIMARY KEY,
    tag_name VARCHAR(255) NOT NULL
);

INSERT INTO
    users (username, password)
VALUES
    (
        'admin',
        '$2y$10$dU8n53kNNv4tzUUloptXSeH.2V914dhfB9Xaq.qgZnWLEOw9Vnq0y'
    );
INSERT INTO
    tags (tag_name)
VALUES
    ('Gothic'),
    ('Glass'),
    ('Skyscraper'),
    ('Victorian');
INSERT INTO images (source, tag1, tag2, tag3, tag4, tag5, tag6, tag7, tag8, tag9, tag10, tag11, tag12, tag13, tag14, tag15, tag16, tag17, tag18, tag19, tag20) 
VALUES 
    ('Hoorn', '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
    ('Enkhuizen', '3', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
    ('Bovenkarspel', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
    ('Grootebroek', '1', '2', '3', '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);


