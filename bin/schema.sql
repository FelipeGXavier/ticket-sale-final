CREATE TABLE `tbuser` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `name` varchar(50) NOT NULL,
   `birth` date NOT NULL,
   `email` varchar(50) NOT NULL,
   `password` varchar(300) NOT NULL,
   `user_type` int(11) NOT NULL,
   `accept` bool default true,
   PRIMARY KEY (`id`),
   UNIQUE KEY `email` (`email`)
 ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
 
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
 user_id int not null,
 foreign key (user_id) references tbuser(id)
 );
 
 create table tbshowagencysegment (
 segment_id int not null,
 showagency_id int not null,
 primary key(segment_id, showagency_id),
 foreign key (segment_id) references tbsegment(id),
 foreign key (showagency_id) references tbshowagency(id)
 );
 