<?php

class TopContributors {
	/**
	 * Hook callback
	 *
	 * @param string $input
	 * @param array $args
	 * @param Parser $parser
	 * @return string
	 */
	public static function ParserHook($input, $args, $parser) {
		$dbr = wfGetDB(DB_SLAVE);
		$res = $dbr->select(
			'revision',
			['rev_user', 'rev_user_text', 'COUNT(*) AS `count`'],
			[],
			__METHOD__,
			[
				'GROUP BY' => 'rev_user_text',
				'ORDER BY' => 'count DESC',
				'LIMIT' => '10',
			]
		);
		if ($res && $dbr->numRows($res) > 0) {
			$out = '<div class="mw-top-contributors"><ul>';
			while ($row = $dbr->fetchObject($res)) {
				$out .= '<li>' . Linker::userLink($row->rev_user, $row->rev_user_text) . ' [' . $row->count . ']</li>';
			}
			$dbr->freeResult($res);
			return $out . '</div>';
		} else {
			return '';
		}
	}
}
