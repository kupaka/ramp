--
-- Tables for information about people generally (names, demographic
-- and contact information, etc) and about staff members more
-- specifically (job titles, contract information, etc.)
--


DROP TRIGGER IF EXISTS prefName_insert;
DROP TRIGGER IF EXISTS prefName_update;
DROP TABLE IF EXISTS Person;

CREATE TABLE Person (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    title VARCHAR ( 5 ),
    firstname VARCHAR ( 30 ) NOT NULL,
    middlename VARCHAR ( 30 ),
    lastname VARCHAR ( 40 ) NOT NULL,
    suffix VARCHAR ( 10 ),
    specifiedPrefFName VARCHAR ( 30 ),
    prefFirstName VARCHAR ( 30 ),
    previousName VARCHAR ( 40 ),
    gender ENUM('Unknown', 'M', 'F') NOT NULL DEFAULT 'Unknown',
    prefEmail VARCHAR ( 30 ),
    prefPhone VARCHAR ( 20 ),
    birthDate DATE NULL,
    deceasedDate DATE NULL,
    citizenship VARCHAR ( 30 ),
    ethnicGroup VARCHAR ( 30 ),
    ssn VARCHAR (9),
    privacy ENUM('F', 'T') NOT NULL DEFAULT 'F',
    updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
);

DELIMITER |
CREATE TRIGGER prefName_insert BEFORE INSERT ON Person
  FOR EACH ROW BEGIN
    SET NEW.prefFirstName = IF (NEW.specifiedPrefFName IS NULL, NEW.firstName,
                                NEW.specifiedPrefFName);
  END;
|
CREATE TRIGGER prefName_update BEFORE UPDATE ON Person
  FOR EACH ROW BEGIN
    SET NEW.prefFirstName = IF (NEW.specifiedPrefFName IS NULL, NEW.firstName,
                                NEW.specifiedPrefFName);
  END;
|
DELIMITER ;


INSERT INTO Person (id, title, firstname, middlename, lastname, specifiedPrefFName,
    previousName, gender, prefEmail, prefPhone, birthDate, citizenship, privacy)
VALUES
(1, 'Dr.', 'Jill', 'Alyce', 'Brady', 'Alyce', 'Faulstich', 'F', 'abrady@kzoo.edu', '123-456-7890', '1961-06-12', 'US', 'F')
, (2, 'Mr.', 'Aly', 'Harry', 'Patrick', DEFAULT, 'Lisa', 'M', 'njala.reg@yahoo.com', '23276615200', '1959-03-14', 'Sierra Leone', 'F')
, (3, 'Mrs.', 'Beth', 'Anne', 'Stork', 'Beth Anne', 'Faulstich', 'F', 'bastork@pretend.com', '222-222-2222', '1963-01-27', 'US', 'F')
, (4, 'Mr.', 'Paul', 'Stuart', 'Faulstich', DEFAULT, DEFAULT, 'M', 'psf@pretend.com', '333-333-3333', '1968-11-02', 'US', 'F')
, (5, 'Sir', 'Walter', DEFAULT, 'Elliot', 'Sir Walter', DEFAULT, 'M', 'sir_walter@persuasion.com', '333-333-3333', '1968-11-02', 'UK', 'F')
, (6, 'Mrs.', 'Mary', DEFAULT, 'Brady', DEFAULT, 'Filardi', 'F', 'mbrady@pretend.com', '444-444-4444', '1925-08-04', 'US', 'F')
, (7, 'Mrs.', 'Mary', DEFAULT, 'Musgrove', DEFAULT, 'Elliot', 'F', 'mm@persuasion@com', '555-555-5555', DEFAULT, 'UK', 'F')
, (24, 'Mr.', 'Henry', DEFAULT, 'Weston', NULL, DEFAULT, 'M', 'gk@emma.com', '555-555-5555', '1957-04-23', 'UK', 'F')
;

INSERT INTO Person (id, firstname, lastname, specifiedPrefFName, gender,
    citizenship, prefEmail, privacy)
VALUES
(8, 'Charles', 'Brown', 'Charlie', 'M', 'US', 'cb@peanutscomicstrip.com', 'F')
, (9, 'Sally', 'Brown', NULL, 'F', 'US', 'sb@peanutscomicstrip.com', 'F')
, (10, 'Linus', 'van Pelt', NULL, 'M', 'US', 'lvp2@peanutscomicstrip.com', 'F')
, (11, 'Lucy', 'van Pelt', NULL, 'F', 'US', 'lvp1@peanutscomicstrip.com', 'F')
, (12, 'Elizabeth', 'Bennet', NULL, 'F', 'UK', 'eb@prideandprejudice.com', 'F')
, (13, 'Mary', 'Bennet', NULL, 'F', 'UK', 'mb@prideandprejudice.com', 'T')
, (14, 'Katherine', 'Bennet', 'Kitty', 'F', 'UK', 'kb@prideandprejudice.com', 'F')
, (15, 'Fitzwilliam', 'Darcy', NULL, 'M', 'UK', 'fd@prideandprejudice.com', 'F')
, (16, 'Elinor', 'Dashwood', NULL, 'F', 'UK', 'ed@senseandsensibility.com', 'F')
, (17, 'Edward', 'Ferrars', NULL, 'M', 'UK', 'ef@senseandsensibility.com', 'F')
, (18, 'Anne', 'Elliot', NULL, 'F', 'UK', 'ae@persuasion.com', 'F')
, (19, 'Frederick', 'Wentworth', NULL, 'M', 'UK', 'fw@persuasion.com', 'F')
, (20, 'Emma', 'Woodhouse', NULL, 'F', 'UK', 'ew@emma.com', 'F')
, (21, 'George', 'Knightly', NULL, 'M', 'UK', 'gk@emma.com', 'F')
, (22, 'Frances', 'Price', 'Fanny', 'F', 'UK', 'fp@mansfieldpark.com', 'F')
, (23, 'Edmund', 'Bertram', NULL, 'M', 'UK', 'eb@mansfieldpark.com', 'F')
;

DROP TABLE IF EXISTS Address;

CREATE TABLE Address (
    pk_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    personID INT NOT NULL,
    addressType ENUM('PermanentHome', 'CurrentMailing', 'Billing',
        'PersonalEmail', 'WorkEmail', 'Phone') NOT NULL,
    address1 VARCHAR ( 40 ) NOT NULL,
    address2 VARCHAR ( 40 ),
    address3 VARCHAR ( 40 ),
    address4 VARCHAR ( 40 ),
    address5 VARCHAR ( 40 ),
    startDate DATE NOT NULL,
    endDate DATE NULL,
    updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS Staff;

CREATE TABLE Staff (
    staffID INT NOT NULL PRIMARY KEY,
    officeNumber VARCHAR ( 6 ),
    officeBuilding VARCHAR ( 20 ),
    updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (staffID) REFERENCES Person (id) ON UPDATE CASCADE
);

INSERT INTO Staff (staffID, officeNumber, officeBuilding)
VALUES
(1, '203G', 'Olds/Upton Hall')
, (2, '1', 'Secretariat')
, (3, '123', 'Greenville')
, (4, '123', 'Olds/Upton Hall')
, (5, DEFAULT, DEFAULT)
, (6, '123', 'Olds/Upton Hall')
, (24, '203B', 'Olds/Upton Hall')
;

DROP TABLE IF EXISTS StaffContract;

CREATE TABLE StaffContract (
    pk_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    staffID INT NOT NULL,
    school VARCHAR (30),
    department VARCHAR (30),
    jobFunction ENUM('Teaching', 'Administrative', 'Service', 'Other')
        NOT NULL DEFAULT 'Other',
    jobTitle VARCHAR ( 40 ) NOT NULL,
    status ENUM('', 'Full-time', 'Part-time', 'On Leave', 'Ended'),
    startDate DATE NOT NULL,
    endDate DATE NULL,
    updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (staffID) REFERENCES Person (id),
    INDEX (staffID)
);

INSERT INTO StaffContract (staffID, department, jobFunction, jobTitle,
    status, startDate, endDate)
VALUES
(1, 'Math/CS', 'Teaching', 'Asst. Prof. of Computer Science', 'Ended', '1994-09-26', '2001-03-15')
, (1, 'Math/CS', 'Teaching', 'Assoc. Prof. of Computer Science', 'Ended', '2001-03-15', '2010-03-15')
, (1, 'Math/CS', 'Teaching', 'Professor of Computer Science', 'Full-time', '2010-03-15', DEFAULT)
, (2, 'Secretariat', 'Administrative', 'Asst. Registrar', 'Full-time', '2007-09-15', DEFAULT)
, (3, 'History', 'Teaching', 'Teacher', 'Full-time', '2001-08-15', DEFAULT)
, (4, 'Lang. and Lit.', 'Teaching', 'Teacher', 'Full-time', '2001-08-15', DEFAULT)
, (5, 'Gentry', 'Other', 'Narcissistic Baronet', 'Ended', '2000-08-15', '2010-08-15')
, (6, 'Economics', 'Teaching', 'Teacher', 'Full-time', '2001-08-15', DEFAULT)
, (24, 'Math/CS', 'Teaching', 'Asst. Prof. of Mathematics', 'Full-time', '2008-09-15', DEFAULT)
;

