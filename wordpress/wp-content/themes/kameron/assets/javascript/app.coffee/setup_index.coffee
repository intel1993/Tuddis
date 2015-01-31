return if $$('#fullscreen-gallery').length is 0
return if $$('#enter-site').length is 0

defaults =
	play: App.config.slider.duration
	animation: App.config.slider.animation
	animation_speed: App.config.slider.animation_speed
	animation_easing: App.config.slider.animation_easing
	# inherit_height_from: '.js__bgslide'
	key_navigation: false
	pagination: false

setup_slides = ( refresh = false ) ->
	$slider = $$('#fullscreen-gallery')
							
	slide_config = $.extend {}, defaults, $slider.data("slidesConfig")
	
	$slider.superslides( slide_config )

	if $slider.find('img').length is 1
		$slider.superslides('stop')
	


load_site = _.once ->
	if not Modernizr.cssanimations
		window.location.href = $$('#enter-site').attr('href')
		return

	$$('html').animo
		animation: 'do-fadeOutUp'
		duration: 0.6
		keep: true
		, ->
			window.location.href = $$('#enter-site').attr('href')
			return

# //-----------------------------------*/
# // Events
# //-----------------------------------*/    
$$(document).ready(setup_slides)

if $$('#enter-site').length > 0
	$$(document).one 'click mousewheel scroll', (e) ->
		e.preventDefault()
		load_site()



