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
 * navbar
 *
 * The navbar for the main area of the application
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */
 -->

<div class="container">
    <div class="navbar">
        <div class="navbar-inner">
            <?php echo '<a class="brand" href="'.site_url().(($sample=='active' ) ? 'sample/' :
            'culture/') . '">LIIS</a>';?>
                <ul class="nav">
                    <?php echo '<li class="muted barversion"><a href="'.site_url().(($sample=='active' ) ?
                    'sample/' : 'culture/') . '">'.$version. '</a></li>'; ?>
                </ul>
                <!-- Right Menu -- -->
                <ul class="nav pull-right">
                    <li class="<?php echo $sample; ?>" id="">
                        <a href="<?php echo site_url('sample/'); ?>">Sample</a>
                    </li>
                    <li class="<?php echo $culture; ?>" id="culture">
                        <a href="<?php echo site_url('culture/'); ?>">Culture</a>
                    </li>
                    <li class="divider-vertical">
                    </li>
                    <li>
                        <a><?php echo $this->session->userdata('user'); ?></a>
                    </li>
                    <!-- Link to Main Help Page-->
                    <li class="small">
                        <a href="<?php echo site_url('help/main'); ?>">Help</a>
                    </li>
                    <!-- Link to Logout Script-->
                    <li class="small" id="logout">
                        <a href="<?php echo site_url('login/do_logout'); ?>">Logout</a>
                    </li>
                </ul>
        </div>
        <!-- /inner -->
    </div>
    <!-- /navbar -->
</div>
<!-- /container -->