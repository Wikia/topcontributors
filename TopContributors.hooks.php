<?php
/**
 * Top Contributors
 * Parser hook extension adds a <topcontributors /> tag to the parser, giving a list of the ten most active users on a wiki
 *
 * @license		GNU General Public License v2.0 or later
 * @package		TopContributors
 * @link		https://gitlab.com/hydrawiki
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
