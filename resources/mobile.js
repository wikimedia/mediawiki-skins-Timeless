/* Popout menus (header) */

$( function () {
	var toggleTime = 200,
		mobileCutoff = 720;

	// Open the various menus
	$( '#user-tools h2' ).on( 'click', function () {
		if ( $( window ).width() < mobileCutoff ) {
			$( '#personal-inner, #menus-cover' ).fadeToggle( toggleTime );
		}
	} );
	$( '#site-navigation h2' ).on( 'click', function () {
		if ( $( window ).width() < mobileCutoff ) {
			$( '#site-navigation .sidebar-inner, #menus-cover' ).fadeToggle( toggleTime );
		}
	} );
	$( '#site-tools h2' ).on( 'click', function () {
		if ( $( window ).width() < mobileCutoff ) {
			$( '#site-tools .sidebar-inner, #menus-cover' ).fadeToggle( toggleTime );
		}
	} );
	$( '#ca-more' ).on( 'click', function () {
		$( '#page-tools .sidebar-inner' ).css( 'top', $( '#ca-more' ).offset().top + 25 );
		if ( $( window ).width() < mobileCutoff ) {
			$( '#page-tools .sidebar-inner, #menus-cover' ).fadeToggle( toggleTime );
		}
	} );
	$( '#ca-languages' ).on( 'click', function () {
		$( '#other-languages .sidebar-inner' ).css( 'top', $( '#ca-languages' ).offset().top + 25 );
		if ( $( window ).width() < mobileCutoff ) {
			$( '#other-languages .sidebar-inner, #menus-cover' ).fadeToggle( toggleTime );
		}
	} );

	// Close menus on click outside
	$( document ).click( function ( e ) {
		if ( $( e.target ).closest( '#menus-cover' ).length > 0 ) {
			$( '#personal-inner' ).fadeOut( toggleTime );
			$( '.sidebar-inner' ).fadeOut( toggleTime );
			$( '#menus-cover' ).fadeOut( toggleTime );
		}
	} );

	// Include alternative closing method for ios
	$( window ).on( 'swiperight', function () {
		if ( $( window ).width() < mobileCutoff ) {
			$( '#personal-inner' ).fadeOut( toggleTime );
			$( '.sidebar-inner' ).fadeOut( toggleTime );
			$( '#menus-cover' ).fadeOut( toggleTime );
		}
	} );
} );
