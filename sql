CREATE TABLE leads
(
    id INT PRIMARY KEY,
    region_name VARCHAR(255) NOT NULL,
    group_name VARCHAR(255) NOT NULL,
    type_name VARCHAR(255) NOT NULL,
    message VARCHAR(255),
    status VARCHAR(30) NOT NULL,
    user_id INT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id)  REFERENCES users (id)
);

CREATE TABLE users
(
    id INT PRIMARY KEY,
    login    varchar(255) not null,
    password varchar(255) not null,
    email    varchar(255) not null,
    name     varchar(255) not null,
    role     varchar(30) default 'user'
);