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

 /* ------------------------------------------------------------------------ */

/**
 * main.js
 *
 * all of the javascript used in the application
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */

//Procedues ==================================================
$(document).ready(function () {
    
     //Progress bar -------------------------------------------------
    $('#progbar').hide()

    $('#progbar').ajaxStart(function () {
        $(this).show();
    })
    $('#progbar').ajaxStop(function () {
        $(this).hide();
    })

    // Record-------------------------------------------------------
    $("#view").addClass('disabled');
    $('#view').removeClass('btn-main');

    $('#addsampleimage').click(function () {
        proj = document.getElementById('samp_exp_id').value;
        id = document.getElementById('samp_id').value
        window.open('/sample/upload_image/' + proj + '/' + id, '', 'left=500,top=500,width=400px,height=400px,location=no,menubar=no,resizeable=no,scrollbars=no,titlebar=no,status=no,toolbar=no');
    });

    $('#addcultureimage').click(function () {
        id = document.getElementById('cult_id').value;
        window.open('/culture/upload_image/' + id, '', 'left=500,top=500,width=400px,height=400px,location=no,menubar=no,resizeable=no,scrollbars=no,titlebar=no,status=no,toolbar=no');
    });


    // Search ------------------------------------------------------
    $('#searchCulture').click(function () {
        $('#results').empty();
        var data = $('#searchform').serializeArray();
        $('#results').load('/culture/do_search', data, function () {
            sessionStorage.setItem('stored', 1);
            sessionStorage.setItem('cultquery', $('#omnibar').val());
            sessionStorage.setItem('cultfilter', $('input[name=filter]:checked').val());
        });
    });

    $('#searchSample').click(function () {
        $('#results').empty();
        var data = $('#searchform').serializeArray();
        $('#results').load('/sample/do_search', data, function () {
            sessionStorage.setItem('stored', 1);
            sessionStorage.setItem('sampquery', $('#omnibar').val());
            sessionStorage.setItem('sampfilter', $('input[name=filter]:checked').val());
        });
    });

    if (sessionStorage.stored && (location.pathname == '/culture/' || location.pathname == '/sample/' || location.pathname == '/culture' || location.pathname == '/sample')) {
        var href = window.location.pathname;
        href = href.split('/');
        $('#results').empty();
        $('#progbar').show();

        if ($('#culture').attr('class') == 'active') {
            data = {
                'query': sessionStorage.cultquery,
                'filter': sessionStorage.cultfilter
            };
            $('#results').load('/' + href[1] + '/do_search', data, function () {
                $('#progbar').hide();
            });
            $('#omnibar').val(sessionStorage.cultquery);
            $('input[name=filter]').filter('[value=' + sessionStorage.cultfilter + ']').prop('checked', 'checked');
        } else {
            data = {
                'query': sessionStorage.sampquery,
                'filter': sessionStorage.sampfilter
            };
            $('#results').load('/' + href[1] + '/do_search', data, function () {
                $('#progbar').hide();
            });
            $('#omnibar').val(sessionStorage.sampquery);
            $('input[name=filter]').filter('[value=' + sessionStorage.sampfilter + ']').prop('checked', 'checked');
        }
    }

    if (location.pathname == '/culture/recent/' || location.pathname == '/sample/recent/' || location.pathname == '/culture/recent' || location.pathname == '/sample/recent') {
        var href = window.location.pathname;
        href = href.split('/');
        $('#results').empty();
        $('#progbar').show();
        data = {
            'query': 'none',
            'filter': 'recent'
        };
        $('#results').load('/' + href[1] + '/do_search', data, function () {
            $('#progbar').hide();
        });
    }


    //Create/edit --------------------------------------------------
    var vials = $('#vials legend').length;
    $('#addvial').click(function () {
        vials++;

        var form = ['<legend>Vial ' + vials + '</legend>',
            '<div class="row">',
            '<div class="span2">',
            '<label>Vial ID</label>',
            '<div id=""><input type="text" onblur="" style="width:120px;" name="vial[' + vials + '][VIAL_ID]" maxlength="10" value=""></div>',
            '</div>',
            '<div class="span3">',
            '<label>Vial Storage location</label>',
            '<div id=""><input type="text" onblur="" name="vial[' + vials + '][VIAL_STOR_LOC]" maxlength="20" value=""></div>',
            '</div>',
            '<div class="span3">',
            '<label>Growth Temperature</label>',
            '<div id=""><input type="text" onblur="" name="vial[' + vials + '][VIAL_GROWTH_TEMP]" maxlength="20" value=""></div>',
            '</div>',
            '</div>',
            '<div class="row">',
            '<div class="span9">',
            '<label>Growth Type</label>',
            '<div id=""><input type="text" onblur="" style="width:686px;" name="vial[' + vials + '][VIAL_GROWTH_TYPE]" maxlength="60" value=""></div>',
            '</div>',
            '</div>',
            '<div class="row">',
            '<div class="span9">',
            '<label>Vial Notes</label>',
            '<textarea rows="1" name="vial[' + vials + '][VIAL_NOTES]" style=" width: 686px; resize:vertical;"></textarea>',
            '</div>',
            '</div>'
        ].join('\n');

        $('#vials').append(form);
    });

    var dnarna = $('#dnarna legend').length;
    $('#adddnarna').click(function () {
        dnarna++;

        var form = ['<legend>Genetic Information ' + dnarna + '</legend>',
            '<div class="row">',
            '<div class="span" style="width: 260px;">',
            '<label>Identification Number</label>',
            '<div id=""><input type="text" onblur="" name="dnarna[' + dnarna + '][DNARNA_ID]" maxlength="10" value=""></div>',
            '</div>',
            '<div class="span1">',
            '<div class="row">',
            '<label class="radio inline">',
            '<input type="radio" name="dnarna[' + dnarna + '][DNARNA_TYPE]" id="optionsRadios1" value="DNA" checked>',
            'DNA',
            '</label>',
            '</div>',
            '<div class="row">',
            '<label class="radio inline">',
            '<input type="radio" name="dnarna[' + dnarna + '][DNARNA_TYPE]" id="optionsRadios2" value="RNA" >',
            'RNA',
            '</label>',
            '</div>',
            '</div>',
            '<div class="span" style="width:330px;" >',
            '<label>Gen Bank Number</label>',
            '<div id=""><input type="text" onblur="" style="width:325px;" maxlength="40" name="dnarna[' + dnarna + '][DNARNA_GBANKNUM]" value=""></div>',
            '</div>',
            '</div>	',

            '<div class="row">',
            '<div class="span3">',
            '<label>Date of Extraction</label>',
            '<div id=""><input type="text" onblur="" maxlength="10" name="dnarna[' + dnarna + '][DNARNA_DATE]" placeholder="YYYY-MM-DD" value=""></div>',
            '</div>',
            '<div class="span3">',
            '<label>Volume of Solution</label>',
            '<div id=""><input type="text" onblur="" maxlength="10" name="dnarna[' + dnarna + '][DNARNA_VOL]" value=""></div>',
            '</div>	',
            '<div class="span3">',
            '<label>Concentration of Solution</label>',
            '<div id=""><input type="text" onblur="" maxlength="10" name="dnarna[' + dnarna + '][DNARNA_CONC]" value=""></div>',
            '</div>',
            '</div>',
            '<div class="row">',
            '<div class="span9">',
            '<label>Comments</label>',
            '<div id=""><textarea rows="1" name="dnarna[' + dnarna + '][DNARNA_NOTES]" style="width: 686px; resize:vertical;"></textarea></div>',
            '</div>',
            '</div>',

            '<div class="row">',
            '<div class="span">',
            '<label>Image description</label>',
            '<div id=""><input type="text" onblur="" name="dnarna[' + dnarna + '][DNARNA_IMG_CAP]" maxlength="20"  style="width:160px;" value=""></div>',
            '</div>',
            '<div class="span">',
            '<label for="file">File:</label>',
            '<div id=""><input type="file" name="dnarna[' + dnarna + '][DNARNA_IMG_PATH]" id=""><br></div>',
            '</div>',
            '</div>'
        ].join('\n');

        $('#dnarna').append(form);
    });


    //Form submission ----------------------------------------------
    $('#submitCulture').click(function () {
        $('#message').empty();
        var data = $('#createForm').serializeArray();
        $('#message').load('/culture/do_create', data);
    });

    $('#submitSample').click(function () {
        $('#message').empty();
        var data = $('#createForm').serializeArray();
        $('#message').load('/sample/do_create', data);
    });

    $('#editCulture').click(function () {
        $('#message').empty();
        var data = $('#createForm').serializeArray();
        $('#message').load('/culture/do_edit/', data);
    });

    $('#editSample').click(function () {
        $('#message').empty();
        var data = $('#createForm').serializeArray();
        $('#message').load('/sample/do_edit/', data);
    });

    $('#submitLogin').click(function () {
        $('#message').empty();
        var data = $('#loginForm').serializeArray();
        $('#message').load('/login/do_login', data);
    });

    $('#submitUserLogin').click(function () {
        $('#message').empty();
        var data = $('#userForm').serializeArray();
        $('#usermgmt').modal('hide');
        $('#message').load('/login/do_login', data);
    });


    //Export/Import ------------------------------------------------
    $('#startexport').click(function () {
        var href = window.location.pathname;
        href = href.split('/');

        var data = $('#projectform').serialize();
        $.ajax({
            url: '/' + href[1] + '/do_export',
            data: data,
            type: 'POST',
            success: function (html) {
                $('.log').append(html);
                var textarea = document.getElementById('log');
                textarea.scrollTop = textarea.scrollHeight;
            }
        });

    });

    $('#startimport').click(function() {
        var href = window.location.pathname;
        href = href.split('/');

        var data = new FormData();
        jQuery.each($('#userfile')[0].files, function(i, file) {
            data.append('file-' + i, file);
        });

        $.ajax({
            url: '/' + href[1] + '/do_import',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(html) {
                $('.log').append(html);
                var textarea = document.getElementById('log');
                textarea.scrollTop = textarea.scrollHeight;
            }
        });
    });

    //User Management ----------------------------------------------
    $("#clear-btn").click(function () {
        $("#userbox").load("/user/create");
    });

});


//Functions ========================================================


//Search ----------------------------------------------------------

function highlightCell(row) {
    $(".highlight").removeClass("highlight");
    $(row).addClass("highlight");
    var href = window.location.pathname;
    href = href.split('/');
    var a = document.getElementById('view');
    a.href = "/" + $.trim(href[1]) + "/view/" + row.id;
    $("#view").removeClass('disabled');
    $("#view").addClass('btn-main');
}


//User Management -------------------------------------------------

function selectUser(row) {
    $(".highlight").removeClass("highlight");
    $(row).addClass("highlight");
    id = $(row).attr('id');
    $("#userbox").load("/user/update/" + id);
}

function clearForm() {
    $("#userbox").load('/user/create');
}

function clearFeedback() {
    $("#userfeedback").empty();
}

function createUser() {
    clearFeedback();
    var data = $("form").serializeArray();

    $("#userfeedback").load("/user/do_create", data, function () {
        $("#userTable").load("/user/listUsers");
    });
}

function updateUser() {
    clearFeedback();
    var data = $("form").serializeArray();

    $("#userfeedback").load("/user/do_update", data);
    $("#userTable").load("/user/listUsers");
}

function deleteUser() {
    clearFeedback();
    var id = $('.highlight').attr('id');
    $("#userfeedback").load("/user/do_delete/" + id, function () {
        $("#userTable").load("/user/listUsers");
    });
    clearForm();
}