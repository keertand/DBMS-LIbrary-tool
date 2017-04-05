drop schema if exists library;
create schema library;
use library;
create table Book(ISBN varchar(30) NOT NULL,Title varchar(100),availability boolean DEFAULT 1,PRIMARY KEY (ISBN));
create table Authors(Author_id int(4) AUTO_INCREMENT,Name varchar(100),PRIMARY KEY(Author_id));
create table Book_Authors(Author_id int(4) NOT NULL,ISBN varchar(30) NOT NULL,PRIMARY KEY (Author_id,ISBN));
create table Borrower(Card_id int(4) AUTO_INCREMENT,Ssn varchar(20) NOT NULL UNIQUE,Fname varchar(100),Lname varchar(100),Address varchar(100),Phone varchar(30),PRIMARY KEY(Card_id));
create table Book_Loans(Loan_id int(4) AUTO_INCREMENT,ISBN varchar(30),Card_id int(4) NOT NULL,Date_out timestamp,Due_date timestamp,Date_in timestamp, PRIMARY KEY (Loan_id));
create table Fines(Loan_id int(4),Fine_amt float(20),paid boolean DEFAULT 0,Primary key (Loan_id));