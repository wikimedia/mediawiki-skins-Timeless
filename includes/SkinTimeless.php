<?php
/**
 * SkinTemplate class for the Timeless skin
 *
 * @ingroup Skins
 */
class SkinTimeless extends SkinTemplate {
	/** @var string */
	public $skinname = 'timeless';

	/** @var string */
	public $stylename = 'Timeless';

	/** @var string */
	public $template = 'TimelessTemplate';

	/**
	 * @param OutputPage $out
	 */
	public function initPage( OutputPage $out ) {
		parent::initPage( $out );

		$out->addMeta( 'viewport',
			'width=device-width, initial-scale=1.0, ' .
			'user-scalable=yes, minimum-scale=0.25, maximum-scale=5.0'
		);

		$out->addModuleStyles( [
			'mediawiki.skinning.content.externallinks',
			'skins.timeless',
		] );

		$defaultLayout = $this->getConfig()->get( 'TimelessDefaultLayout' );
		$layout = $this->getUser()->getOption( 'timeless-layout', $defaultLayout );

		if ( $layout == 'one-column' ) {
			// version without the max-width set
			$out->addModuleStyles( [ 'skins.timeless.onecolumn' ] );
		} elseif ( $layout == 'two-column' ) {
			$out->addModuleStyles( [ 'skins.timeless.onecolumn.capped' ] );
			$out->addModuleStyles( [ 'skins.timeless.twocolumn' ] );
		} else {
			$out->addModuleStyles( [ 'skins.timeless.onecolumn.capped' ] );
			$out->addModuleStyles( [ 'skins.timeless.twocolumn.capped' ] );
			$out->addModuleStyles( [ 'skins.timeless.threecolumn' ] );
		}

		$out->addModules( [
			'skins.timeless.js',
			'skins.timeless.mobile'
		] );

		// Basic IE support without flexbox
		$out->addStyle( $this->stylename . '/resources/IE9fixes.css', 'screen', 'IE' );
	}

	/**
	 * Add CSS via ResourceLoader
	 *
	 * @param OutputPage $out
	 */
	public function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
	}

	/**
	 * Add class for maximum column mode to <body> element
	 *
	 * @param OutputPage $out
	 * @param Skin $skin
	 * @param array &$bodyAttrs Existing attributes of the <body> tag as an array
	 */
	public static function onOutputPageBodyAttributes( $out, $skin, &$bodyAttrs ) {
		if ( $skin->getSkinName() == 'timeless' ) {
			$defaultLayout = $out->getContext()->getConfig()->get( 'TimelessDefaultLayout' );
			$user = $out->getUser();
			$layout = $user->getOption( 'timeless-layout', $defaultLayout );

			$bodyAttrs['class'] .= ' timeless-' . $layout;
		}
	}

	/**
	 * Add preference(s)
	 *
	 * @param User $user
	 * @param array &$preferences
	 */
	public static function onGetPreferences( User $user, array &$preferences ) {
		$context = RequestContext::getMain();
		$useskin = $context->getRequest()->getVal( 'useskin', false );
		$skin = $useskin ?: $user->getOption( 'skin' );

		$defaultLayout = $context->getConfig()->get( 'TimelessDefaultLayout' );

		if ( $skin == 'timeless' ) {
			$layouts = [
				'one-column',
				'two-column',
				'three-column'
			];
			$layoutOptions = [];
			foreach ( $layouts as $layoutOption ) {
				$layoutOptions[$context->msg( "timeless-pref-$layoutOption" )->escaped()] = $layoutOption;
			}

			$preferences['timeless-layout'] = [
				'type' => 'select',
				'options' => $layoutOptions,
				'default' => $user->getOption( 'timeless-layout', $defaultLayout ),
				'label-message' => 'timeless-layout-preference',
				'section' => 'rendering/skin'
			];
		}
	}
}
