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