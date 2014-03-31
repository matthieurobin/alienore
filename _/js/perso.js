/**
 * 
 * Shortcuts
 */
//new link
key('n', function() {
    $('#a-new-link').click();
    return false;
});
key('e', function() {
    $('#a-edit-tag').click();
    return false;
});
function duplicatePaging() {
    html = $('.paging:first').html();
    $('.paging').eq(1).html(html);
}

/**
 * reset a form
 * @param {object} form
 * @returns {undefined}
 */
function reset(form) {
    $('#form-new-link').find(':input').each(function() {
        switch (this.type) {
            case 'password':
            case 'select-multiple':
            case 'select-one':
            case 'text':
            case 'textarea':
                $(this).val('');
                break;
            case 'checkbox':
            case 'radio':
                this.checked = false;
        }
    });
}

/*
 * @param {String} id
 */
function editLink(id, languageEdit) {
    var _url = '?c=links&a=data_form&id=' + id;
    $.ajax({
        type: 'GET',
        url: _url,
        success: function(resp) {
            $('#modal-new-link-title').text(languageEdit);
            var _res = JSON.parse(resp);
            $('#input-title').val(_res.link.title);
            $('#input-url').val(_res.link.url);
            $('#input-description').val(_res.link.description);
            $('#input-linkid').val(_res.link.id);
            var _tags = [];
            for(_i = 0; _i < _res.tags.length; ++_i){
                _tags.push( _res.tags[_i].label);
            }
            $('#input-tags').val(_tags.join(' '));
            $('#modal-new-link').modal('show');
        },
        error: function() {

        }
    });
}

function savedLink(id, unsavedText, saveText) {
    var _url = '?c=links&a=data_savedLink&id=' + id;
    $.ajax({
        type: 'GET',
        url: _url,
        success: function(resp) {
            var _res = JSON.parse(resp);
            if (!_res.error) {
                if (_res.link.saved) {
                    anteriorValue = $('#title-' + _res.link.linkdate).html();
                    $('#title-' + _res.link.linkdate).html('<a href="?c=savedlink&a=display&linkdate=' +
                            _res.link.linkdate + '"><span class="glyphicon glyphicon-new-window saved-link"></span></a>' +
                            anteriorValue);
                    $('#save-' + _res.link.linkdate).html(unsavedText);
                    $('#link-' + _res.link.linkdate).prepend($('<div class="box-alert"></div>').html(_res.helper).delay(2200).fadeOut(400));
                } else {
                    $('#title-' + _res.link.linkdate).html('<a href="' + _res.link.url + '">' + _res.link.title + '</a>');
                    $('#save-' + _res.link.linkdate).html(saveText);
                    $('#link-' + _res.link.linkdate).prepend($('<div class="box-alert"></div>').html(_res.helper).delay(2200).fadeOut(400));
                }
            } else {
                $('#link-' + _res.link.linkdate).prepend($('<div class="box-alert"></div>').html(_res.helper).delay(2200).fadeOut(400));
            }
        },
        error: function() {

        }
    });
}

// displayTags
/*
$('#input-tags').bind('input', function() {
    if ($('#input-tags').val().length >= 3) {
        var _url = '?c=tags&a=data_searchTag&search=' + $('#input-tags').val();
        $.ajax({
            type: 'GET',
            url: _url,
            success: function(resp) {
                var _res = JSON.parse(resp);
                $('#datalist-tags').html("");
                for (var _i = 0; _i < _res.length; ++_i) {
                    $('#datalist-tags').append('<option id="' + _res[_i].id + '" value="' + _res[_i].label + '">');
                }
            },
            error: function() {

            }
        });
    }

});*/
