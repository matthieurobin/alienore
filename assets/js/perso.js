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
 * get link information and show modal
 * @param  {int} id
 * @param  {string} languageEdit : modal's title
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
            for (_i = 0; _i < _res.tags.length; ++_i) {
                $('#tagBox').tagging("add", _res.tags[_i].label);
            }
            $('#modal-new-link').modal('show');
        },
        error: function() {

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

/**
 * reset the search bar
 */
function resetSearchBar(){
    $('#search-bar-tag').html('');
    $('#input-search').val('');
}

/* ============================================= */
/*                                               */
/*              Page actualisation               */
/*                                               */
/* ============================================= */

var _lastTag = undefined;
var _currentPage = 1;
var _lastLimit = 1;
var _lastSearch = '';

/*
 get the next links from all, tag, search
 */
function nextPage() {
    _currentPage += 1;
    if (_currentPage > _lastLimit) {
        $('.paging').addClass('no-display');
    } else {
        switch ($('.paging a').data('pagination')) {
            case 'default':
                getLinks(_currentPage);
                break;
            case 'tag':
                getLinksByTag(_lastTag);
                break;
            case 'search':
                getSearch(_lastSearch);
                break;
        }
    }
}

/*
 * Get all the links for the next page
 * @param {int} page  
 */
function getLinks(page) {
    //si c'est la première page
    if(page === 1){
        _currentPage = 1;
        //on rénitialise le container contenant les liens
        $('#list').html('');
        //on reset la barre de recherche
        resetSearchBar();
        //on reset le tag actif
        $('#tags-list-ul li').removeClass('tags-active');
        //prévenir d'un bug : si on ne réinitialise pas cette variable, le tag ne s'affichera pas dans la search-bar
        _lastTag = undefined;
        if(!$('#edit-tag').hasClass('no-display')){
            $('#edit-tag').addClass('no-display');
        }
    }
    $.ajax({
        type: 'GET',
        url: '?c=links&a=data_all&page=' + page,
        success: function(resp) {
            var _res = JSON.parse(resp);
            _lastLimit = _res.nbPages;
            displayLinks(_res.links, _res.token);
            //on change le nb de liens
            $('#nbLinks-count').text(_res.nbLinks);
        },
        error: function() {

        }
    });
}

/*
 * get the links identified by the tag
 * @param  {int} id  
 */
function getLinksByTag(id) {
    if (_lastTag !== id){
        if (_lastTag !== id || _lastLimit == _currentPage) {
            _currentPage = 1;
            //on rénitialise le container
            $('#list').html('');
            //we load the edit form
            $.ajax({
                type: 'GET',
                url: '?c=tags&a=data_form&tagId=' + id,
                success: function(resp) {
                    var _res = JSON.parse(resp);
                    $("#input-tag-title").val(_res.label);
                    $("#input-tag-id").val(_res.id);
                    if($('#edit-tag').hasClass('no-display')){
                        $('#edit-tag').removeClass('no-display');
                    }       
                    //on affiche le tag dans la search-bar
                    var _tag = '<span class="glyphicon glyphicon-tag"></span> ' + _res.label + 
                            ' <a href="#" onclick="getLinks(1)"><span class="glyphicon glyphicon-remove"></span></a>';
                    $('#search-bar-tag').html(_tag);
                },
                error: function() {
                    
                }
            });
        }
        _lastTag = id;
        $('#tags-list-ul li').removeClass('tags-active');
        $('.paging').removeClass('no-display');
        $('#tag-' + id).addClass('tags-active');
        $.ajax({
            type: 'GET',
            url: '?c=links&a=data_getLinksByTag&tagId=' + id,
            success: function(resp) {
                var _res = JSON.parse(resp);
                _lastLimit = _res.nbPages;
                displayLinks(_res.links, _res.token);
                //on change le nb de liens
                $('#nbLinks-count').text(_res.nbLinks);
            },
            error: function() {

            }
        });
    }
}

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
    add/replace the links to DOM
    @param {array} links 
    @param {string} tokenuser
    @param {boolean} isAppend : switch between .append/.prepend
    @param {boolean} isReplace : switch between append/prepend or replace the html in the <li>
 */
function displayLinks(links, tokenUser, isAppend, isReplace) {
    if(isAppend === undefined) isAppend = true;
    if(isReplace === undefined) isReplace = false;
    var _nbLinks = links.length;
    $('.loading').removeClass('no-display');
    if (_currentPage == 1){
        $('#list').hide();
    }
    for (var _i = 0; _i < _nbLinks; ++_i) {
        var _link = links[_i].link;
        var _tags = links[_i].tags;
        var _res = '<div class="link">' +
                '<div class="link-tools">' +
                '<button type="button" class="btn btn-warning" onclick="editLink(' + _link.id + ', \'EditLink\' )">' +
                '<span class="glyphicon glyphicon-pencil"></span>' +
                '</button> ' +
                '<button type="button" class="btn btn-danger" onclick="deleteLink(' + _link.id + ',\'' + tokenUser + '\')">' +
                '<span class="glyphicon glyphicon-trash"></span>' +
                '</button>' +
                '</div>' +
                '<h4 id="title-' + _link.id + '">' +
                '<img src="http://www.google.com/s2/favicons?domain=' + _link.url + '" />' + 
                '<a href="' + _link.url + '" target="_blank"> ' + _link.title + ' </a>' +
                '</h4>' +
                '<p class="link-description-second">' +
                '<small>' + _link.linkdate + '</small> - ' +
                '<a href=' + _link.url + ' target="_blank">' + _link.title + '</a>' +
                '</p>' +
                '<p class="link-description">' + _link.description + '</p>' +
                '<div class="tags">';
        if (_tags.length > 0) {
            for (var _j = 0; _j < _tags.length; ++_j) {
                var _tag = _tags[_j];
                _res += '<div class="tag tag-list">' +
                        '<a class="a-tag pointer" onclick="getLinksByTag(' + _tag.id + ')"><span>#</span>' + _tag.label + '</a></span>' +
                        '</div>';
            }
        }
        _res += '</div>' +
                '</div>';
        if(!isReplace){
            if(isAppend){
                $('#list').append($('<li id="link-' + _link.id + '">' + _res + '</li>'));
            }else{
                $('#list').prepend($('<li id="link-' + _link.id + '">' + _res + '</li>'));
            }  
        }else{
            $('#link-' + _link.id).html(_res);
        }
    }
    $('.loading').addClass('no-display');
    if (_currentPage == 1){
        $('#list').slideDown(525);
    }
}

/**
 * delete link by ajax and remove it from dom
 * @param  {int} id : link id
 * @param  {string} tokenUser : token to prevent CSRF attack
 */
function deleteLink(id,tokenUser){
    $.ajax({
        type: 'GET',
        url: '?c=links&a=data_delete&t=' + tokenUser + '&id=' + id,
        success: function(resp) {
            var _res = JSON.parse(resp);
            $('#link-' + id).fadeOut(400, function(){
                $(this).remove();
                showAlert('The link was successfully deleted', 'modal-helper-green');
            });
            updateTag(_res.tags);
        },
        error: function() {
            
        }
    });
}

/*
  * update the nb of links for a tag in the tags list 
  * @param {array} array of tags
*/
function updateTag(tags){
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
    if(tags.new != undefined && tags.new.length > 0){
        for(var _i = 0; _i < tags.new.length ; ++_i){
            var _res = '<a onclick="getLinksByTag(' + tags.new[_i].id + ')">' +
                '<li id="tag-' + tags.new[_i].id + '">' +
                '<span class="tag-label">' +
                '<span class="glyphicon glyphicon-tag"></span> ' + tags.new[_i].label + '</span>' +
                '<span class="tag-nb-links" data-nb-links="' + 1 + '">' + 1 + '</span>'
                '</li>' + 
                '</a>';
            $('#tags-list-ul .mCSB_container').prepend($(_res));
        }
        $('#tags-list .mCSB_container').mCustomScrollbar('update');
    }
}

//lorsque on soumet le formulaire pour new/edit lien
/*$('#form-link').on('submit', function(){
    var $this = $(this);
    $.ajax({
        url: $this.attr('action'), 
        type: $this.attr('method'), 
        data: $this.serialize(), 
        success: function(resp) { 
            $('#modal-new-link').modal('hide');
            var _res = JSON.parse(resp);
            var _link = _res.link;
            var _tags = _res.tags;
            //si c'est une édition du lien
            if(_res.isEdit){
                var _idLink = _link.id;
                var _linkToDisplay = {
                    'link' : _link,
                    'tags' : _res.tags.default.concat(_res.tags.added.concat(_res.tags.new))
                };
                displayLinks([_linkToDisplay], _res.token, false, true);
                //actualisation du nombre de liens pour les tags ajoutés et/ou supprimés
                updateTag(_tags);

                showAlert('The link was successfully updated', 'modal-helper-green');
            //sinon un nouveau lien
            }else{
                //ajout du lien dans le dom
                var _linkToDisplay = {
                    'link' : _link,
                    'tags' : _res.tags.added
                };
                displayLinks([_linkToDisplay], _res.token, false);
                //reset du formulaire
                reset();
                resetTagBox();
                //actualisation du nombre de liens
                var _nbLinks = parseInt($('#nbLinks-count').text()) + 1;
                $('#nbLinks-count').text(_nbLinks); 
                //actualisation du nombre de liens pour les tags ajoutés et/ou supprimés
                updateTag(_tags);
                showAlert('The link was successfully added', 'modal-helper-green');
            }
        },
        error: function() {
            
        }
    });
    return false;
});*/


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
});