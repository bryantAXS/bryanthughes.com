$(document).ready(function()
{
	$('#add_url').click(function() 
	{
		var url_count = $('table.sitemap tbody.urls tr').length;

		// create new url as clone
		var new_url = $('table.sitemap tbody.urls tr.clone').clone().attr('class', 'url');
		
		// swap out names
		$(new_url).find('input, select').each(function() {
			$(this).attr('name', 'urls[' + url_count + '][' + $(this).attr('name') + ']');
		});

		// add delete click event
		$(new_url).find('a.delete').click(function() {
			$(this).closest('tr').remove();
			return false;
		});

		$('table.sitemap tbody.urls').append(new_url);

		return false;
	});

	// add delete click event
	$('a.delete').click(function() 
	{
		$(this).closest('tr').remove();
		return false;
	});
});