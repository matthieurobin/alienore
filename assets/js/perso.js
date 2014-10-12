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
    $(form).find(':input').each(function() {
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
 * permit to focus the input when we try to click on the search-bar
 */
$('#search-bar').on('click', function(){
    $('#input-search').focus();
});
