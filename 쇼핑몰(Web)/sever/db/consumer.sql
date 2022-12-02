create table consumer (
    num int not null auto_increment,
    id char(15) not null,
    pass char(15) not null,
    name char(10) not null,
    address char(80),
    money int,
    primary key(num)
);
insert into consumer (id, pass, name ,address, money) values("admin","1234","관리자","인터넷",1000000);