/**
 * 
 * Shortcuts
 */
//new link
key('n', function() {
    $('#a-new-link').click();
    return false
});
key('e', function() {
    $('#a-edit-tag').click();
    return false
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
            $('#input-title').val(_res.title);
            $('#input-url').val(_res.url);
            $('#input-description').val(_res.description);
            $('#input-tags').val(_res.tags);
            $('#input-linkdate').val(_res.linkdate);
            $('#input-saved').val(_res.saved);
            $('#input-datesaved').val(_res.datesaved);
            $('#modal-new-link').modal('show');
        },
        error: function() {

        }
    });
}

function savedLink(id,unsavedText,saveText){
    var _url = '?c=links&a=data_savedLink&id=' + id;
    $.ajax({
        type: 'GET',
        url: _url,
        success: function(resp) {
            var _res = JSON.parse(resp);
            if(_res.link.saved){
                anteriorValue = $('#title-' + _res.link.linkdate).html();
                 $('#title-' + _res.link.linkdate).html( '<a href="?c=savedlink&a=display&linkdate=' + 
                         _res.link.linkdate + '"><span class="glyphicon glyphicon-new-window saved-link"></span></a>' +
                         anteriorValue);
                 $('#save-' + _res.link.linkdate).html(unsavedText);
            }else{
                $('#title-' + _res.link.linkdate).html('<a href="'+_res.link.url+'">'+_res.link.title+'</a>');
                $('#save-' + _res.link.linkdate).html(saveText);
            }
        },
        error: function() {

        }
    });
}

