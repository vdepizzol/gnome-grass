/* Install section */

$(function() {

    $('#container .project .install .options a').click(function(e) {
        e.preventDefault();
        
        $('#container .project .install .options li').removeClass('active');
        $(this).parent().addClass('active');
        
        $('#container .project .install .explanation div').removeClass('active').hide();
        $('#container .project .install .explanation div' + $(this).attr('href')).addClass('active').hide().fadeIn();
        
    });
    
});


/* Screenshots */

function screenshots_initCallback(carousel) {
    
    $('#container .project .screenshots .prev').click(function(e) {
        e.preventDefault();
        carousel.prev();
    });

    $('#container .project .screenshots .next').click(function() {
        carousel.next();
        return false;
    });
    
}

$(function() {
        
    if($('#container .project .screenshots > div > ul li').length > 3) {
        $('#container .project .screenshots > div > ul').jcarousel({
            initCallback: screenshots_initCallback,
            buttonNextHTML: null,
            buttonPrevHTML: null,
            wrap: 'none'
        });
    }
});
