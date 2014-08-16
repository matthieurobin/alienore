/**
 * show a notification
 * @param  {string} message  
 * @param  {string} classCss : name of the class css (color)
 */
function showAlert(message, classCss){
    $('#modal-helper').removeClass().addClass(classCss);
    $('#modal-helper').text(message);
    $('#modal-helper').fadeIn(150, function(){
        $(this).delay(2500).fadeOut();
    });
}

/**
 * reset a form
 * @param {object} form
 * @returns {undefined}
 */
function reset(form) {
    $('#form-link').find(':input').each(function() {
        switch (this.type) {
            case 'password':
            case 'select-multiple':
            case 'select-one':
            case 'text':
                $(this).val('');
                break;
            case 'textarea':
                $(this).val('');
                break;
            case 'checkbox':
            case 'radio':
                this.checked = false;
            case 'url' :
                $(this).val('');
                break;
            case 'hidden':
                $(this).val('');
                break;
        }
    });
}

/**
 * reset the tagbox in new/edit link form
 */
function resetTagBox() {
    $('#tagBox').tagging('reset');
    $('#datalist-tags').html('');
}

/**
 * instant search
 */
$(':input[class=type-zone]').eq(0).keyup('input', function() {
    $(':input[class=type-zone]').eq(0).attr('list', 'datalist-tags');
    if ($(':input[class=type-zone]').eq(0).val().length >= 3) {
        var _url = '?c=tags&a=data_searchTag&search=' + $('#tagBox .type-zone').val();
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

});

/**
 * permit to focus the input when we try to click on the search-bar
 */
$('#search-bar').on('click', function(){
    $('#input-search').focus();
});

/*
  * update the nb of links for a tag in the tags list 
  * @param {array} array of tags
*/
function updateTags(tags){
    if(tags.added != undefined && tags.added.length > 0){
        for(var _i = 0; _i < tags.added.length; ++_i){
            var _tag = '#tag-' + tags.added[_i].id;
            var _nbTag = parseInt($(_tag + ' span.tag-nb-links').eq(0).data('nb-links'));
            $(_tag + ' span.tag-nb-links').eq(0).text(_nbTag + 1);
            $(_tag + ' span.tag-nb-links').eq(0).data('nb-links',_nbTag + 1);
        }
    }
    if(tags.deleted != undefined && tags.deleted.length > 0){
        for(var _i = 0; _i < tags.deleted.length; ++_i){
            var _tag = '#tag-' + tags.deleted[_i].id;
            var _nbTag = parseInt($(_tag + ' span.tag-nb-links').eq(0).data('nb-links'));
            $(_tag + ' span.tag-nb-links').eq(0).text(_nbTag - 1);
            $(_tag + ' span.tag-nb-links').eq(0).data('nb-links',_nbTag - 1);
        }
    } 
}
