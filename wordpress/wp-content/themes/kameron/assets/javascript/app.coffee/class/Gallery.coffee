class Gallery_Handle
    # It's either there or not there
    # Find out only once
    HISTORY_SUPPORT = window.history and window.history.pushState and window.history.replaceState
    CONF = App.config.gallery

    ### 
        Initialize
    ###
    constructor: ( external_view_defaults, @data )->
        
        # Parse Data
        @images = _.map @data, ( i ) ->
            img: i.image
            thumb: i.thumb
            caption: i.caption
            thumbratio: i.thumbwidth / i.thumbheight
            video: i.video

        # No fotorama yet
        @currentID = 0
        @fotorama = false
        @disabled = false

        view_defaults = 
            thumbs: false
            sidebar: false

        cookie_view = $.cookie('village_gallery')
        
        @view = $.extend true, {}, view_defaults, external_view_defaults, cookie_view

        @back_url = CONF.root_url
        
        descriptions = _.filter @data, (obj) -> obj.desc? and obj.desc != ""

        if CONF.thumbnails_overlay
            $$('#gallery').addClass('overlay-thumbs')

        if descriptions.length is 0
            @destroy_sidebar()
        else if @view.sidebar is false
            @hide_sidebar()
            


        # Setup & Init Events
        @attach_events()
        @setup(@images)

    detach_events: ->
        $$('#gallery__stage').off 'fotorama:showend', @set_fotorama_image
        $$('#gallery__stage').off 'fotorama:loadvideo', @disable_addons
        $$('#gallery__stage').off 'fotorama:unloadvideo', @enable_addons
        return
    
    attach_events: ->   
        $$('#gallery__stage').on 'fotorama:showend', @set_fotorama_image
        $$('#gallery__stage').on 'fotorama:loadvideo', @disable_addons
        $$('#gallery__stage').on 'fotorama:unloadvideo', @enable_addons
        return    
        
    
    
    setup: ( images ) ->
        # Setup Fotorama Settings
        fotorama_settings =
            fit: CONF.fit
            transition: CONF.transition

            # Size
            width: App.win.width
            height: if CONF.thumbnails_overlay then App.win.height else "100%"
            
            # Thumbnails
            thumbheight: CONF.thumbnails_height
            nav: if CONF.thumbnails and @view.thumbs is true then "thumbs" else false

            # Autoplay
            autoplay: if CONF.autoplay then CONF.autoplay_duration else false
            stopautoplaytouch: CONF.autoplay_stop
            loop: CONF.loop

            # The actual data
            data: images

        $$('#gallery__stage').fotorama(fotorama_settings)
        @fotorama = $$('#gallery__stage').data('fotorama')

        $$('#gallery').removeClass('init')


        return unless @fotorama

        if @view.thumbs is true
            @show_thumbnails()

        if @view.sidebar is true
            @show_sidebar()


        return this

    close: ( try_force_back = false, previous_url = false ) ->
        if previous_url is false or previous_url is window.location.href
            previous_url = @back_url


        if HISTORY_SUPPORT and ( try_force_back or document.referrer.indexOf( window.location.host ) >= 0 )
            window.history.back()
        else
            $.pronto( 'load', previous_url )
        
        $$(window).one "stage/complete", =>
            @destroy()


    disable_addons: =>
        @disabled = true
        $$('#gallery').addClass('disable-addons')

        return

    enable_addons: =>
        @disabled = false
        $$('#gallery').removeClass('disable-addons')

        return


    destroy: ->
        @detach_events()
        @fotorama.destroy() if @fotorama

        $$('#gallery').remove()

        $$('#gallery__stage', true)
        $$('#gallery__sidebar', true)
        $$('#gallery', true)

    


    ###
        Sidebar Functions
    ###
    destroy_sidebar: ->
        $$('#gallery').addClass('is-full no-sidebar')
        @view.sidebar = false
        @detach_events()

    update_sidebar: ( data ) ->

        return if @view.sidebar is false

        D = [] # Deferreds

        $sidebar = $$('#gallery__sidebar')
        $title = $sidebar.find('.title')
        $desc = $sidebar.find(".desc")

        D.push $title.animate( opacity: 0, 150 )
        D.push $desc.animate( opacity: 0, 150 )

        $.when.apply( null, D ).done ->
            $title.text( data.caption ).animate( opacity: 1, 300 )
            $desc.html( data.desc ).animate( opacity: 1, 300 )
            D = [] # Deferreds
            return

    hide_sidebar: ( resize = true ) =>
        $$('#gallery')
            .addClass('is-full')
            .removeClass('show-sidebar')
        
        @fotorama.resize()      if resize and @fotorama #exists
        
        # Set current status
        @view.sidebar = false

        $.cookie('village_gallery', @view, path: '/') 
                
        return


    show_sidebar: ( resize = true ) =>
        $$('#gallery')
            .addClass('show-sidebar')
            .removeClass('is-full')

        @fotorama.resize()      if resize and @fotorama #exists
        
        # Set current status
        @view.sidebar = true
        $.cookie('village_gallery', @view, path: '/')

        @set_image('current')

        return


    ###
        Thumbnails Toggle
    ###
    toggle_thumbnails: ->
        if @view.thumbs is true
            @hide_thumbnails()
        else
            @show_thumbnails()


    show_thumbnails: =>
        @fotorama.setOptions(nav: "thumbs")

        $$('#gallery')
          .find('.fotorama__nav')
          .animo 
            animation: 'do-fadeInUp'
            duration: 0.2
            timing: "ease-out"
            keep: false
            , =>
                # Set current status
                @view.thumbs = true
                $.cookie('village_gallery', @view, path: '/')

                $$('#gallery').addClass('show-thumbnails')  

                

    hide_thumbnails: =>     
      $$('#gallery')
          .find('.fotorama__nav')
          .animo 
            animation: 'do-fadeOutDown'
            duration: 0.2
            timing: "ease-in"
            keep: false
            , =>
                
                # Set current status
                @view.thumbs = false
                $.cookie('village_gallery', @view, path: '/')

                $$('#gallery').removeClass('show-thumbnails')
                @fotorama.setOptions(nav: false)
                



    ### 
        Slider Navigation
    ###
    
    set_fotorama_image: (e, fotorama) =>
        @set_image( fotorama.activeIndex )

    

    set_image: ( index = 'current' ) ->
        
        if index is 'current'
            index = @currentID
        else
            return if index is @currentID
            @currentID = index

        if @view.sidebar
            data = @data[ @currentID ]
            @update_sidebar( data )




