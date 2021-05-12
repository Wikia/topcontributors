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
		if (class_exists(\ActorMigration::class)) {
			$actorQuery = \ActorMigration::newMigration()->getJoin('rev_user');
			$userTextField = $actorQuery['fields']['rev_user_text'];
		} else {
			$actorQuery = ['tables' => [], 'fields' => ['rev_user', 'rev_user_text'], 'joins' => []];
			$userTextField = 'rev_user_text';
		}

		$res = $dbr->select(
			['revision'] + $actorQuery['tables'],
			['COUNT(*) AS `count`'] + $actorQuery['fields'],
			[],
			__METHOD__,
			[
				'GROUP BY' => $userTextField,
				'ORDER BY' => 'count DESC',
				'LIMIT' => '10',
			],
			$actorQuery['joins']
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
