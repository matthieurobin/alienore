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
 * get the links for the search
 * @param  {int} page
 * @param  {string} search    
*/
function getSearch(page, search){
    $.ajax({
        type: 'GET',
        url: '?c=links&a=data_search&search=' + search + '&page=' + _currentPage,
        success: function(resp) {
            var _res = JSON.parse(resp);
            _lastLimit = _res.nbPages;
            displayLinks(_res.links, _res.token);
            _lastSearch = search;
        },
        error: function() {

        }
    });
}


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
/*
//lorsque on soumet le formulaire pour effectuer une recherche
$('#form-search').on('submit', function(){
    var $this = $(this);
    if($('#input-search').val().length > 2){
        $.ajax({
            url: $this.attr('action'), 
            type: $this.attr('method'), 
            data: $this.serialize(), 
            success: function(resp) { 
                var _res = JSON.parse(resp);
                //réinitialiser la liste
                $('#list').html('');
                _currentPage = 1;
                _lastLimit = _res.nbPages;
                //on actualise le nombre de liens
                $('#nbLinks-count').text(_res.nbLinks);   
                //si il y a des liens 
                if(_res.nbLinks > 0){
                    //on affiche les liens
                    displayLinks(_res.links, _res.token);
                    $('.paging').removeClass('no-display');      
                    //sinon on affiche un message
                }else{
                    if(!$('#empty-result').length){
                        $('#list').append('<li id="empty-result">Nothing found</li>');
                    }else{
                        $('#empty-result').text('Nothing found');
                    }
                    if(!$('.paging').hasClass('no-display')){
                        $('.paging').addClass('no-display');
                    }
                }
                
                $('#tags-list-ul li').removeClass('tags-active');  
                _lastSearch = _res.search;
                //on reset la search-bar
                resetSearchBar();
                //on affiche la recherche dans la search-bar
                var _tag = '<span class="glyphicon glyphicon-search"></span> ' + _res.search + 
                        ' <a href="#" onclick="getLinks(1)"><span class="glyphicon glyphicon-remove"></span></a>';
                $('#search-bar-tag').html(_tag);
            },
            error: function() {
                
            }
        });
    }else{
        showAlert('You must search a term with more than 2 characters', 'modal-helper-red');
    }
    return false;
});*/