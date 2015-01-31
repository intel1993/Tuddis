class Header
	constructor: ->
		@mode = null
		@saved_mode = null
		@is_setup = $.Deferred()

		@is_setup.promise()

	setup: ( responsive = false ) ->
		if not responsive
			mode = 'regular'
		else
			mode = 'responsive'
		
		@_set( mode )
		@mode = mode
		@is_setup.resolve()


	is_tmp: ->
		(@saved_mode isnt null)

	is_visible: ->
		(not @is_tmp() and @mode is 'regular')

	show: =>
		return if @mode is 'regular'
		$$('#header').addClass("is-visible")		
	
	hide: =>
		return if @mode is 'regular'
		$$('#header').removeClass("is-visible")

	reset: ->
		# We don't have an actual "Previous State"
		return if @mode is null
		return if not @is_tmp()
		return if @mode is @saved_mode
		
		@mode = @saved_mode
		@saved_mode = null
		@_set( @mode )

	_set: ( mode ) ->
		# Don't overwrite the mode if there is a saved mode
		# Saved mode means that something is temoprary going on
		# and is going to take care of resetting everything to normal
		if @is_tmp()
			return false

	
		if mode is 'regular'
			$$("html")
				.addClass('header--regular')
				.removeClass('header--toggleable')
		
		if mode is 'responsive'
			$$("html")
				.removeClass('header--regular')
				.addClass('header--toggleable')

		return this		


	set_to: ( mode = 'regular', temporary = false ) ->

		# We're not shooting blanks here
		return if mode is @mode
		
		if @is_tmp()
			return false
		
		$.when( @is_setup ).then =>
			# Set the mode
			@_set(mode)

			# Save the state
			# Unless it's temporary
			if temporary
				@saved_mode = @mode
			
			@mode = mode

			return

		return this
