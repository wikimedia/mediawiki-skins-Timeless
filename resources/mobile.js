/* Popout menus (header) */

/* eslint-disable no-jquery/no-fade */

$( () => {
	const toggleTime = 200;

	// Open the various menus
	$( '#user-tools h2' ).on( 'click', () => {
		if ( $( window ).width() < 851 ) {
			$( '#personal-inner, #menus-cover' ).fadeToggle( toggleTime );
		}
	} );
	$( '#site-navigation h2' ).on( 'click', () => {
		if ( $( window ).width() < 851 ) {
			$( '#site-navigation .sidebar-inner, #menus-cover' ).fadeToggle( toggleTime );
		}
	} );
	$( '#site-tools h2' ).on( 'click', () => {
		if ( $( window ).width() < 851 ) {
			$( '#site-tools .sidebar-inner, #menus-cover' ).fadeToggle( toggleTime );
		}
	} );
	$( '#ca-more' ).on( 'click', () => {
		$( '#page-tools .sidebar-inner' ).css( 'top', $( '#ca-more' ).offset().top + 25 );
		if ( $( window ).width() < 851 ) {
			$( '#page-tools .sidebar-inner, #menus-cover' ).fadeToggle( toggleTime );
		}
	} );
	$( '#ca-languages' ).on( 'click', () => {
		$( '#other-languages .sidebar-inner' ).css( 'top', $( '#ca-languages' ).offset().top + 25 );
		if ( $( window ).width() < 851 ) {
			$( '#other-languages .sidebar-inner, #menus-cover' ).fadeToggle( toggleTime );
		}
	} );

	// Close menus on click outside
	$( document ).on( 'click touchstart', ( e ) => {
		if ( $( e.target ).closest( '#menus-cover' ).length > 0 ) {
			$( '#personal-inner' ).fadeOut( toggleTime );
			$( '.sidebar-inner' ).fadeOut( toggleTime );
			$( '#menus-cover' ).fadeOut( toggleTime );
		}
	} );
} );
