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
 * Culture Searchbar
 *
 * The culture omnibar which shows the appropriate filters
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */
 -->

<!-- Search Bar -------------------------------- -->
<div class="fixed" id="searchbar">
    <!-- Search Bar -->
    <div class="row">
        <div class="span12" data-position="bottom" data-intro="Use this bar to search content. It supports some advanced syntax. See the Searching section on the help page for more info."
        data-step="1">
            <form id="searchform" class="form-search center" action="" method="post" onsubmit="return false;">
                <!-- START SEARCH FORM -->
                <input type="text" placeholder="Input Search Query" class="input-medium search-query"
                id="omnibar" name="query" value="<?php echo $query; ?>">
                <button type="submit" class="btn btn-main" id="searchCulture">
                    Search
                </button>
        </div>
    </div>
    <!-- /row -->
    <!-- Filters -------------------------------- -->
    <div class="row">
        <div class="span11">
            <div class="center" id="filters" data-position="bottom" data-intro="These are the search filters, and control what your search finds. <br>See the  'Filters for Sample' and 'Filters for Culture' sections on the help page for more info."
            data-step="2">
                <label class="radio inline">
                    <input type="radio" id="culture" value="culture" name="filter" <?php echo set_checkbox(
                    'filter', 'culture', TRUE); ?>
                    > Culture
                </label>
                <label class="radio inline">
                    <input type="radio" id="daterange" value="daterange" name="filter" <?php echo set_checkbox(
                    'filter', 'daterange'); ?>
                    > Date
                </label>
                <label class="radio inline">
                    <input type="radio" id="strain" value="strain" name="filter" <?php echo set_checkbox(
                    'filter', 'strain'); ?>
                    > Strain
                </label>
            </div>
            </form>
            <!-- END SEARCH FORM -->
        </div>
        <div class="span1">
            <p class="muted" id="filtertag">
                Filters
            </p>
        </div>
    </div>
    <!-- row -->
</div>