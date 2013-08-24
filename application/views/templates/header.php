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
 * Header
 *
 * The template that starts the document. Includes all third party javascript and all css
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */
 -->

<!doctype html>
<html>
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>
            <?php echo $title; ?>
        </title>
        <!-- Add CSS pages from controller as needed. -->
        <?php foreach ($cssList as $css) { echo
        '<link rel="stylesheet" type="text/css" href="'.base_url().CSS.$css. '.css">'; } ?>
            <!-- Add script files from controller as needed. -->
            <?php foreach ($scriptList as $js) { echo '<script type="text/javascript" src="'.base_url().JS.$js.
            '.js"></script>'; } ?>
    </head>
    
    <body>