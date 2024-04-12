DROP DATABASE IF EXISTS maurowebsite;

CREATE DATABASE maurowebsite;

USE maurowebsite;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(256) NOT NULL,
    admin ENUM('NO', 'YES') NOT NULL
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
    tag_name VARCHAR(255) NOT NULL,
    tag_color VARCHAR(7) NOT NULL
);

INSERT INTO
    users (username, password)
VALUES
    (
        'admin',
        '$2y$10$dU8n53kNNv4tzUUloptXSeH.2V914dhfB9Xaq.qgZnWLEOw9Vnq0y'
    );
INSERT INTO
    tags (tag_name, tag_color)
VALUES
    ('Gothic', '#f2a933'),
    ('Glass', '#b37289'),
    ('Skyscraper', '#982310'),
    ('Victorian', '#b128911');

