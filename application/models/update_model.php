<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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
 * Update Model
 *
 * Loads the methods used to update the application
 *
 * @category    LIIS-Model
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */

class Update_model extends CI_Model
{
	public function __construct(){
		parent::__construct();

		$this->userdb = $this->load->database('user', TRUE);
		$this->datadb = $this->load->database('data', TRUE);
	}

	public function run($query){
		$this->db->query($query);
	}
}
    



//Export CSV directly from MySql

//SELECT SAMPLE.SAMP_EXP_ID, SAMPLE.SAMP_ID, SAMPLE.SAMP_DATE, SAMPLE.SAMP_STOR_LOC, SAMPLE.SAMP_PERIOD, SAMPLE.SAMP_TYPE, SAMPLE_SITE.SAMPSITE_SITE, SAMPLE_SITE.SAMPSITE_SUBSITE, GEO_LOCATION.GEO_LAT, GEO_LOCATION.GEO_LONG, GEO_LOCATION.GEO_DESC, SAMPLE.SAMP_NOTES, ANIMAL.ANI_NUM, ANIMAL.ANI_TYPE, ANIMAL.ANI_SUBTYPE, ANIMAL.ANI_DIET
// FROM SAMPLE
// JOIN ANIMAL ON SAMPLE.ANI_ID = ANIMAL.ANI_ID
// JOIN SAMPLE_SITE ON SAMPLE.SAMPSITE_ID = SAMPLE_SITE.SAMPSITE_ID
// JOIN GEO_LOCATION ON SAMPLE.GEO_ID = GEO_LOCATION.GEO_ID
// INTO OUTFILE 'samplefull2.csv'
// FIELDS TERMINATED BY ','
// ENCLOSED BY '"'
// LINES TERMINATED BY '\n';