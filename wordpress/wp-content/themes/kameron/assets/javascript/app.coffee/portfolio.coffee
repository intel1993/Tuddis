# Respond to clicks anywhere on the image
$$('#content').on 'click', '.pfentry__image', ->
	url = $(this)
			.closest('.js__hscol')
			.find( '.js__link' )
			.attr('href')

	if url?
		$.pronto('load', url)


return unless App.config.portfolio.has_desc

ENABLE_HOVER = ( not Modernizr.touch and App.config.portfolio.detect_hover )

info_box =
	open: ( $container ) ->
		return if App.is.responsive
		$container
			.addClass('display--desc')
			.removeClass('display--image')
			

		$container.find('.js__open').stop().fadeOut()
	
	close: ( $container ) ->
		return if App.is.responsive
		$container
			.removeClass('display--desc')
			.addClass('display--image')

		$container.find('.js__open').stop().fadeIn()

# //-----------------------------------*/
# // Click Events
# //-----------------------------------*/
$$('#content').on 'click', '.js__hscol .js__open, .js__hscol .js__close', ->
	return if App.is.responsive
	$el = $(this)
	$container = $el.closest('.js__hscol')

	if $el.hasClass('js__open')
		
		$container.addClass("js__clicklock") if ENABLE_HOVER
		info_box.open( $container )
	
	if $el.hasClass('js__close')
		
		$container.removeClass("js__clicklock") if ENABLE_HOVER
		info_box.close( $container )

	return

# //-----------------------------------*/
# // Hover Events
# //-----------------------------------*/
if ENABLE_HOVER
	$$('#page').hoverIntent
		selector: '.js__pfentry'
		timeout: 175
		interval: 50
		sensitivity: 6
		over: ->
			$container = $(this)
			info_box.open $container

		out: ->
			$container = $(this)
			return if $container.hasClass("js__clicklock")
			info_box.close $container
