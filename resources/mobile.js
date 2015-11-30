/* Popout menus (header) */

$( function() {
	var toggleTime = 200;

	// Open the various menus
	$( '#user-tools h2' ).on( 'click', function( e ) {
		if ( $( window ).width() < 851 ) {
			$( '#p-personal-inner, #menus-cover' ).fadeToggle( toggleTime );
		}
	} );
	$( '#site-navigation h2' ).on( 'click', function( e ) {
		if ( $( window ).width() < 851 ) {
			$( '#site-navigation .sidebar-inner, #menus-cover' ).fadeToggle( toggleTime );
		}
	} );
	$( '#site-tools h2' ).on( 'click', function( e ) {
		if ( $( window ).width() < 851 ) {
			$( '#site-tools .sidebar-inner, #menus-cover' ).fadeToggle( toggleTime );
		}
	} );
	$( '#ca-more' ).on( 'click', function( e ) {
		$( '#page-tools .sidebar-inner' ).css( "top", $( '#ca-more' ).offset().top + 25 );
		if ( $( window ).width() < 851 ) {
			$( '#page-tools .sidebar-inner, #menus-cover' ).fadeToggle( toggleTime );
		}
	} );
	$( '#ca-languages' ).on( 'click', function( e ) {
		$( '#other-languages .sidebar-inner' ).css( "top", $( '#ca-languages' ).offset().top + 25 );
		if ( $( window ).width() < 851 ) {
			$( '#other-languages .sidebar-inner, #menus-cover' ).fadeToggle( toggleTime );
		}
	} );

	// Close menus on click outside
	$( document ).click( function( e ) {
		if ( $( e.target ).closest( '#menus-cover' ).length > 0 ) {
			$( '#p-personal-inner' ).fadeOut( toggleTime );
			$( '.sidebar-inner' ).fadeOut( toggleTime );
			$( '#menus-cover' ).fadeOut( toggleTime );
		}
	} );

	// Include alternative closing method for ios
	$( window ).on( 'swiperight', function( e ) {
		if ( $( window ).width() < 851 ) {
			$( '#p-personal-inner' ).fadeOut( toggleTime );
			$( '.sidebar-inner' ).fadeOut( toggleTime );
			$( '#menus-cover' ).fadeOut( toggleTime );
		}
	} );
} );

