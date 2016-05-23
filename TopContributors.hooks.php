<?php
/**
 * Curse Inc.
 * Top Contributors
 * Parser hook extension adds a <topcontributors /> tag to the parser, giving a list of the ten most active users on a wiki
 *
 * @author		Cameron Chunn
 * @copyright	(c) 2015 Curse Inc.
 * @license		All Rights Reserved
 * @package		TopContributors
 * @link		http://www.curse.com/
 *
**/

class TopContributorsHooks {
	/**
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ParserFirstCallInit
	 * @param Parser $parser
	 * @return true
	 */
	public static function onParserFirstCallInit( Parser &$parser ) {
		$parser->setHook( 'topcontributors', 'TopContributors::ParserHook' );
		return true;
	}
}
