create table inventory (
   num int not null auto_increment,
   product char(40) not null,  /*품명*/
   seller char(10) , /*판매자*/
   sale int, /*판매량*/
   price int, /*판매가*/
   stock int, /*재고*/
   delivery_date char(20), /*배송에 걸리는 시간*/
   file_name char(40), /*이미지 파일 이름*/
   primary key(num)
);
insert into inventory (product, sale, seller ,price, stock, delivery_date,file_name) values("사과",3,"admin",1500,100,3,"apple.png");
insert into inventory (product, sale, seller ,price, stock, delivery_date,file_name) values("바나나",2,"admin",2000,100,2,"banana.png");
insert into inventory (product, sale, seller ,price, stock, delivery_date,file_name) values("수박",1,"admin",15000,30,4,"watermelon.png");
/* 기본 등록된 물건 3가지 */