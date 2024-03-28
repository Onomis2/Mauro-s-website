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
    image_name VARCHAR(255) NOT NULL
);

CREATE TABLE tags (
    tag_id INT AUTO_INCREMENT PRIMARY KEY,
    tag_name VARCHAR(255) NOT NULL
);

CREATE TABLE image_tags (
    image_id INT,
    tag_id INT,
    FOREIGN KEY (image_id) REFERENCES images(image_id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(tag_id) ON DELETE CASCADE
);

INSERT INTO
    users (username, password)
VALUES
    (
        'admin',
        '$2y$10$dU8n53kNNv4tzUUloptXSeH.2V914dhfB9Xaq.qgZnWLEOw9Vnq0y'
    );