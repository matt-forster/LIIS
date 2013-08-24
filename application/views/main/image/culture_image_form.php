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
 * Culture Image Form
 *
 * Used the the culture record view to show the add image popup
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
    <?php echo form_open_multipart( '/culture/do_upload_image');?>
        <select name="type" id="typelist">
            <option value="CULTURE">
                Culture
            </option>
            <option value="DNARNA">
                DNA/RNA
            </option>
        </select>
        <input type="hidden" name="CULT_ID" value="<?php echo $CULTURE['CULT_ID']; ?>">
        <input type="hidden" name="CULT_LABNUM" value="<?php echo $CULTURE['CULT_LABNUM']; ?>">
        <select name="DNARNA_ID" id="dnarnaidlist" style="display: none;" required>
            <option value="none">
                Choose One
            </option>
            <?php foreach ($DNARNA as $option){ echo '<option value="'.$option[ 'DNARNA_ID'].
            '">'.$option[ 'DNARNA_ID']. '</option>'; } ?>
        </select>
        <input type="text" name="CULT_IMG_CAP" size="20" placeholder="Description" required/>
        <input type="file" name="userfile" required/>
        <br />
        <br />
        <input class="btn btn-main" type="submit" value="Upload" />
        </form>
</div>
<script type="text/javascript">
    $('#typelist').change(function() {
        if ($(this).val() === 'DNARNA') {
            $('#dnarnaidlist').css('display', 'inline-block');
        } else {
            $('#dnarnaidlist').val('none');
            $('#dnarnaidlist').css('display', 'none');
        }
    });
</script>