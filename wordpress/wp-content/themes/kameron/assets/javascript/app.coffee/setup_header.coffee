App.Header = new Header()

# $$(document).on "theme/responsive", (e, responsive) ->
# 	App.Header.setup( responsive )


$$('#header-toggle').hoverIntent
	over: App.Header.show
	out: App.Header.hide
	timeout: 200
	interval: 50

$$('#header-toggle .js__toggle').click ->
	$$('#header').toggleClass('is-visible')

$$(window).on "pronto.request", ->
	if Modernizr.touch and not App.Header.is_tmp()
		App.Header.hide()
		
	unless App.is.responsive
		$$('#header__background').animate {
				'background-position-y': 0
				'background-position-x': 0
			}, 1200, 'easeInQuad'


