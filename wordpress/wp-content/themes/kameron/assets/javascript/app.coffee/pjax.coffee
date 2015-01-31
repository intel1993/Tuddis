return unless window.history.pushState

Stage = new Stage_Handler()
$ajax = new $.Deferred()
$render = new $.Deferred()

# Track the clicked url
clicked_url = false


# //-----------------------------------*/
# // Listeners
# //-----------------------------------*/
# On Request ( on Click )
R = false
$$(window).on "pronto.request", ->
	return if R is true
	R = true
	$ajax = Stage.add_promise()

	Stage.close()
	return

# On Load Complete
$$(window).on "pronto.load", ->
	$ajax.resolve()
	R = false
	return

# Move Manually on Error
$$(window).on "pronto.error", ->
	window.location.href = clicked_url
	return

$$(window).on "pronto.render", ->
	$render.resolve()
	$ajax.resolve()
	# Reset the Clicked URL
	clicked_url = false
	
	return


# This is how we render:
on_render = (data) ->	
	# Promise to render, but only after Pronto is complete
	# Otherwise ge get a bad state saved ( #stage-away, etc. )
	$render = Stage.add_promise()


	$new_stage = Stage.add( data )
	$$('#content').prepend $new_stage

	$.when( $new_stage ).done ->
		data.body_classes.push("loaded")
		$$('body').attr( 'class', data.body_classes.join(" ") )
		$$('head title').text( data.title )


$$(window).on 'stage/complete', ->
	unless App.is.responsive
		App.Scroll.setup $$('#stage')

# //-----------------------------------*/
# // Initialize / Start Pronto
# //-----------------------------------*/
$$('body').on 'click', 'a', ->
	href = $(this).attr('href')
	
	if href? and href isnt ""
		clicked_url = href
	
	return

$$(document).ready ->
	$.pronto
		selector: 'a:not(.no-pjax)'
		requestKey: "pjax",
		force: true
		target:
			title: 'title'
			content: '#content'
		render: on_render


