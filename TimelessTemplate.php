<?php
/**
 * BaseTemplate class for the Timeless skin
 *
 * @ingroup Skins
 */
class TimelessTemplate extends BaseTemplate {
	/**
	 * Outputs the entire contents of the page
	 */
	public function execute() {
		$this->html( 'headelement' );
		?>
		<div id="mw-wrapper">
			<div id="mw-header-container" class="ts-container">
			<div id="mw-header" class="ts-inner">
				<div id="user-tools">
					<?php $this->outputUserLinks(); ?>
				</div>
				<?php
				$this->outputLogo( 'p-logo-text', 'text' );
				$this->outputSearch();
				?>
			</div>
			</div>

			<div id="content-container" class="ts-container">
			<div id="content-block" class="ts-inner">
				<div id="mw-site-navigation">
					<h2><?php echo $this->getMsg( 'navigation-heading' )->parse() ?></h2>
					<?php
					$this->outputLogo( 'p-logo', 'image' );
					echo '<div id="page-tools">';
						$this->outputPageLinks();
					echo '</div><div id="site-navigation">';
						$this->outputSiteNavigation();
					echo '</div>';
					?>
				</div>
				<div id="mw-related-navigation">
				</div>
				<div id="content">
				<div class="mw-body" role="main">
					<?php
					if ( $this->data['sitenotice'] ) {
						?>
						<div id="siteNotice"><?php $this->html( 'sitenotice' ) ?></div>
						<?php
					}
					if ( $this->data['newtalk'] ) {
						?>
						<div class="usermessage"><?php $this->html( 'newtalk' ) ?></div>
						<?php
					}
					?>

					<h1 class="firstHeading">
						<?php $this->html( 'title' ) ?>
					</h1>
					<div id="siteSub"><?php echo $this->getMsg( 'tagline' )->parse() ?></div>
					<div class="mw-body-content">
						<div id="contentSub">
							<?php
							if ( $this->data['subtitle'] ) {
								?>
								<p><?php $this->html( 'subtitle' ) ?></p>
								<?php
							}
							if ( $this->data['undelete'] ) {
								?>
								<p><?php $this->html( 'undelete' ) ?></p>
								<?php
							}
							?>
						</div>

						<?php
						$this->html( 'bodytext' );
						$this->html( 'catlinks' );
						$this->html( 'dataAfterContent' );
						?>
					</div>
				</div>
				</div>
			</div>
			</div>

			<div id="mw-footer-container" class="ts-container">
			<div id="mw-footer" class="ts-inner">
				<?php
				foreach ( $this->getFooterLinks() as $category => $links ) {
					?>
					<ul role="contentinfo">
						<?php
						foreach ( $links as $key ) {
							?>
							<li><?php $this->html( $key ) ?></li>
							<?php
						}
						?>
					</ul>
					<?php
				}
				?>

				<ul role="contentinfo">
					<?php
					foreach ( $this->getFooterIcons( 'icononly' ) as $blockName => $footerIcons ) {
						?>
						<li>
							<?php
							foreach ( $footerIcons as $icon ) {
								echo $this->getSkin()->makeFooterIcon( $icon );
							}
							?>
						</li>
						<?php
					}
					?>
				</ul>
			</div>
			</div>
		</div>

		<?php $this->printTrail() ?>
		</body></html>

		<?php
	}

	/**
	 * Outputs a single sidebar portlet of any kind.
	 */
	private function outputPortlet( $box ) {
		if ( !$box['content'] ) {
			return;
		}

		?>
		<div
			role="navigation"
			class="mw-portlet"
			id="<?php echo Sanitizer::escapeId( $box['id'] ) ?>"
			<?php echo Linker::tooltip( $box['id'] ) ?>
		>
			<h3>
				<?php
				if ( isset( $box['headerMessage'] ) ) {
					echo $this->getMsg( $box['headerMessage'] )->escaped();
				} else {
					echo htmlspecialchars( $box['header'] );
				}
				?>
			</h3>

			<?php
			if ( is_array( $box['content'] ) ) {
				echo '<ul>';
				foreach ( $box['content'] as $key => $item ) {
					echo $this->makeListItem( $key, $item );
				}
				echo '</ul>';
			} else {
				echo $box['content'];
			}?>
		</div>
		<?php
	}

	/**
	 * Outputs the logo and (optionally) site title
	 */
	private function outputLogo( $id = 'p-logo', $part = 'both' ) {
		?>
		<div id="<?php echo $id ?>" class="mw-portlet" role="banner">
			<?php
			if ( $part !== 'text' ) {
				?>
				<a
					class="mw-wiki-logo"
					href="<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] )
				?>" <?php
				echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs( 'p-logo' ) )
				?>></a>
				<?php
			}
			if ( $part !== 'image' ) {
				?>
				<a id="p-banner" class="mw-wiki-title" href="<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] ) ?>">
					<?php echo $this->getMsg( 'sitetitle' )->escaped() ?>
				</a>
				<?php
			}
			?>
		</div>
		<?php
	}

	/**
	 * Outputs the logo and site title
	 */
	private function outputSearch() {
		?>
		<form
			action="<?php $this->text( 'wgScript' ) ?>"
			role="search"
			class="mw-portlet"
			id="p-search"
		>
			<input type="hidden" name="title" value="<?php $this->text( 'searchtitle' ) ?>" />
			<h3>
				<label for="searchInput"><?php echo $this->getMsg( 'search' )->escaped() ?></label>
			</h3>
			<?php echo $this->makeSearchInput( array( "id" => "searchInput" ) ) ?>
			<?php echo $this->makeSearchButton( 'go', array( 'id' => 'searchGoButton', 'class' => 'searchButton' ) ) ?>
			<input type='hidden' name="title" value="<?php $this->text( 'searchtitle' ) ?>"/>
		</form>
		<?php
	}

	/**
	 * Outputs the sidebar
	 * Set the elements to true to allow them to be part of the sidebar
	 */
	private function outputSiteNavigation() {
		$sidebar = $this->getSidebar();

		$sidebar['SEARCH'] = false;
		$sidebar['TOOLBOX'] = true;
		$sidebar['LANGUAGES'] = true;

		foreach ( $sidebar as $boxName => $box ) {
			if ( $boxName === false ) {
				continue;
			}
			$this->outputPortlet( $box, true );
		}
	}
	private function outputPageLinks() {
		$this->outputPortlet( array(
			'id' => 'p-namespaces',
			'headerMessage' => 'namespaces',
			'content' => $this->data['content_navigation']['namespaces'],
		) );
		$this->outputPortlet( array(
			'id' => 'p-variants',
			'headerMessage' => 'variants',
			'content' => $this->data['content_navigation']['variants'],
		) );
		$this->outputPortlet( array(
			'id' => 'p-views',
			'headerMessage' => 'views',
			'content' => $this->data['content_navigation']['views'],
		) );
		$this->outputPortlet( array(
			'id' => 'p-actions',
			'headerMessage' => 'actions',
			'content' => $this->data['content_navigation']['actions'],
		) );
	}
	private function outputUserLinks() {
		$this->outputPortlet( array(
			'id' => 'p-personal',
			'headerMessage' => 'personaltools',
			'content' => $this->getPersonalTools(),
		) );
	}
}
