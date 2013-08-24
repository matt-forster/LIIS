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
 * Sample Image Form
 *
 * Used by the sample record view to show the sample image form
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */
 -->

<div class="span4 offset1 higher">
    <h3>
        Upload Image
    </h3>
    <?php echo form_open_multipart( '/sample/do_upload_image');?>
        <input type="hidden" name="SAMP_EXP_ID" value="<?php echo $SAMPLE['SAMP_EXP_ID']; ?>">
        <input type="hidden" name="SAMP_ID" value="<?php echo $SAMPLE['SAMP_ID']; ?>">
        <select name="DNARNA_ID" id="dnarnaidlist" required>
            <option value="none">
                Choose One
            </option>
            <?php foreach ($DNARNA as $option){ echo '<option value="'.$option[ 'DNARNA_ID'].
            '">'.$option[ 'DNARNA_ID']. '</option>'; } ?>
        </select>
        <input type="text" name="SAMP_IMG_CAP" size="20" placeholder="Description" required/>
        <input type="file" name="userfile" required/>
        <br />
        <br />
        <input class="btn btn-main" type="submit" value="Upload" />
        </form>
</div>