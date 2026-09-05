DROP DATABASE IF EXISTS guestcounter;
CREATE DATABASE guestcounter;
USE guestcounter;

DROP TABLE IF EXISTS events; 
CREATE TABLE events (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  event varchar(100),
  venue varchar(100),
  date_fr varchar(100),  
  date_to varchar(100),  
  service varchar(100)
);

DROP TABLE IF EXISTS codes; 
CREATE TABLE codes (
  cid int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  eid int NOT NULL,
  event varchar(100),
  ctype varchar(100),
  status varchar(100), 
  quantity varchar(100)
);

DROP TABLE IF EXISTS servers;
CREATE TABLE servers (
  sid int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  server varchar(100)
);

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  fullname varchar(100),
  username varchar(100),
  password varchar(100),
  usertype varchar(100)
);

DROP TABLE IF EXISTS validity;
CREATE TABLE validity (
  validity date
);
