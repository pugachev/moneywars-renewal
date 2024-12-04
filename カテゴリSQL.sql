insert into categories(cate_num,cate_name) values(100,'食費');
insert into categories(cate_num,cate_name) values(101,'ガジェット費');
insert into categories(cate_num,cate_name) values(102,'日用品');
insert into categories(cate_num,cate_name) values(103,'外食費');
insert into categories(cate_num,cate_name) values(104,'医療費');
insert into categories(cate_num,cate_name) values(105,'薬費');
insert into categories(cate_num,cate_name) values(106,'サービス費');

insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(100,'2023-10-28',885,now(),now());

insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(100,'2023-10-29',780,now(),now());
insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(102,'2023-10-30',980,now(),now());
insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(100,'2023-10-31',890,now(),now());
insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(102,'2023-10-31',520,now(),now());

insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(100,'2023-11-01',1120,now(),now());
insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(102,'2023-11-01',1980,now(),now());
insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(100,'2023-11-02',890,now(),now());
insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(102,'2023-11-02',1010,now(),now());
insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(105,'2023-11-02',2000,now(),now());
insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(102,'2023-11-03',1980,now(),now());
insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(106,'2023-11-03',3500,now(),now());
insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(102,'2023-11-04',1980,now(),now());
insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(100,'2023-11-05',1050,now(),now());
insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(102,'2023-11-05',1120,now(),now());
insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(100,'2023-11-06',880,now(),now());
insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(102,'2023-11-06',1350,now(),now());
insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(100,'2023-11-07',780,now(),now());
insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(102,'2023-11-07',650,now(),now());

insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(100,'2023-11-08',900,now(),now());
insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(102,'2023-11-08',810,now(),now());

insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(100,'2023-11-09',1900,now(),now());
insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(102,'2023-11-09',3000,now(),now());

insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(100,'2023-11-10',670,now(),now());
insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(105,'2023-11-10',3700,now(),now());

insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(100,'2023-11-11',2670,now(),now());
insert into spendings(tgt_item,tgt_date,tgt_payment,created_at,updated_at) values(104,'2023-11-11',1100,now(),now());


SELECT tgt_date,sum(tgt_payment) FROM `spendings` WHERE tgt_date BETWEEN '2023-10-29' AND '2023-11-04' GROUP BY tgt_date


ALTER TABLE spendings ADD tgt_name text; 

Log::debug([$tgtdate,$result['sumvalue']]);