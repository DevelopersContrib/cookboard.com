var activityIndicatorOn = function()
{
        jQuery( '<div id="imagelightbox-loading"><div></div></div>' ).appendTo( 'body' );
},
activityIndicatorOff = function()
{
        jQuery( '#imagelightbox-loading' ).remove();
},


// OVERLAY

overlayOn = function()
{
        jQuery( '<div id="imagelightbox-overlay"></div>' ).appendTo( 'body' );
},
overlayOff = function()
{
        jQuery( '#imagelightbox-overlay' ).remove();
},


// CLOSE BUTTON

closeButtonOn = function( instance )
{
        jQuery( '<button type="button" id="imagelightbox-close" title="Close"></button>' ).appendTo( 'body' ).on( 'click touchend', function(){ jQuery( this ).remove(); instance.quitImageLightbox(); return false; });
},
closeButtonOff = function()
{
        jQuery( '#imagelightbox-close' ).remove();
},


// CAPTION

captionOn = function()
{
        var description = jQuery( 'a[href="' + jQuery( '#imagelightbox' ).attr( 'src' ) + '"] img' ).attr( 'alt' );
        if( description.length > 0 )
                jQuery( '<div id="imagelightbox-caption">' + description + '</div>' ).appendTo( 'body' );
},
captionOff = function()
{
        jQuery( '#imagelightbox-caption' ).remove();
},


// NAVIGATION

navigationOn = function( instance, selector )
{
        var images = jQuery( selector );
        if( images.length )
        {
                var nav = jQuery( '<div id="imagelightbox-nav"></div>' );
                for( var i = 0; i < images.length; i++ )
                        nav.append( '<button type="button"></button>' );

                nav.appendTo( 'body' );
                nav.on( 'click touchend', function(){ return false; });

                var navItems = nav.find( 'button' );
                navItems.on( 'click touchend', function()
                {
                        var $this = jQuery( this );
                        if( images.eq( $this.index() ).attr( 'href' ) != jQuery( '#imagelightbox' ).attr( 'src' ) )
                                instance.switchImageLightbox( $this.index() );

                        navItems.removeClass( 'active' );
                        navItems.eq( $this.index() ).addClass( 'active' );

                        return false;
                })
                .on( 'touchend', function(){ return false; });
        }
},
navigationUpdate = function( selector )
{
        var items = jQuery( '#imagelightbox-nav button' );
        items.removeClass( 'active' );
        items.eq( jQuery( selector ).filter( '[href="' + jQuery( '#imagelightbox' ).attr( 'src' ) + '"]' ).index( selector ) ).addClass( 'active' );
},
navigationOff = function()
{
        jQuery( '#imagelightbox-nav' ).remove();
},


// ARROWS

arrowsOn = function( instance, selector )
{
        var $arrows = jQuery( '<button type="button" class="imagelightbox-arrow imagelightbox-arrow-left"></button><button type="button" class="imagelightbox-arrow imagelightbox-arrow-right"></button>' );

        $arrows.appendTo( 'body' );

        $arrows.on( 'click touchend', function( e )
        {
                e.preventDefault();

                var $this	= jQuery( this ),
                        $target	= jQuery( selector + '[href="' + jQuery( '#imagelightbox' ).attr( 'src' ) + '"]' ),
                        index	= $target.index( selector );

                if( $this.hasClass( 'imagelightbox-arrow-left' ) )
                {
                        index = index - 1;
                        if( !jQuery( selector ).eq( index ).length )
                                index = jQuery( selector ).length;
                }
                else
                {
                        index = index + 1;
                        if( !jQuery( selector ).eq( index ).length )
                                index = 0;
                }

                instance.switchImageLightbox( index );
                return false;
        });
},
arrowsOff = function()
{
        jQuery( '.imagelightbox-arrow' ).remove();
};


//	ALL COMBINED
/*
var selectorF = 'a[data-imagelightbox="g"]';
var instanceF = jQuery( selectorF ).imageLightbox(
{
    onStart: function() { navigationOn( instanceF, instanceF ); overlayOn(); closeButtonOn( instanceF ); arrowsOn( instanceF, selectorF ); },
    onEnd: function() { navigationOff();  overlayOff(); captionOff(); closeButtonOff(); arrowsOff(); activityIndicatorOff(); },
    onLoadStart: function() { captionOff(); activityIndicatorOn(); },
    onLoadEnd: function() { navigationUpdate( instanceF );  captionOn(); activityIndicatorOff(); jQuery( '.imagelightbox-arrow' ).css( 'display', 'block' ); }
});
*/

//	WITH NAVIGATION & ACTIVITY INDICATION

var selectorE = 'a[data-imagelightbox="g"]';
var instanceE = $( selectorE ).imageLightbox(
{
        onStart:	 function() { navigationOn( instanceE, selectorE ); overlayOn(); },
        onEnd:		 function() { navigationOff(); activityIndicatorOff(); overlayOff(); },
        onLoadStart: function() { activityIndicatorOn(); },
        onLoadEnd:	 function() { navigationUpdate( selectorE ); activityIndicatorOff(); }
});