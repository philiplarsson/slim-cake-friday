DROP TABLE IF exists cookies;

CREATE TABLE cookies(
       id       INTEGER PRIMARY KEY,
       date     TEXT NOT NULL,
       name     TEXT NOT NULL,
       image    TEXT NOT NULL
);
