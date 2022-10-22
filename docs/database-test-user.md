# Database Test User

```sql
CREATE DATABASE dreambd2;

USE dreambd2;

CREATE TABLE user (
    id bigint PRIMARY KEY AUTO_INCREMENT,
    nombre varchar(55) NOT NULL,
    apellido varchar(255) NOT NULL,
    username varchar(255) NOT NULL,
    password varchar(255) NOT NULL
);
```