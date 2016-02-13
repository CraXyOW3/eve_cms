$(document).ready(function() {
	$(".ld").click(function () {
		$('#loadingpage').fadeIn(100);
		return true;
	});
	$(window).bind("load", function(){  
		$('#loadingpage').fadeOut(300);
	});  
});
$(function() {
	$('#chartip *').tooltip();
	$('a#opener').click(function(e) {
	e.preventDefault();
		$( "#dialog-confirm" ).dialog('option', 'anchor', $(this).attr('href'));
		$( "#dialog-confirm" ).dialog( "open" );
		return false;
	});
	$( "#dialog-confirm" ).dialog({
		autoOpen: false,
		resizable: false,
		height:140,
		modal: true,
		buttons: {
			"Delete": function(event) {
				$(location).attr('href',$(this).dialog('option', 'anchor'));
				$( this ).dialog( "close" );
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	$( "input:submit, input:button").button().click(function () {$('#loadingpage').fadeIn()});
	var icons = {
		header: "ui-icon-circle-arrow-e",
		headerSelected: "ui-icon-circle-arrow-s"
	};
	$( "#accordion" ).accordion({
		autoHeight: false,
		icons: icons
	});
	$( "#toggle" ).button().toggle(function() {
		$( "#accordion" ).accordion( "option", "icons", false );
	}, function() {
		$( "#accordion" ).accordion( "option", "icons", icons );
	});
	$( "button#insert").button({
		icons: {
			primary: "ui-icon-disk"
		},
		text: true
	}).click(function () {$('#loadingpage').fadeIn()});
	$( "#check" ).button();
	$( "a", ".del").button({
		icons: {
			primary: "ui-icon-trash"
		},
		text: true
	});
	$( "a", ".add").button({
		icons: {
			primary: "ui-icon-pencil"
		},
		text: true
	});
	$( "a", ".edit").button({
		icons: {
			primary: "ui-icon-pencil"
		},
		text: true
	}).click(function () {$('#loadingpage').fadeIn()});
	$('#inp *').tooltip();
});