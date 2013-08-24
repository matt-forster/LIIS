<!-- /**
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
 * Message
 *
 * Template for showing error / success messages. Include after populating the $message variable
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */
 -->

<?php
	foreach ($message as $msg){
		switch($msg['Type']){
			case 'error':
				echo "<div class='alert alert-error small'>".$msg['Message']."</div>";
				break;
			case 'warning':
				echo "<div class='alert small'>".$msg['Message']."</div>";
				break;
			case 'success':
				echo "<div class='alert alert-success small'>".$msg['Message']."</div>";
				break;
			default:
				echo "<div class='alert small'>".$msg['Message']."</div>";
		}
	}
