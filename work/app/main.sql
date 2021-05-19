CREATE TABLE worklists(
id INT NOT NULL AUTO_INCREMENT,
title TEXT,
is_done BOOL DEFAULT true,
created DATETIME DEFAULT NOW(),
PRIMARY KEY (id)
);

INSERT INTO worklists (title) VALUES ("aaa");
INSERT INTO worklists (title,is_done) VALUES ("bbb",false);

SELECT * FROM worklists;

DROP TABLE worklists;


