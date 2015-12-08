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

class TopContributors {
    /**
     * Hook callback
     *
     * @param string $input
     * @param array $args
     * @param Parser $parser
     * @return string
     */
    public static function ParserHook( $input, $args, $parser ) {
            $dbr = wfGetDB( DB_SLAVE );
            $res = $dbr->select(
                    'revision',
                    array( 'rev_user', 'rev_user_text', 'COUNT(*) AS `count`' ),
                    array(),
                    __METHOD__,
                    array(
                            'GROUP BY' => 'rev_user_text',
                            'ORDER BY' => 'count DESC',
                            'LIMIT' => '10',
                    )
            );
            if( $res && $dbr->numRows( $res ) > 0 ) {
                    $out = '<div class="mw-top-contributors"><ul>';
                    while( $row = $dbr->fetchObject( $res ) ) {
                            $out .= '<li>' . Linker::userLink( $row->rev_user, $row->rev_user_text )
                                    . ' [' . $row->count . ']</li>';
                    }
                    $dbr->freeResult( $res );
                    return $out . '</div>';
            } else {
                    return '';
            }
    }
}
