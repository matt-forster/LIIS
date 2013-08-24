<?php

/**
 * Laboratory Information Indexing System
 *
 * An open source mini LIMS for metadata organisation and archival purposes
 *
 * @author      Matt Forster / @frostyforster
 * @copyright   Copyright (c) 2013, Matthew S. Forster
 * @license     MIT (./license.txt)
 * @link        http://github.com/forstermatth/liis
 * @since       Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Update Controller
 *
 * Controls the logic involved in the first installation of the LIIS
 *
 * @category    LIIS-Controller
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */

//-------------------------------------------------------------------------

//SETUP

//Database connection variables
//Use the same variables here as you would in appliaction/config/database.php 
$host 		= 'localhost';
$user 		= 'root';
$password 	= 'password';


//-------------------------------------------------------------------------

//DO NOT EDIT PAST HERE

//Installation Script

$sql = "
	CREATE DATABASE USER;
    USE USER;

    CREATE TABLE USERS(
        USER_ID INT(10) NOT NULL AUTO_INCREMENT,
        USER_FNAME VARCHAR(40) NOT NULL,
        USER_LNAME VARCHAR(40) NOT NULL,
        USER_AUTH CHAR(10) NOT NULL,
        USER_NAME VARCHAR(20) NOT NULL,
        USER_PASS CHAR(32) NOT NULL,
        CONSTRAINT USER_PK PRIMARY KEY(USER_ID),
        CONSTRAINT USER_UNIQUE UNIQUE(USER_NAME)
    );


    CREATE DATABASE LIISDATA;
    USE LIISDATA;



    CREATE TABLE TAXONOMY(
        TAX_ID INT(10) NOT NULL AUTO_INCREMENT,
        TAX_DOMAIN VARCHAR(40),
        TAX_KINGDOM VARCHAR(40),
        TAX_PHYLUM VARCHAR(40),
        TAX_CLASS VARCHAR(40),
        TAX_ORDER VARCHAR(40),
        TAX_FAMILY VARCHAR(40),
        TAX_GENUS VARCHAR(40),
        TAX_SPECIES VARCHAR(40),
        TAX_STRAIN VARCHAR(40),
        TAX_USER VARCHAR(20) NOT NULL,
        TAX_MODDATE DATE,
        CONSTRAINT TAX_PK PRIMARY KEY (TAX_ID)
    );


    CREATE TABLE CULTURE(
        CULT_ID INT(10) NOT NULL AUTO_INCREMENT,
        CULT_LABNUM VARCHAR(20) NOT NULL,
        CULT_DATE DATE NOT NULL,
        CULT_RISKG INT(10) NOT NULL,
        CULT_REFNUM VARCHAR(40),
        CULT_STOR_LOC VARCHAR(20),
        CULT_STORED_STATE VARCHAR(20),
        CULT_OWNER VARCHAR(20),
        CULT_HIST LONGTEXT,
        CULT_ISO_SOURCE VARCHAR(20),
        CULT_RRNA_SEQ LONGTEXT,
        CULT_EXTERN_ID VARCHAR(40),
        CULT_NOTES LONGTEXT,
        TAX_ID INT(10),
        CULT_USER VARCHAR(20) NOT NULL,
        CULT_MODDATE DATE,
        CULT_IMG_PATH VARCHAR(40),
        CULT_IMG_CAP VARCHAR(40),
        CONSTRAINT CULT_PK PRIMARY KEY(CULT_ID),
        CONSTRAINT CULT_TAX_FK FOREIGN KEY(TAX_ID) REFERENCES TAXONOMY(TAX_ID) ON DELETE CASCADE ON UPDATE CASCADE
    );


    CREATE TABLE VIAL(
        VIAL_ID INT(10) NOT NULL,
        CULT_ID INT(10) NOT NULL,
        VIAL_GROWTH_TYPE VARCHAR(60),
        VIAL_GROWTH_TEMP VARCHAR(20),
        VIAL_STOR_LOC VARCHAR(20) NOT NULL,
        VIAL_NOTES LONGTEXT,
        VIAL_USER VARCHAR(20) NOT NULL,
        VIAL_MODDATE DATE,
        CONSTRAINT VIAL_PK PRIMARY KEY(VIAL_ID),
        CONSTRAINT VIAL_CULT_FK FOREIGN KEY(CULT_ID) REFERENCES CULTURE(CULT_ID) ON DELETE CASCADE ON UPDATE CASCADE
    );


    CREATE TABLE SOURCE(
        SOURCE_ID INT(10) NOT NULL AUTO_INCREMENT,
        SOURCE_NUM INT(10) NOT NULL,
        SOURCE_TYPE VARCHAR(40),
        SOURCE_SUBTYPE VARCHAR(40),
        SOURCE_TREATMENT VARCHAR(60),
        SOURCE_USER VARCHAR(20) NOT NULL,
        SOURCE_MODDATE DATE,
        CONSTRAINT SOURCE_PK PRIMARY KEY(SOURCE_ID)
    );


    CREATE TABLE SAMPLE(
        SAMP_ID INT(10) NOT NULL,
        SAMP_EXP_ID VARCHAR(10) NOT NULL,
        SAMP_DATE DATE NOT NULL,
        SAMP_TIME TIME,
        SAMP_TMZ VARCHAR(10),
        SAMP_COUNTRY VARCHAR(40),
        SAMP_STOR_LOC VARCHAR(40) NOT NULL,
        SAMP_BIOME VARCHAR(40),
        SAMP_MAT VARCHAR(40),
        SAMP_TYPE VARCHAR(40),
        SAMP_SITE VARCHAR(40),
        SAMP_SUBSITE VARCHAR(40),
        SAMP_GEO_LAT VARCHAR(40),
        SAMP_GEO_LONG VARCHAR(40),
        SAMP_GEO_DESC VARCHAR(40),
        SAMP_ENVPKG VARCHAR(40),
        SAMP_NOTES LONGTEXT,
        SAMP_PERIOD INT(10),
        SOURCE_ID INT(10),
        SAMP_USER VARCHAR(20) NOT NULL,
        SAMP_MODDATE DATE,
        CONSTRAINT SAMPLE_PK PRIMARY KEY(SAMP_ID, SAMP_EXP_ID),
        CONSTRAINT SAMPLE_SOURCE_FK FOREIGN KEY(SOURCE_ID) REFERENCES SOURCE(SOURCE_ID) ON DELETE CASCADE ON UPDATE CASCADE
    );


    CREATE TABLE DNARNA(
        DNARNA_ID VARCHAR(20),
        DNARNA_TYPE CHAR(3) NOT NULL,
        DNARNA_DATE DATE NOT NULL,
        DNARNA_VOL VARCHAR(10),
        DNARNA_CONC VARCHAR(10),
        DNARNA_GBANKNUM VARCHAR(40),
        DNARNA_NOTES LONGTEXT,
        CULT_ID INT(10),
        SAMP_EXP_ID VARCHAR(10),
        SAMP_ID INT(10),
        DNARNA_USER VARCHAR(20) NOT NULL,
        DNARNA_MODDATE DATE,
        DNARNA_IMG_PATH VARCHAR(40),
        DNARNA_IMG_CAP VARCHAR(40),
        CONSTRAINT DNARNA_PK PRIMARY KEY(DNARNA_ID),
        CONSTRAINT DNARNA_SAMP_FK FOREIGN KEY(SAMP_ID, SAMP_EXP_ID) REFERENCES SAMPLE(SAMP_ID, SAMP_EXP_ID) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT DNARNA_CULT_FK FOREIGN KEY(CULT_ID) REFERENCES CULTURE(CULT_ID) ON DELETE CASCADE ON UPDATE CASCADE
    );

    USE USER;

    INSERT INTO USERS(USER_FNAME, 	USER_LNAME,	 	USER_AUTH,  USER_NAME,  		USER_PASS)
    VALUES (		  'Admin', 	  	'Root',  	    'ADMIN', 	'admin', 		    md5('liissysroot') );
	";
		
	//open database connection
	$db = new mysqli($host, $user, $password);
	if($db->connect_errno > 0){
	    die("Unable to connect to the database [".$db->connect_error."]");
	}

	 if(!$result = $db->multi_query($sql)){
        die('There was an error running the query [' . $db->error . ']. <br> <strong>If you are trying to reset the LIIS database, surf to site/uninstall.php</strong>');
    }
    
    echo "<strong>The LIIS database structure has been created successfully.</strong><br>";
    echo "Please surf to the login page, and log in as 'admin' with password 'liissysroot'.<br>
          It is advised that you change this default password, and create a user for regular use.   
         ";
    $db->close();







// load data local infile 'dnarna.csv'
// into table DNARNA
// FIELDS TERMINATED BY ','
// ENCLOSED BY '\"' 
// LINES TERMINATED BY '\n' 
// (DNARNA_ID, DNARNA_TYPE, DNARNA_DATE, DNARNA_VOL, DNARNA_CONC, DNARNA_GBANKNUM, DNARNA_NOTES, CULT_ID, SAMP_EXP_ID, SAMP_ID);
