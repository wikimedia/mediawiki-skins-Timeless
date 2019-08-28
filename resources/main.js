/**
 * Focus on search box when 'Tab' key is pressed once
 */
$( function () {
	$( '#searchInput' ).attr( 'tabindex', $( document ).lastTabIndex() + 1 );
} );

/**
 * Desktop menu click-toggling
 *
 * We're not even checking if it's desktop because the classes in play have no effect
 * on mobile regardless... this may break things at some point, though.
 */
$( function () {
	// sidebar-chunk only applies to desktop-small, but the toggles are hidden at
	// other resolutions regardless and the css overrides any visible effects.
	var dropdowns = '#personal, #p-variants-desktop, .sidebar-chunk';

	/**
	 * Close all dropdowns
	 */
	function closeOpen() {
		$( dropdowns ).removeClass( 'dropdown-active' );
	}

	/**
	 * Click behaviour
	 */
	$( dropdowns ).on( 'click', function ( e ) {
		var wasOpen = false;
		// Check if it's already open so we don't open it again
		if ( $( this ).hasClass( 'dropdown-active' ) ) {
			wasOpen = true;
		}
		closeOpen();
		e.stopPropagation(); // stop hiding it!
		if ( !wasOpen ) {
			$( this ).addClass( 'dropdown-active' );
		}
	} );
	$( document ).on( 'click', function ( e ) {
		if ( $( e.target ).closest( dropdowns ).length > 0 ) {
			// Clicked inside an open menu; don't close anything
		} else {
			closeOpen();
		}
	} );
} );
