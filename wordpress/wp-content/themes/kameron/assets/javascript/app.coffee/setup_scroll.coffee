PARALLAX = 
	x: App.config.on_scroll.x
	y: App.config.on_scroll.y
	speed_x: App.config.on_scroll.speed_x / 100
	speed_y: App.config.on_scroll.speed_y / 100
	container_x: App.config.size.header_width + App.config.size.header_toggle_width
	height: $$('#header__background').data("height")
	width: $$('#header__background').data("width")


get_navalax_pos = ( position, max_position, item_size, container_size, speed_modifier  ) ->
	ratio = ( item_size - container_size ) / max_position * speed_modifier
	return position * -ratio



scroll_settings = 
	enable_parallax: App.config.on_scroll.enable
	force_parallax: App.config.on_scroll.force
	
	callbacks:
		y: ->

			$$('#header__background').css
				"background-position-y": get_navalax_pos( @y, @maxScrollY, PARALLAX.height, App.win.height, PARALLAX.speed_y )

		x: ->
			$$('#header__background').css
				"background-position-x": get_navalax_pos( @x, @maxScrollX, PARALLAX.width, PARALLAX.container_x, PARALLAX.speed_x )



App.Scroll = new Scroll_Handle( scroll_settings )
App.Header_Scroll = new Scroll_Handle
							x: false
							y: 
								keyBindings: false
								snap: false




$$(window).on "load iscroll:refresh debouncedresize", -> 
	App.Scroll.refresh()

$$(window).one 'theme:sizes_setup', (e, responsive) ->
	
	# Only setup iScroll if App isn't responsive
	return if App.is.responsive


	# Pay Attention:
	# window.ONE not window.on
	# $$(window).one "theme:sizes_setup", ->
	App.Scroll.setup( $$('#stage') )
	$$('.js__scroll').scrollTop(0).scrollLeft(0)

	$$(window).on "load hashchange", (e) ->
		return unless window.location.hash
		return if App.Scroll.active.y.length is 0
		
		if $$( window.location.hash ).length
			App.Scroll.active.y[0].scrollToElement( window.location.hash, 0 )
			$$('.js__scroll').scrollTop(0).scrollLeft(0)


# When the switch occurs:
$$(document).on "theme/responsive", ( e, responsive ) ->
	if responsive is true
		App.Scroll.destroy()
	
	# "else" may be undefined
	# We want to be sure "responsive" is FALSE
	if responsive is false
		App.Util.delay 100, ->
			App.Scroll.setup( $$('#stage') )
			return

# Initialize Header scroller
$$(window).one "load", ->
	App.Header_Scroll.setup( $$('#header') )

# When stuff is resized, - refresh iScroll
$$(window).on "theme:sizes_setup", ->
	App.Scroll.refresh()
	App.Header_Scroll.refresh()
