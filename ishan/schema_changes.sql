create database glucial;

create table user (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
external_id VARCHAR(255),
login_provider VARCHAR(20),
login_provider_uid VARCHAR(20),
fname VARCHAR(50) NOT NULL,
lname VARCHAR(50) NOT NULL,
email VARCHAR(50) NOT NULL,
age INT,
gender VARCHAR(10),
birth_date VARCHAR(10),
country	VARCHAR(20),
state	VARCHAR(20),
city	VARCHAR(20),
zip	VARCHAR(20),
profile_url	VARCHAR(30),
interests	VARCHAR(100),
activities	VARCHAR(50),
external_rank   INT, 
internal_rank	INT,
matches VARCHAR(200),
photo_url VARCHAR(500),
thumbnail_url VARCHAR(500),
created TIMESTAMP
);

create table interest (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
parent_id INT,
label VARCHAR(50),
user_list_csv VARCHAR(50),
popularity FLOAT
);

create table topic (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
label VARCHAR(50),
user_list_csv VARCHAR(50),
rating FLOAT,
created TIMESTAMP,
creator_id INT,
last_updating_user_id INT
);

create table chat (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
topic VARCHAR(50),
topic_id INT,
user_id1 INT,
user_id2 INT,
comments TEXT,
start_time TIMESTAMP,
end_time TIMESTAMP,
is_accepted BOOLEAN 
);


