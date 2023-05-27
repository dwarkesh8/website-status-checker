CREATE DATABASE website_status;

USE website_status;

CREATE TABLE urls (
  id INT AUTO_INCREMENT PRIMARY KEY,
  url VARCHAR(255) NOT NULL,
  status INT
);
