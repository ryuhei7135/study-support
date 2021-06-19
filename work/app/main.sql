CREATE TABLE worklists(
id INT NOT NULL AUTO_INCREMENT,
pro_summary TEXT,
proDetail TEXT,
proAttachment TEXT,
soSummary TEXT,
soDetail TEXT,
soAttachment TEXT,
is_done BOOL DEFAULT true,
created DATETIME DEFAULT NOW(),
folderNo INT ,
folderName TEXT,
PRIMARY KEY (id)
);

INSERT INTO worklists (pro_summary,proDetail,proAttachment,soSummary,soDetail,soAttachment,folderNo) VALUES ('pro_summary','proDetail','proAttachment','soSummary','soDetail','soAttachment',1);
INSERT INTO worklists (pro_summary,is_done,folderNo) VALUES ("F1",false,1);
INSERT INTO worklists (pro_summary,folderNo) VALUES ("F2",2);
INSERT INTO worklists (pro_summary,is_done,folderNo) VALUES ("F2",false,2);

SELECT * FROM worklists\G

INSERT INTO worklists (pro_summary,soSummary,folderNo,folderName) VALUES ('test','test',1,'testfolder');
INSERT INTO worklists (pro_summary,proDetail,proAttachment,soSummary,soDetail,soAttachment,folderNo,folderName) VALUES ('test','test','test','test','test','test',1,'testfolder2');

DELETE FROM worklists WHERE id =2;




DROP TABLE worklists;




