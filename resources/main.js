/**
 * Focus on search box when 'Tab' key is pressed once
 */
$( function () {
	$( '#searchInput' ).attr( 'tabindex', $( document ).lastTabIndex() + 1 );
} );

/**
 * Desktop menu click-toggling
 */
$( function () {
	// sidebar-chunk only applies to desktop-small, but the toggles are hidden at
	// other resolutions regardless and the css overrides any visible effects. So
	// whatever.
	var dropdowns = '#personal, #p-variants-desktop, .sidebar-chunk';

	/**
	 * Close all dropdowns
	 */
	function closeOpen() {
		$( dropdowns ).each( function () {
			if ( $( this ).hasClass( 'dropdown-active' ) ) {
				$( this ).removeClass( 'dropdown-active' );
			}
		} );
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
	$( document ).click( function ( e ) {
		if ( $( e.target ).closest( dropdowns ).length > 0 ) {
			// Clicked inside an open menu; don't close anything
		} else {
			closeOpen();
		}
	} );
} );
