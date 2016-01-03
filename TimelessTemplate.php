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
			<div class="visual-clear"></div>
			</div>

			<div id="mw-header-hack" class="color-bar">
				<div class="color-middle-container">
					<div class="color-middle"></div>
				</div>
				<div class="color-left"></div>
				<div class="color-right"></div>
			</div>
			<div id="mw-header-nav-hack">
			<div class="color-bar">
				<div class="color-middle-container">
					<div class="color-middle"></div>
				</div>
				<div class="color-left"></div>
				<div class="color-right"></div>
			</div>
			</div>
			<div id="menus-cover"></div>

			<div id="mw-content-container" class="ts-container">
			<div id="mw-content-block" class="ts-inner">
				<div id="mw-site-navigation">
					<?php
					$this->outputLogo( 'p-logo', 'image' );
					$this->outputSiteNavigation();

					$siteTools = $this->assemblePortlet( array(
						'id' => 'p-sitetools',
						'headerMessage' => 'timeless-sitetools',
						'content' => $pileOfTools['general']
					) );
					$this->outputSidebarChunk( 'site-tools', 'timeless-sitetools', $siteTools );
					?>
				</div>
				<div id="mw-related-navigation">
					<?php
					$pageTools = '';
					if ( count( $pileOfTools['page-secondary'] ) > 0 ) {
						$pageTools .= $this->assemblePortlet( array(
							'id' => 'p-pageactions',
							'headerMessage' => 'timeless-pageactions',
							'content' => $pileOfTools['page-secondary'],
						) );
					}
					if ( count( $pileOfTools['user'] ) > 0 ) {
						$pageTools .= $this->assemblePortlet( array(
							'id' => 'p-userpagetools',
							'headerMessage' => 'timeless-userpagetools',
							'content' => $pileOfTools['user'],
						) );
					}
					$pageTools .= $this->assemblePortlet( array(
						'id' => 'p-pagemisc',
						'headerMessage' => 'timeless-pagemisc',
						'content' => $pileOfTools['page-tertiary'],
					) );
					$this->outputSidebarChunk( 'page-tools', 'timeless-pageactions', $pageTools );

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
					echo $this->getIndicators();
					?>

					<h1 class="firstHeading">
						<?php $this->html( 'title' ) ?>
					</h1>
					<div id="page-header-links">
					<?php
						echo $this->assemblePortlet( array(
							'id' => 'p-namespaces',
							'headerMessage' => 'timeless-namespaces',
							'content' => $pileOfTools['namespaces'],
						) );
					?>
					<?php
						echo $this->assemblePortlet( array(
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
					</div>
				</div>
				</div>
			<?php
				if ( $this->data['catlinks'] ) {
					$this->html( 'catlinks' );
				}
				$this->html( 'dataAfterContent' );
			?>
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
	 * Returns a single sidebar portlet of any kind (monobook style)
	 */
	private function assemblePortlet( $box ) {
		if ( !$box['content'] ) {
			return;
		}
		if ( !isset( $box['class'] ) ) {
			$box['class'] = 'mw-portlet';
		} else {
			$box['class'] .= ' mw-portlet';
		}

		$content = '<div role="navigation" class="' . $box['class'] . '" id="' . Sanitizer::escapeId( $box['id'] ) . '"' . Linker::tooltip( $box['id'] ) . '>';
		$content .= '<h3>';
			if ( isset( $box['headerMessage'] ) ) {
				$content .= $this->getMsg( $box['headerMessage'] )->escaped();
			} else {
				$content .= htmlspecialchars( $box['header'] );
			}
		$content .= '</h3>';
		if ( is_array( $box['content'] ) ) {
			$content .= '<ul>';
			foreach ( $box['content'] as $key => $item ) {
				$content .= $this->makeListItem( $key, $item );
			}
			$content .= '</ul>';
		} else {
			$content .= $box['content'];
		}
		$content .= '</div>';

		return $content;
	}

	/**
	 * Makes links for navigation lists.
	 *
	 * Modified to add a <span> around <a> content in navigation lists; everything else is
	 * basically the same as in BaseTemplate, just with extra stuff removed.
	 *
	 * Can't just use the original's options['wrapper'] because it's a piece of crap and spews
	 * infinite errors on the page.
	 */
	function makeLink( $key, $item, $options = array() ) {
		if ( isset( $item['text'] ) ) {
			$text = $item['text'];
		} else {
			$text = $this->translator->translate( isset( $item['msg'] ) ? $item['msg'] : $key );
		}

		$html = htmlspecialchars( $text );
		$html = '<span>' . $html . '</span>';

		if ( isset( $item['href'] ) ) {
			$attrs = $item;
			foreach ( array( 'single-id', 'text', 'msg', 'tooltiponly', 'context', 'primary' ) as $k ) {
				unset( $attrs[$k] );
			}

			if ( isset( $item['id'] ) && !isset( $item['single-id'] ) ) {
				$item['single-id'] = $item['id'];
			}
			if ( isset( $item['single-id'] ) ) {
				if ( isset( $item['tooltiponly'] ) && $item['tooltiponly'] ) {
					$title = Linker::titleAttrib( $item['single-id'] );
					if ( $title !== false ) {
						$attrs['title'] = $title;
					}
				} else {
					$tip = Linker::tooltipAndAccesskeyAttribs( $item['single-id'] );
					if ( isset( $tip['title'] ) && $tip['title'] !== false ) {
						$attrs['title'] = $tip['title'];
					}
					if ( isset( $tip['accesskey'] ) && $tip['accesskey'] !== false ) {
						$attrs['accesskey'] = $tip['accesskey'];
					}
				}
			}
			$html = Html::rawElement( 'a', $attrs, $html );
		}

		return $html;
	}

	/**
	 * Outputs a sidebar-chunk containing one or more portlets
	 */
	private function outputSidebarChunk( $id, $headerMessage, $content ) {
		echo '<div id="' . $id . '" class="sidebar-chunk">';
		echo '<h2><span>' . $this->getMsg( $headerMessage )->escaped() . '</span><div class="pokey"></div></h2>';
		echo '<div class="sidebar-inner">' . $content . '</div></div>';
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
				$titleClass = '';
				$siteTitle = $this->getMsg( 'timeless-sitetitle' )->escaped();
				// width is 11em; 13 characters will probably fit?
				if ( mb_strlen( $siteTitle ) > 13 ) {
					$titleClass = 'long';
				}
				?>
				<a id="p-banner" class="mw-wiki-title <?php echo $titleClass ?>" href="<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] ) ?>">
					<?php echo $siteTitle ?>
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
		$content = '';

		$sidebar['SEARCH'] = false; // Already hardcoded into header
		$sidebar['TOOLBOX'] = false; // Parsed as part of pageTools
		$sidebar['LANGUAGES'] = false; // Forcibly removed to separate chunk

		foreach ( $sidebar as $boxName => $box ) {
			if ( $boxName === false ) {
				continue;
			}
			$content .= $this->assemblePortlet( $box, true );
		}

		$this->outputSidebarChunk( 'site-navigation', 'navigation', $content );
	}

	/**
	 * Outputs user links portlet for header
	 */
	private function outputUserLinks() {
		$user = $this->getSkin()->getUser();
		?>
		<div id="p-personal">
		<h2>
			<span>
			<?php
			// Display status, and make a dropdown if logged in
			if ( $user->isLoggedIn() ) {
				$userName = $user->getName();
				// Make sure it fit firsts
				if ( mb_strlen( $userName ) < 12 ) {
					echo htmlspecialchars( $userName, ENT_QUOTES );
				} else {
					echo wfMessage( 'timeless-loggedin' )->escaped();
				}
			} else {
				echo wfMessage( 'timeless-anonymous' )->escaped();
			}
			?>
			</span>
			<div class="pokey"></div>
		</h2>
		<div id="p-personal-inner" class="dropdown">
		<div class="mw-portlet" role="navigation">
			<h3>
			<?php
			if ( $user->isLoggedIn() ) {
				echo wfMessage( 'timeless-loggedinas', $user->getName() )->parse();
			} else {
				echo wfMessage( 'timeless-notloggedin' )->parse();
			}
			?>
			</h3>
			<div class="p-body">
			<ul<?php $this->html( 'userlangattributes' ) ?>>
			<?php
				foreach ( $this->getPersonalTools() as $key => $item ) {
					if ( $key == 'userpage' ) {
						$item['links'][0]['text'] = wfMessage( 'timeless-userpage', $user->getName() )->text();
					}
					if ( $key == 'mytalk' ) {
						$item['links'][0]['text'] = wfMessage( 'timeless-talkpage', $user->getName() )->text();
					}
					echo $this->makeListItem( $key, $item );
				}
			?>
			</ul>
			</div>
		</div>
		</div>
		</div>
		<?php
	}

	/*
	 * Generates pile of all the tools
	 * Returns array of arrays of each kind (wouldn't it be nice if tools themselves just registered the type instead?)
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
		$pileOfTools['more'] = array(
			'text' => $this->getMsg( 'timeless-more' )->escaped(),
			'id' => 'ca-more',
			'class' => 'dropdown-toggle'
		);
		if ( $this->data['language_urls'] ) {
			$pileOfTools['languages'] = array(
				'text' => $this->getMsg( 'timeless-languages' )->escaped(),
				'id' => 'ca-languages',
				'class' => 'dropdown-toggle'
			);
		}

		/* This is really dumb, but there is no sane way to do this. */
		foreach ( $pileOfTools as $navKey => $navBlock ) {
			$currentSet = null;

			if ( in_array( $navKey, array( 'watch', 'unwatch' ) ) ) {
				$currentSet = 'namespaces';
			} elseif ( in_array( $navKey, array( 'edit', 'view', 'history', 'contributions', 'addsection', 'more', 'languages' ) ) ) {
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
				if ( $normalCount ) {
					$catHeader = 'categories';
				} else {
					$catHeader = 'hidden-categories';
				}
				$catList = '';
				if ( $normalCount ) {
					$catList .= $this->assembleCatList( $normalCats, 'catlist-normal', 'categories' );
				}
				if ( $hiddenCount ) {
					$catList .= $this->assembleCatList( $hiddenCats, 'catlist-hidden', 'hidden-categories' );
				}
			}
		}
		if ( $catList ) {
			$this->outputSidebarChunk( 'catlinks-sidebar', $catHeader, $catList );
		}
	}
	private function assembleCatList( $list, $id, $message ) {
		$catList = '<div class="mw-portlet" id="' . $id . '"><h3>' . $this->getMsg( $message )->escaped() . '</h3>';
		$catList .= '<ul>';
		foreach ( $list as $category) {
			$title = Title::makeTitleSafe( NS_CATEGORY, $category );
			if ( !$title ) {
				continue;
			}
			$category = Linker::link( $title, $title->getText() );
			$catList .=  '<li>' . $category . '</li>';
		}
		$catList .= '</ul></div>';

		return $catList;
	}

	/*
	 * Output interlanguage links block
	 */
	private function outputInterlanguageLinks() {
		if ( $this->data['language_urls'] ) {
			$msgObj = $this->getMsg( 'otherlanguages' )->escaped();
			$content = $this->assemblePortlet( array(
					'id' => 'p-lang',
					'header' => $msgObj,
					'generated' => false,
					'content' => $this->data['language_urls']
				) );

			$this->outputSidebarChunk( 'other-languages', 'timeless-languages', $content );
		}
	}
}
