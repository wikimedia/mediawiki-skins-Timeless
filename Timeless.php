<?php
/**
 * This PHP entry point is deprecated. Please use wfLoadSkin() and the skin.json file
 * instead. See https://www.mediawiki.org/wiki/Manual:Extension_registration for more details.
 */
if ( !function_exists( 'wfLoadSkin' ) ) {
	die( 'The Timeless skin requires MediaWiki 1.25 or newer.' );
}

wfLoadSkin( 'Timeless' );
