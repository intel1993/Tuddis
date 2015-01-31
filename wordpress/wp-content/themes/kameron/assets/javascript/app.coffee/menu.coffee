$$('#main-menu').on "click", "a", ->
	
	$el = $(this)
	href = $el.attr('href')

	return if not href or href is '#'

	$$('#main-menu .menu-item')
		.removeClass('current-menu-item')
	
	$(this)
		.closest('.menu-item')
		.addClass('current-menu-item')


$$(window).on "stage/complete", ->
	href = window.location.href

	if $('#main-menu .current-menu-item a').attr('href') isnt href	
				
		# Some Regex for your Bunghole
		rpat = /[^a-zA-Z0-9]/g
		flat_href = href.replace(rpat, '')

		# Find me that current item
		$$('#main-menu .menu-item')
			.removeClass('current-menu-item')
			.find('a')
			.filter( -> ( this.href.replace(rpat, '') is flat_href )  )
			.closest('.menu-item')
			.addClass('current-menu-item')

