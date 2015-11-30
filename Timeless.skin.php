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
	 * @param $out OutputPage
	 */
	public function initPage( OutputPage $out ) {
		parent::initPage( $out );

		$out->addMeta( 'viewport', 'width=device-width, initial-scale=1, maximum-scale=1' );

		$out->addModuleStyles( array(
			'mediawiki.skinning.content.externallinks',
			'skins.timeless',
			'skins.timeless.misc'
		) );
		$out->addModules( array(
			'skins.timeless.js',
			'skins.timeless.mobile'
		) );
	}

	/**
	 * Add CSS via ResourceLoader
	 *
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
	}
}
