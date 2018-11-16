/**
 * Timeless-specific scripts
 */
$( function () {

	/**
	 * Focus on search box when 'Tab' key is pressed once
	 */
	$( '#searchInput' ).attr( 'tabindex', $( document ).lastTabIndex() + 1 );

} );
