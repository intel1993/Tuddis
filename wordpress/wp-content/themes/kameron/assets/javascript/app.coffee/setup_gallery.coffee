# Skip this if Galleries are not enabled
return unless App.config.gallery.enable

# ----------------------------------*/
# Implementation
# ----------------------------------*/

###
    Track the document URL
    To figure out if we're going history or pronto back
###
document_url = null
$$(window).on "pronto.request", ->
    document_url = window.location.href
    return



# ----------------------------------*/
# Gallery Setup
# ----------------------------------*/
    
# Gallery Instance Variable
Gallery = false

gallery_view_defaults = 
    thumbs: true
    sidebar: true


setup_gallery = ->
    
    $$('#gallery__stage', true)
    $$('#gallery__sidebar', true)
    $$('#gallery', true)

    gallery_exists = ( $$('#gallery', true).length > 0 )

    if not gallery_exists
        App.Header.reset()
        # App.sizemaster()
    else    
        gallery_data = $$('#gallery-data', true).data('gallery')
        if gallery_data?    
            App.Header.set_to( 'responsive', true )
            App.Header.hide()

            Gallery = new Gallery_Handle(gallery_view_defaults, gallery_data) 
            App.Gallery = Gallery




    return

# Initialize Gallery 
$$(window).one 'themeresized', setup_gallery
$$(window).on 'stage/complete', ->   
    # In case there is a leftover Gallery
    # And we have a brand new #gallery
    if Gallery isnt false # and gallery_exists
        Gallery.destroy()
        Gallery = false
    
    
    setup_gallery()

    return


# ----------------------------------*/
# Listen for various clicks
# ----------------------------------*/
$$(document).on 'click', '#gallery__close', (e) ->
    e.preventDefault()
    e.stopPropagation()

    if not document_url
        document_url = App.config.gallery.root_url

    Gallery.close(null, document_url)

$$(document).on 'click', '#gallery__thumbs__toggle', (e) ->
    Gallery.toggle_thumbnails()

$$(document).on 'click', '#gallery__sidebar__close', (e) ->
    Gallery.hide_sidebar( not App.is.responsive )

$$(document).on 'click', '#gallery__sidebar__open', (e) ->
    Gallery.show_sidebar( not App.is.responsive )

$$(window).on 'theme:sizes_setup', ->
    # return unless Gallery
    if App.Gallery and App.Gallery.fotorama
        Gallery.fotorama.resize()


App.config.gallery.mouse_timeout = false

# //-----------------------------------*/
# // Detect Mouse Movement
# //-----------------------------------*/
if App.config.gallery.mouse_timeout
    # Localally Global References
    TIMEOUT = null
    BLOCK_ACTION = false
    CONTROLS_HIDDEN = false
    
    # Kind of config
    MOUSE_TIMEOUT = App.config.gallery.mouse_timeout_ms
    TOGGLE_CLASS = "js__mouse-not-moving fotorama__wrap--no-controls"
    BLOCK_SELECTORS = '#gallery__sidebar, .fotorama__caption, #gallery__share, .fotorama__wrap--video'

    # Maybe turn this into an option in the future?
    if Modernizr.touch 
        MOUSE_TIMEOUT *= 2

    hide_gallery_controls = ->
        return if BLOCK_ACTION
        return if CONTROLS_HIDDEN
        
        # Hide Controls
        $$('#gallery').addClass( TOGGLE_CLASS )
        CONTROLS_HIDDEN = true
        return

    show_gallery_controls = ->
        return if BLOCK_ACTION
        return unless CONTROLS_HIDDEN
        
        # Show Controls
        $$('#gallery').removeClass( TOGGLE_CLASS )
        CONTROLS_HIDDEN = false
        return


    # UMM....THIS is actually a debounce
    # Maybe use _.debounce ?
    mouse_check_movement = ->
        # Always clear MOUSE_TIMEOUT
        clearTimeout(TIMEOUT)

        # Quits if no gallery
        return unless Gallery

        show_gallery_controls()

        TIMEOUT = setTimeout(hide_gallery_controls, MOUSE_TIMEOUT)

        return
    
    mouse_throttling_timeout = Math.round(MOUSE_TIMEOUT / 2)
    throttle_mouse_check = _.throttle( mouse_check_movement, mouse_throttling_timeout, trailing: false )
    
    # Attach Events
    $$(document).on 'mousemove touchend', throttle_mouse_check

    $$(document).on 'mouseenter', BLOCK_SELECTORS, ->
        return unless Gallery
        return if Gallery.disabled is true
        BLOCK_ACTION = true
        return

    $$(document).on 'mouseleave', BLOCK_SELECTORS, ->
        return unless Gallery
        return if Gallery.disabled is true
        BLOCK_ACTION = false
        return

    $$(document).on 'fotorama:loadvideo', ->        
        hide_gallery_controls()
        BLOCK_ACTION = true
        return

    $$(document).on 'fotorama:unloadvideo', ->        
        BLOCK_ACTION = false
        show_gallery_controls()
        return
    


# if App.is.responsive
#     $$(window).on 'scroll touchmove', (e) ->
#         if Gallery.disabled is false
#             e.preventDefault()
#             e.stopPropagation()
#             return false












