jQuery.each($('.item-name'), function() {
	var l = $(this);
	$.getJSON("http://eu.battle.net/api/wow/recipe/" + $(this).html() + "?locale=fr_FR&jsonp=?", function(data) {
		l.html(data.name);
	});
});
