<?php
/**
 * ResourceLoader module to set the skin-backdrop background image (by default,
 * the angry cat)
 */

class TimelessFileModule extends ResourceLoaderFileModule {
	/**
	 * Make the style from the config var!
	 * TODO: Just set a less variable here instead of hardcoding the full definition (T223112)
	 *
	 * @param ResourceLoaderContext $context
	 * @return array
	 */
	public function getStyles( ResourceLoaderContext $context ) {
		$config = $this->getConfig();
		$background = $config->get( 'TimelessBackdropImage' );
		if ( $background === 'cat.svg' ) {
			// expand default
			$background = $config->get( 'StylePath' ) . '/Timeless/resources/images/cat.svg';
		}

		$background = OutputPage::transformResourcePath( $config, $background );
		$styles = parent::getStyles( $context );

		$styles['all'][] = '#mw-content-container { background-image: ' .
			CSSMin::buildUrlValue( $background ) .
			'; }';

		return $styles;
	}

	/**
	 * Register the config var with the caching stuff so it properly updates the cache
	 *
	 * @param ResourceLoaderContext $context
	 * @return array
	 */
	public function getDefinitionSummary( ResourceLoaderContext $context ) {
		$summary = parent::getDefinitionSummary( $context );
		$summary[] = [
			'TimelessBackdropImage' => $this->getConfig()->get( 'TimelessBackdropImage' )
		];
		return $summary;
	}
}
