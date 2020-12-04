<?php
/**
 * SkinTemplate class for the Timeless skin
 *
 * @ingroup Skins
 */
class SkinTimeless extends SkinTemplate {
	/** @var string */
	public $stylename = 'Timeless';

	/** @var string */
	public $template = 'TimelessTemplate';

	/**
	 * @param OutputPage $out
	 */
	public function initPage( OutputPage $out ) {
		parent::initPage( $out );

		$out->addModules( [
			'skins.timeless.js'
		] );

		// Basic IE support without flexbox
		$out->addStyle( $this->stylename . '/resources/IE9fixes.css', 'screen', 'IE' );
	}
}
