CREATE TABLE worklists(
id INT NOT NULL AUTO_INCREMENT,
title TEXT,
is_done BOOL DEFAULT true,
created DATETIME DEFAULT NOW(),
folderNo INT ,
PRIMARY KEY (id)
);

INSERT INTO worklists (title,folderNo) VALUES ("F1",1);
INSERT INTO worklists (title,is_done,folderNo) VALUES ("F1",false,1);
INSERT INTO worklists (title,folderNo) VALUES ("F2",2);
INSERT INTO worklists (title,is_done,folderNo) VALUES ("F2",false,2);

SELECT * FROM worklists;



DROP TABLE worklists;




