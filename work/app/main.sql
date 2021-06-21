CREATE TABLE folder(
id INT NOT NULL AUTO_INCREMENT,
folder_name TEXT,
PRIMARY KEY (id)
);

CREATE TABLE record(
id INT NOT NULL AUTO_INCREMENT,
folder_id INT NOT NULL,
created DATETIME DEFAULT NOW(),
pro_summary TEXT,
pro_detail TEXT,
pro_attachment TEXT,
so_summary TEXT,
so_detail TEXT,
so_attachment TEXT,
is_done BOOL DEFAULT true,
PRIMARY KEY (id),
FOREIGN KEY (folder_id) REFERENCES folder(id)
    ON DELETE CASCADE
);

INSERT INTO folder (folder_name) VALUES ('study_support');
INSERT INTO folder (folder_name) VALUES ('chat_app');


SELECT * FROM record\G

INSERT INTO record (folder_id,pro_summary,so_summary,is_done) VALUES (1,'drag&drop','taioutyuu',0);
INSERT INTO record (folder_id,pro_summary,so_summary,is_done) VALUES (1,'putName','taiousimasita',1);
INSERT INTO record (folder_id,pro_summary,so_summary,is_done) VALUES (2,'tolkgahyoujisarenai','taioutyuu',0);
INSERT INTO record (folder_id,pro_summary,so_summary,is_done) VALUES (2,'soushinnsyagawakaranai','taioushimasia',1);

DELETE FROM worklists;




DROP TABLE folder;
DROP TABLE record;




