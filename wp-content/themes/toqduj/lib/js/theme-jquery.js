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
});

    jQuery(document).ready(function($) {    
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
function stripos(f_haystack, f_needle, f_offset) {
  //  discuss at: http://phpjs.org/functions/stripos/
  // original by: Martijn Wieringa
  //  revised by: Onno Marsman
  //   example 1: stripos('ABC', 'a');
  //   returns 1: 0

  var haystack = (f_haystack + '')
    .toLowerCase();
  var needle = (f_needle + '')
    .toLowerCase();
  var index = 0;

  if ((index = haystack.indexOf(needle, f_offset)) !== -1) {
    return index;
  }
  return false;
}