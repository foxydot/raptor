jQuery(document).ready(function($) {	
	$('ul li:first-child').addClass('first-child');
	$('ul li:last-child').addClass('last-child');
	$('ul li:nth-child(even)').addClass('even');
	$('ul li:nth-child(odd)').addClass('odd');
	$('table tr:first-child').addClass('first-child');
	$('table tr:last-child').addClass('last-child');
	$('table tr:nth-child(even)').addClass('even');
	$('table tr:nth-child(odd)').addClass('odd');
	$('tr td:first-child').addClass('first-child');
	$('tr td:last-child').addClass('last-child');
	$('tr td:nth-child(even)').addClass('even');
	$('tr td:nth-child(odd)').addClass('odd');
    $('div:first-child').addClass('first-child');
    $('div:last-child').addClass('last-child');
    $('div:nth-child(even)').addClass('even');
    $('div:nth-child(odd)').addClass('odd');
    $('section:first-child').addClass('first-child');
    $('section:last-child').addClass('last-child');
    $('section:nth-child(even)').addClass('even');
    $('section:nth-child(odd)').addClass('odd');
   
	
	var numwidgets = $('#footer-widgets div.widget').length;
	$('#footer-widgets').addClass('cols-'+numwidgets);
	
	//font-awesome lists in content
    $('.entry-content ul').not('.entry-content .gform_wrapper ul').addClass('fa-ul').find('li').prepend('<i class="fa-li fa fa-caret-right"></i>');
    $('.sidebar .widget_advanced_menu .menu li li a').prepend('<i class="fa fa-caret-right"></i>');
    
    // add target="_blank" to all *external* 
    //create array of all *internal* urls that should NOT go to a separate window
    var internal_urls = Array('raptorinc.org','www.raptorinc.org','raptor.msdlab2.com','127.0.0.1');
    $('a').attr('target',function(){
        var url = $(this).attr('href');
        var target = $(this).attr('target');
        if(url == '#' || strripos(url,'http',0)===false){
            return '_self';
        } else {
            var i=0;
            while (internal_urls[i]){
                if(strripos(url, internal_urls[i], 0)){
                    return target;
                }
                i++;
            }
            return '_blank';
        }
    });
});

function strripos(haystack, needle, offset) {
  //  discuss at: http://phpjs.org/functions/strripos/
  // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // bugfixed by: Onno Marsman
  // bugfixed by: Brett Zamir (http://brett-zamir.me)
  //    input by: saulius
  //   example 1: strripos('Kevin van Zonneveld', 'E');
  //   returns 1: 16

  haystack = (haystack + '')
    .toLowerCase();
  needle = (needle + '')
    .toLowerCase();

  var i = -1;
  if (offset) {
    i = (haystack + '')
      .slice(offset)
      .lastIndexOf(needle); // strrpos' offset indicates starting point of range till end,
    // while lastIndexOf's optional 2nd argument indicates ending point of range from the beginning
    if (i !== -1) {
      i += offset;
    }
  } else {
    i = (haystack + '')
      .lastIndexOf(needle);
  }
  return i >= 0 ? i : false;
}