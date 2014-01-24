function duplicatePaging(){
    
    html = $('.paging:first').html();
    $('.paging').eq(1).html(html);
}

