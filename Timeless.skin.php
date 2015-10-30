<?php
/**
 * SkinTemplate class for the Timeless skin
 *
 * @ingroup Skins
 */
class SkinTimeless extends SkinTemplate {
	public $skinname = 'timeless', $stylename = 'Timeless',
		$template = 'TimelessTemplate', $useHeadElement = true;

	/**
	 * Add CSS via ResourceLoader
	 *
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );

		$out->addMeta( 'viewport', 'width=device-width, initial-scale=1.0' );

		$out->addModuleStyles( array(
			'mediawiki.skinning.content.externallinks',
			'skins.timeless'
		) );
		$out->addModules( array( 'skins.timeless.js' ) );
	}
}
