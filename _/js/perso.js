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
    $('#form-new-link').find(':input').each(function() {
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
            for (_i = 0; _i < _res.tags.length; ++_i) {
                $('#tagBox').tagging( "add", _res.tags[_i].label);
            }
            $('#modal-new-link').modal('show');
        },
        error: function() {

        }
    });
}

function resetTagBox() {
    $('#tagBox').tagging('reset');
    $('#datalist-tags').html('');
}

/*function savedLink(id, unsavedText, saveText) {
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
}*/

// displayTags in the input
$(':input[class=type-zone]').eq(0).keyup('input', function() {
    $(':input[class=type-zone]').eq(0).attr('list','datalist-tags');
    if ($(':input[class=type-zone]').eq(0).val().length >= 3) { 
        var _url = '?c=tags&a=data_searchTag&search=' + $('#tagBox .type-zone').val();
        $.ajax({
            type: 'GET',
            url: _url,
            success: function(resp) {
                var _res = JSON.parse(resp);
                console.log(_res);
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



var _lastTag = undefined;
var _currentPage = 1;
var _lastLimit = 1;

/*
    get the next links from all, tag, search
*/
function nextPage(){
    _currentPage += 1;
    if(_currentPage > _lastLimit){
        $('.paging').addClass('no-display');
    }else{
        switch($('.paging a').data('pagination')){
            case 'default':
                getLinks();
                break;
            case 'tag':
                getLinksByTag(_lastTag);
                break;
            case 'search':
                break;
        }
    }
}

/*
    Get all the links for the next page
*/
function getLinks(){
    $.ajax({
            type: 'GET',
            url: '?c=links&a=data_all&page=' + _currentPage,
            success: function(resp) {
                var _res = JSON.parse(resp);
                _lastLimit = _res.nbPages;
                displayLinks(_res.links);
            },
            error: function() {

            }
        });
}

/*
    get the links identified by the tag
*/
function getLinksByTag(id){
    if (_lastTag !== id || _lastLimit == _currentPage){
        $('#list').html(''); 
    } 
    _lastTag = id;
    $('.tags-list-ul li').removeClass('tags-active');
    $('.paging').removeClass('no-display');
    $('#tag-' + id).addClass('tags-active');
    $.ajax({
            type: 'GET',
            url: '?c=links&a=data_getLinksByTag&tagId=' + id,
            success: function(resp) {
                var _res = JSON.parse(resp);
                _lastLimit = _res.nbPages;
                displayLinks(_res.links);
            },
            error: function() {

            }
        });
}

/*
    add the links to DOM
*/
function displayLinks(links){
    var _nbLinks = links.length;
    $('.loading').removeClass('no-display');
    if(_currentPage == 1) $('#list').hide();
    for(var _i = 0; _i < _nbLinks; ++_i){
        var _link = links[_i].link;
        var _tags = links[_i].tags;
        var _res = '<div class="link">' +
        '<div class="link-tools">'+
        '<button type="button" class="btn btn-warning" onclick="editLink(' + _link.id + ', \'EditLink\' )">' +
        '<span class="glyphicon glyphicon-pencil"></span>' +
        '</button> ' + 
        '<button type="button" class="btn btn-danger" onclick="location.href = \'?c=links&a=delete&t={$_SESSION[\'token\']} ?>&id=' +_link.id + ' ?>">' + 
        '<span class="glyphicon glyphicon-trash"></span>' + 
        '</button>' + 
        '</div>' +
        '<h4 id="title-' + _link.id + '">' + 
        '<a href="' + _link.url + '" target="_blank"> ' + _link.title + ' </a>' +
        '</h4>' +
        '<p class="link-description-second">' +
        '<small>' + _link.linkdate + '</small> - ' +
        '<a href=' + _link.url + '" target="_blank">' + _link.title + '</a>' +
        '</p>' +
        '<p class="link-description">' + _link.description + '</p>' +
        '<div class="tags">';
        if(_tags.length > 0){
            for( var _j = 0; _j < _tags.length; ++_j){
                var _tag = _tags[_j];
                _res += '<div class="tag tag-list">' +
                '<a class="a-tag pointer" onclick="getLinksByTag(' + _tag.id + ')"><span>#</span>' + _tag.label + '</a></span>' +
                '</div>';
            }
        }
        _res += '</div>' +
        '</div>';
        $('#list').append($('<li id="link-"' + _link.id + '>' + _res + '</li>'));
    }
    $('.loading').addClass('no-display');
    if(_currentPage == 1) $('#list').slideDown(525);
}