<?php
 /**
  * Top Contributors
  *
  * @author		Rob Church / gcardinal, Cameron Chunn
  * @package    Top Contributors
  *
 **/
 if ( function_exists( 'wfLoadExtension' ) ) {
 	wfLoadExtension( 'TopContributors' );
 	// Keep i18n globals so mergeMessageFileList.php doesn't break
 	$wgMessagesDirs['TopContributors'] = __DIR__ . '/i18n';
 	wfWarn(
 		'Deprecated PHP entry point used for Top Contributors extension. Please use wfLoadExtension instead, ' .
 		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
 	);
 	return;
 } else {
 	die( 'This version of the Top Contributors extension requires MediaWiki 1.25+' );
 }
