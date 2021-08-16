

CREATE TABLE `tbuser` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `name` varchar(50) NOT NULL,
   `birth` date NOT NULL,
   `email` varchar(50) NOT NULL,
   `password` varchar(300) NOT NULL,
   `user_type` int(11) NOT NULL,
   `accept` bool default true,
   `welcome` bool default true,
   PRIMARY KEY (`id`),
   UNIQUE KEY `email` (`email`)
 ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
 

drop table tbuser;

 create table tbsegment (
 id int not null primary key auto_increment,
 title varchar(100) not null unique
 );

 create table tbshowagency (
 id int not null primary key auto_increment,
 cnpj varchar(14) not null unique,
 fantasy_name varchar(200) not null,
 phone varchar(21),
 professional_mail varchar(100) not null,
 user_id int not null unique,
 foreign key (user_id) references tbuser(id)
 );
 
 create table tbshowagencysegment (
 segment_id int not null,
 showagency_id int not null,
 primary key(segment_id, showagency_id),
 foreign key (segment_id) references tbsegment(id),
 foreign key (showagency_id) references tbshowagency(id)
 );
 
 create table tbshow(
 id int not null primary key auto_increment,
 cep varchar(12), 
 thumbnail varchar(200) not null,
 title varchar(100) not null,
 description varchar(2000) not null,
 address varchar(150) not null,
 start_date date not null,
 end_date date not null,
 user_id int not null,
 foreign key (user_id) references tbuser(id)
 );
 
 create table tbticket(
 id int not null primary key auto_increment,
 price double not null,
 active bool not null default true,
 show_id int not null,
 qtd_ticket int not null,
 created date default now(),
 description varchar(50) not null,
 foreign key (show_id) references tbshow(id)
 );
 

 create table tbuserpurchase(
 user_id int not null,
 ticket_id int not null,
 price_purchased float not null,
 purchased_at date not null default now(),
 primary key(user_id, ticket_id),
 foreign key (user_id) references tbuser(id),
 foreign key (ticket_id) references tbticket(id)
 );
 
create table tbclicktracking(
id int not null primary key auto_increment,
ip varchar(30) not null,
show_id int not null,
created_at date not null default now(),
foreign key (show_id) references tbshow(id)
);

 insert into tbsegment values (null, 'Música');
 insert into tbsegment values (null, 'Gastronomia');
 insert into tbsegment values (null, 'Cultura');
 