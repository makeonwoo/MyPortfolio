create table purchase_list (
   num int not null auto_increment,
   consumer_name char(20) not null,
   consumer_address char(20) not null,
   purchase_product char(20) not null,
   purchase_price int,
   purchase_number int,
   end_delivered char(20),
   primary key(num)
);
