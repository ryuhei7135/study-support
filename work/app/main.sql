CREATE TABLE folders(
id INT NOT NULL AUTO_INCREMENT,
`name` TEXT,
PRIMARY KEY (id)
);

CREATE TABLE records(
id INT NOT NULL AUTO_INCREMENT,
title TEXT,
created DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
is_done BOOL DEFAULT false,
folder_id INT NOT NULL,
PRIMARY KEY (id),
FOREIGN KEY (folder_id) REFERENCES folders(id)
ON DELETE CASCADE
);

CREATE TABLE contents(
id INT NOT NULL AUTO_INCREMENT,
challenge TEXT NOT NULL,
problem TEXT NOT NULL,
attachment VARCHAR(255) UNIQUE,
record_id INT,
PRIMARY KEY (id),
FOREIGN KEY (record_id) REFERENCES records(id)
ON DELETE CASCADE
);


INSERT INTO folders (`name`) VALUES ('share_location');
INSERT INTO folders (`name`) VALUES ('chat_app');

INSERT INTO records (title,is_done,folder_id) VALUES ('viewMap',1,1);
INSERT INTO records (title,is_done,folder_id) VALUES ('viewSender',0,2);

INSERT INTO contents (challenge,problem,attachment,record_id) VALUES ('contentId「1」を編集しました','contentId「1」を編集しました','contentId「1」を編集しました',1);
INSERT INTO contents (challenge,problem,attachment,record_id) VALUES ('contentId「2」を編集しました','contentId「2」を編集しました','contentId「2」を編集しました',1);
INSERT INTO contents (challenge,problem,attachment,record_id) VALUES ('API','success','none',2);

DELETE FROM contents WHERE id>=9;
DELETE FROM records;

SELECT * FROM folders;
SELECT * FROM records;
SELECT * FROM contents\G







DELETE FROM record WHERE id =9;
DELETE FROM content WHERE content_id = 4;

DROP TABLE folders;
DROP TABLE records;
DROP TABLE contents;




