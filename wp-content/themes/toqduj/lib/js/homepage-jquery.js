jQuery(document).ready(function($) {
	var numwidgets = $('.footer-widgets-1 div.widget').length;
	$('.footer-widgets-1').addClass('cols-'+numwidgets);
	//$('.footer-widgets-1 .widget,.footer-widgets-1 .widget .widget-wrap').equalHeightColumns();
	
    $('#hp-callout section.widget.first-child').addClass('col-sm-8');
    $('#hp-callout section.widget.last-child').addClass('col-sm-4');
    $('#homepage-widgets .widgets-left section.widget').addClass('col-sm-4');
});