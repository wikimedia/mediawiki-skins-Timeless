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
		$pileOfTools = $this->getPageTools();

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

			<div id="mw-content-container" class="ts-container">
			<div id="mw-content-block" class="ts-inner">
				<div id="mw-site-navigation">
					<h2><?php echo $this->getMsg( 'navigation-heading' )->parse() ?></h2>
					<?php
					$this->outputLogo( 'p-logo', 'image' );
					echo '<div id="site-navigation" class="sidebar-chunk">';
						$this->outputSiteNavigation();
					echo '</div>';
					$this->outputPortlet( array(
						'id' => 'p-sitetools',
						'headerMessage' => 'timeless-sitetools',
						'content' => $pileOfTools['general'],
						'class' => 'sidebar-chunk'
					) );
					?>
				</div>
				<div id="mw-related-navigation">
					<div id="page-tools" class="sidebar-chunk">
						<?php
						if ( count( $pileOfTools['page-secondary'] ) > 0 ) {
							$this->outputPortlet( array(
								'id' => 'p-pageactions',
								'headerMessage' => 'timeless-pageactions',
								'content' => $pileOfTools['page-secondary'],
							) );
						}
						if ( count( $pileOfTools['user'] ) > 0 ) {
							$this->outputPortlet( array(
								'id' => 'p-userpagetools',
								'headerMessage' => 'timeless-userpagetools',
								'content' => $pileOfTools['user'],
							) );
						}
						$this->outputPortlet( array(
							'id' => 'p-pagemisc',
							'headerMessage' => 'timeless-pagemisc',
							'content' => $pileOfTools['page-tertiary'],
						) );
						?>
					</div>
					<?php

					$this->outputInterlanguageLinks();
					$this->outputCategories();
					?>
				</div>
				<div id="mw-content">
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
					<div id="page-header-links">
					<?php
						$this->outputPortlet( array(
							'id' => 'p-namespaces',
							'headerMessage' => 'timeless-namespaces',
							'content' => $pileOfTools['namespaces'],
						) );
					?>
					<?php
						$this->outputPortlet( array(
							'id' => 'p-pagetools',
							'headerMessage' => 'timeless-pagetools',
							'content' => $pileOfTools['page-primary'],
						) );
					?>
					</div>
					<div class="visual-clear"></div>
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
						?>
						<div class="visual-clear"></div>
						<?php
						$this->html( 'dataAfterContent' );
						?>
					</div>
				</div>
				</div>
			<div class="visual-clear"></div>
			</div>
			</div>

			<div id="mw-footer-container" class="ts-container">
			<div id="mw-footer" class="ts-inner">
				<ul role="contentinfo" id="footer-icons">
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
				<?php
				foreach ( $this->getFooterLinks() as $category => $links ) {
					?>
					<ul role="contentinfo" id="footer-<?php echo Sanitizer::escapeId( $category ) ?>">
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
		if ( !isset( $box['class'] ) ) {
			$box['class'] = 'mw-portlet';
		} else {
			$box['class'] .= ' mw-portlet';
		}

		?>
		<div
			role="navigation"
			class="<?php echo $box['class'] ?>"
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
	 * Outputs the search
	 */
	private function outputSearch() {
		?>
		<div class="mw-portlet" id="p-search">
			<h3<?php $this->html( 'userlangattributes' ) ?>>
				<label for="searchInput"><?php echo $this->getMsg( 'search' )->parse() ?></label>
			</h3>
			<form action="<?php $this->text( 'wgScript' ) ?>" id="searchform">
				<div id="simpleSearch">
				<div id="searchInput-container">
					<?php
					echo $this->makeSearchInput( array(
						'id' => 'searchInput',
						'placeholder' => $this->getMsg( 'timeless-search-placeholder' )->escaped(),
					) );
					?>
				</div>
				<?php
				echo Html::hidden( 'title', $this->get( 'searchtitle' ) );
				echo $this->makeSearchButton(
					'fulltext',
					array( 'id' => 'mw-searchButton', 'class' => 'searchButton mw-fallbackSearchButton' )
				);
				echo $this->makeSearchButton(
					'go',
					array( 'id' => 'searchButton', 'class' => 'searchButton' )
				);
				?>
				</div>
			</form>
		</div>
		<?php
	}

	/**
	 * Outputs the sidebar
	 */
	private function outputSiteNavigation() {
		$sidebar = $this->getSidebar();

		$sidebar['SEARCH'] = false; // Already hardcoded into header
		$sidebar['TOOLBOX'] = false; // Parsed as part of pageTools
		$sidebar['LANGUAGES'] = false; // PUT THIS ON THE OTHER SIDE

		foreach ( $sidebar as $boxName => $box ) {
			if ( $boxName === false ) {
				continue;
			}
			$this->outputPortlet( $box, true );
		}
	}

	private function outputUserLinks() {
		$user = $this->getSkin()->getUser();
		?>
		<div class="mw-portlet" id="p-personal" role="navigation">
			<h3>
			<span>
			<?php
			// Display status, and make a dropdown if logged in
			if ( $user->isLoggedIn() ) {
				$userName = $user->getName();
				// Make sure it fit firsts
				if ( strlen( $userName ) < 15 ) {
					echo htmlspecialchars( $userName, ENT_QUOTES );
				} else {
					echo wfMessage( 'timeless-loggedin' )->escaped();
				}
			} else {
				echo wfMessage( 'timeless-anonymous' )->escaped();
			}
			?>
			</span>
			</h3>
			<div class="p-body dropdown">
			<ul<?php $this->html( 'userlangattributes' ) ?>>
			<?php
				foreach ( $this->getPersonalTools() as $key => $item ) {
					if ( $key == 'userpage' ) {
						$item['links'][0]['text'] = wfMessage( 'timeless-userpage' )->text();
					}
					if ( $key == 'mytalk' ) {
						$item['links'][0]['text'] = wfMessage( 'timeless-talkpage' )->text();
					}
					echo $this->makeListItem( $key, $item );
				}
			?>
			</ul>
			</div>
		</div>
		<?php
	}

	/*
	 * Generates pile of all the tools
	 * Returns array of arrays of each kind
	 */
	private function getPageTools() {
		$title = $this->getSkin()->getTitle();
		$namespace = $title->getNamespace();

		$sortedPileOfTools = array(
			'namespaces' => array(),
			'page-primary' => array(),
			'page-secondary' => array(),
			'user' => array(),
			'page-tertiary' => array(),
			'general' => array()
		);

		$pileOfTools = array();
		foreach ( $this->data['content_navigation'] as $navKey => $navBlock ) {
			/* Just use namespaces items as they are */
			if ( $navKey == 'namespaces' ) {
				if ( $namespace < 0 ) {
					// Put special page ns_pages in the more pile so they're not so lonely
					$sortedPileOfTools['page-tertiary'] = $navBlock;
				} else {
					$sortedPileOfTools['namespaces'] = $navBlock;
				}
			} else {
				$pileOfTools = array_merge( $pileOfTools, $navBlock );
			}
		}
		$pileOfTools = array_merge( $pileOfTools, $this->getToolbox() );
		if ( $namespace >= 0 ) {
			$pileOfTools['pagelog'] = array(
				'text' => $this->getMsg( 'timeless-pagelog' )->escaped(),
				'href' => SpecialPage::getTitleFor( 'Log', $title->getPrefixedText() )->getLocalURL(),
				'id' => 't-pagelog'
			);
		}

		/* This is really dumb, but there is no sane way to do this. */
		foreach ( $pileOfTools as $navKey => $navBlock ) {
			$currentSet = null;

			if ( in_array( $navKey, array( 'watch', 'unwatch' ) ) ) {
				$currentSet = 'namespaces';
			} elseif ( in_array( $navKey, array( 'edit', 'view', 'history', 'contributions', 'addsection' ) ) ) {
				$currentSet = 'page-primary';
			} elseif ( in_array( $navKey, array( 'delete', 'rename', 'protect', 'unprotect', 'viewsource', 'move' ) ) ) {
				$currentSet = 'page-secondary';
			} elseif (in_array( $navKey, array( 'blockip', 'userrights', 'log' ) ) ) {
				$currentSet = 'user';
			} elseif (in_array( $navKey, array( 'whatlinkshere', 'print', 'info', 'pagelog', 'recentchangeslinked', 'permalink' ) ) ) {
				$currentSet = 'page-tertiary';
			} else {
				$currentSet = 'general';
			}
			$sortedPileOfTools[$currentSet][$navKey] = $navBlock;
		}

		return $sortedPileOfTools;
	}

	/*
	 * Assemble and output array of categories, regardless of view mode
	 * Just using Skin or OutputPage functions doesn't respect view modes (preview, history, whatever)
	 */
	private function outputCategories() {
		global $wgContLang;

		$skin =  $this->getSkin();
		$title = $skin->getTitle();
		$catList = false;

		/* Get list from outputpage if in preview; otherwise get list from title */
		if ( in_array( $skin->getRequest()->getVal( 'action' ), array( 'submit', 'edit' ) ) ) {
			$allCats = array();
			/* Can't just use getCategoryLinks because there's no equivalent for Title */
			$allCats2 = $skin->getOutput()->getCategories();
			foreach ( $allCats2 as $displayName ) {
				$catTitle = Title::makeTitleSafe( NS_CATEGORY, $displayName );
				$allCats[] = $catTitle->getDBkey();
			}
		} else {
			/* This is probably to trim out some excessive stuff. Unless I was just high on cough syrup. */
			$allCats = array_keys( $title->getParentCategories() );

			$len = strlen( $wgContLang->getNsText( NS_CATEGORY ) . ':' );
			foreach ( $allCats as $i => $catName ) {
				$allCats[$i] = substr( $catName, $len );
			}
		}
		if ( count( $allCats ) > 0 ) {
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				array( 'page', 'page_props' ),
				array( 'page_id', 'page_title' ),
				array(
					'page_title' => $allCats,
					'page_namespace' => NS_CATEGORY,
					'pp_propname' => 'hiddencat'
				),
				__METHOD__,
				array(),
				array( 'page_props' => array( 'JOIN', 'pp_page = page_id' ) )
			);
			$hiddenCats = array();
			foreach ( $res as $row ) {
				$hiddenCats[] = $row->page_title;
			}
			$normalCats = array_diff( $allCats, $hiddenCats );

			$normalCount = count( $normalCats );
			$hiddenCount = count( $hiddenCats );
			$count = $normalCount;

			/* Mostly consistent with how Skin does it. Doesn't have the classes. Either way can't be good for caching. */
			if (  $skin->getUser()->getBoolOption( 'showhiddencats' ) || $title->getNamespace() == NS_CATEGORY ) {
				$count += $hiddenCount;
			} else {
				/* We don't care if there are hidden ones. */
				$hiddenCount = 0;
			}

			/* Assemble the html because why not... */
			if ( $count ) {
				$catList = '<div role="navigation" class="mw-portlet sidebar-chunk" id="p-catlist">';
				if ( $normalCount ) {
					$catList .= $this->assembleCatList( $normalCats, 'catlist-normal', 'categories' );
				}
				if ( $hiddenCount ) {
					$catList .= $this->assembleCatList( $hiddenCats, 'catlist-hidden', 'hidden-categories' );
				}
				$catList .= '</div>';
			}
		}
		if ( $catList ) {
			echo $catList;
		}
	}
	private function assembleCatList( $list, $id, $message ) {
		$catList = '<h3>' . $this->getMsg( $message )->escaped() . '</h3>';
		$catList .= '<ul id="' . $id . '">';
		foreach ( $list as $category) {
			$title = Title::makeTitleSafe( NS_CATEGORY, $category );
			if ( !$title ) {
				continue;
			}
			$category = Linker::link( $title, $title->getText() );
			$catList .=  '<li>' . $category . '</li>';
		}
		$catList .= '</ul>';

		return $catList;
	}

	private function outputInterlanguageLinks() {
		if ( $this->data['language_urls'] ) {
			$msgObj = $this->getMsg( 'otherlanguages' );
			$this->outputPortlet( array(
				'id' => 'p-lang',
				'header' => $msgObj->exists() ? $msgObj->text() : 'otherlanguages',
				'generated' => false,
				'content' => $this->data['language_urls'],
				'class' => 'sidebar-chunk'
			) );
		}
	}
}
