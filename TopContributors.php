<?php
 
/**
 * Parser hook extension adds a <topcontributors /> tag to the parser,
 * giving a list of the ten most active users on a wiki
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */
if( defined( 'MEDIAWIKI' ) ) {
 
        $wgExtensionFunctions[] = 'efTopContributorsSetup';
        $wgExtensionCredits['parserhook'][] = array(
                'name' => 'Top Contributors',
                'author' => 'Rob Church',
                'description' => 'Lists the ten most active contributors to a wiki',
        );
 
        /**
         * Extension setup function
         */
        function efTopContributorsSetup() {
                global $wgParser;
                $wgParser->setHook( 'topcontributors', 'efTopContributors' );
        }
 
        /**
         * Hook callback
         *
         * @param string $input
         * @param array $args
         * @param Parser $parser
         * @return string
         */
        function efTopContributors( $input, $args, $parser ) {
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
                        $skin = $parser->getOptions()->getSkin();
                        while( $row = $dbr->fetchObject( $res ) ) {
                                $out .= '<li>' . $skin->userLink( $row->rev_user, $row->rev_user_text )
                                        . ' [' . $row->count . ']</li>';
                        }
                        $dbr->freeResult( $res );
                        return $out . '</div>';
                } else {
                        return '';
                }
        }
 
} else {
        echo( "This file is an extension to the MediaWiki software, and cannot be used standalone.\n" );
        exit( 1 );
}

?>