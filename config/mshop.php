<?php
return array(
		'domains' => [
			'media' => 'media',
			'media/property' => 'media/property',
			'price' => 'price',
			'price/property' => 'price/property',
			'text' => 'text'
		],
		'standard' => [
			'subparts' => [
				'media' => 'media',
				'text' => 'text',
				/*'price' => 'price'*/
			],
		],
		'media' => [
			'standard' => [
				'subparts' => [
					'property' => 'property',
				],
			],
		],
		'price' => [
			'standard' => [
				'subparts' => [
					'property' => 'property',
				],
			],
		],

	'manager' => array(
		'lists' => array(
			'type' => array(
				'standard' => array(
					'delete' => array(
						'ansi' => '
							DELETE FROM "sw_slider_list_type"
							WHERE :cond AND siteid = ?
						'
					),
					'insert' => array(
						'ansi' => '
							INSERT INTO "sw_slider_list_type" ( :names
								"code", "domain", "label", "pos", "status",
								"mtime", "editor", "siteid", "ctime"
							) VALUES ( :values
								?, ?, ?, ?, ?, ?, ?, ?, ?
							)
						'
					),
					'update' => array(
						'ansi' => '
							UPDATE "sw_slider_list_type"
							SET :names
								"code" = ?, "domain" = ?, "label" = ?, "pos" = ?,
								"status" = ?, "mtime" = ?, "editor" = ?
							WHERE "siteid" = ? AND "id" = ?
						'
					),
					'search' => array(
						'ansi' => '
							SELECT :columns
								mserlity."id" AS "slider.lists.type.id", mserlity."siteid" AS "slider.lists.type.siteid",
								mserlity."code" AS "slider.lists.type.code", mserlity."domain" AS "slider.lists.type.domain",
								mserlity."label" AS "slider.lists.type.label", mserlity."status" AS "slider.lists.type.status",
								mserlity."mtime" AS "slider.lists.type.mtime", mserlity."editor" AS "slider.lists.type.editor",
								mserlity."ctime" AS "slider.lists.type.ctime", mserlity."pos" AS "slider.lists.type.position"
							FROM "sw_slider_list_type" AS mserlity
							:joins
							WHERE :cond
							ORDER BY :order
							OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
						',
						'mysql' => '
							SELECT :columns
								mserlity."id" AS "slider.lists.type.id", mserlity."siteid" AS "slider.lists.type.siteid",
								mserlity."code" AS "slider.lists.type.code", mserlity."domain" AS "slider.lists.type.domain",
								mserlity."label" AS "slider.lists.type.label", mserlity."status" AS "slider.lists.type.status",
								mserlity."mtime" AS "slider.lists.type.mtime", mserlity."editor" AS "slider.lists.type.editor",
								mserlity."ctime" AS "slider.lists.type.ctime", mserlity."pos" AS "slider.lists.type.position"
							FROM "sw_slider_list_type" AS mserlity
							:joins
							WHERE :cond
							ORDER BY :order
							LIMIT :size OFFSET :start
						'
					),
					'count' => array(
						'ansi' => '
							SELECT COUNT(*) AS "count"
							FROM (
								SELECT mserlity."id"
								FROM "sw_slider_list_type" as mserlity
								:joins
								WHERE :cond
								ORDER BY mserlity."id"
								OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
							) AS list
						',
						'mysql' => '
							SELECT COUNT(*) AS "count"
							FROM (
								SELECT mserlity."id"
								FROM "sw_slider_list_type" as mserlity
								:joins
								WHERE :cond
								ORDER BY mserlity."id"
								LIMIT 10000 OFFSET 0
							) AS list
						'
					),
					'newid' => array(
						'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
						'mysql' => 'SELECT LAST_INSERT_ID()',
						'oracle' => 'SELECT sw_slider_list_type_seq.CURRVAL FROM DUAL',
						'pgsql' => 'SELECT lastval()',
						'sqlite' => 'SELECT last_insert_rowid()',
						'sqlsrv' => 'SELECT @@IDENTITY',
						'sqlanywhere' => 'SELECT @@IDENTITY',
					),
				),
			),
			'standard' => array(
				'aggregate' => array(
					'ansi' => '
						SELECT "key", COUNT("id") AS "count"
						FROM (
							SELECT :key AS "key", mserli."id" AS "id"
							FROM "sw_slider_list" AS mserli
							:joins
							WHERE :cond
							GROUP BY :key, mserli."id"
							ORDER BY :order
							OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
						) AS list
						GROUP BY "key"
					',
					'mysql' => '
						SELECT "key", COUNT("id") AS "count"
						FROM (
							SELECT :key AS "key", mserli."id" AS "id"
							FROM "sw_slider_list" AS mserli
							:joins
							WHERE :cond
							GROUP BY :key, mserli."id"
							ORDER BY :order
							LIMIT :size OFFSET :start
						) AS list
						GROUP BY "key"
					'
				),
				'delete' => array(
					'ansi' => '
						DELETE FROM "sw_slider_list"
						WHERE :cond AND siteid = ?
					'
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "sw_slider_list" ( :names
							"parentid", "key", "type", "domain", "refid", "start", "end",
							"config", "pos", "status", "mtime", "editor", "siteid", "ctime"
						) VALUES ( :values
							?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
						)
					'
				),
				'update' => array(
					'ansi' => '
						UPDATE "sw_slider_list"
						SET :names
							"parentid"=?, "key" = ?, "type" = ?, "domain" = ?, "refid" = ?, "start" = ?,
							"end" = ?, "config" = ?, "pos" = ?, "status" = ?, "mtime" = ?, "editor" = ?
						WHERE "siteid" = ? AND "id" = ?
					'
				),
				'search' => array(
					'ansi' => '
						SELECT :columns
							mserli."id" AS "slider.lists.id", mserli."parentid" AS "slider.lists.parentid",
							mserli."siteid" AS "slider.lists.siteid", mserli."type" AS "slider.lists.type",
							mserli."domain" AS "slider.lists.domain", mserli."refid" AS "slider.lists.refid",
							mserli."start" AS "slider.lists.datestart", mserli."end" AS "slider.lists.dateend",
							mserli."config" AS "slider.lists.config", mserli."pos" AS "slider.lists.position",
							mserli."status" AS "slider.lists.status", mserli."mtime" AS "slider.lists.mtime",
							mserli."editor" AS "slider.lists.editor", mserli."ctime" AS "slider.lists.ctime"
						FROM "sw_slider_list" AS mserli
						:joins
						WHERE :cond
						ORDER BY :order
						OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
					',
					'mysql' => '
						SELECT :columns
							mserli."id" AS "slider.lists.id", mserli."parentid" AS "slider.lists.parentid",
							mserli."siteid" AS "slider.lists.siteid", mserli."type" AS "slider.lists.type",
							mserli."domain" AS "slider.lists.domain", mserli."refid" AS "slider.lists.refid",
							mserli."start" AS "slider.lists.datestart", mserli."end" AS "slider.lists.dateend",
							mserli."config" AS "slider.lists.config", mserli."pos" AS "slider.lists.position",
							mserli."status" AS "slider.lists.status", mserli."mtime" AS "slider.lists.mtime",
							mserli."editor" AS "slider.lists.editor", mserli."ctime" AS "slider.lists.ctime"
						FROM "sw_slider_list" AS mserli
						:joins
						WHERE :cond
						ORDER BY :order
						LIMIT :size OFFSET :start
					'
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mserli."id"
							FROM "sw_slider_list" AS mserli
							:joins
							WHERE :cond
							ORDER BY mserli."id"
							OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
						) AS list
					',
					'mysql' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mserli."id"
							FROM "sw_slider_list" AS mserli
							:joins
							WHERE :cond
							ORDER BY mserli."id"
							LIMIT 10000 OFFSET 0
						) AS list
					'
				),
				'newid' => array(
					'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
					'mysql' => 'SELECT LAST_INSERT_ID()',
					'oracle' => 'SELECT sw_slider_list_seq.CURRVAL FROM DUAL',
					'pgsql' => 'SELECT lastval()',
					'sqlite' => 'SELECT last_insert_rowid()',
					'sqlsrv' => 'SELECT @@IDENTITY',
					'sqlanywhere' => 'SELECT @@IDENTITY',
				),
			),
		),
		'type' => array(
			'standard' => array(
				'delete' => array(
					'ansi' => '
						DELETE FROM "sw_slider_type"
						WHERE :cond AND siteid = ?
					'
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "sw_slider_type" ( :names
							"code", "domain", "label", "pos", "status",
							"mtime", "editor", "siteid", "ctime"
						) VALUES ( :values
							?, ?, ?, ?, ?, ?, ?, ?, ?
						)
					'
				),
				'update' => array(
					'ansi' => '
						UPDATE "sw_slider_type"
						SET :names
							"code" = ?, "domain" = ?, "label" = ?, "pos" = ?,
							"status" = ?, "mtime" = ?, "editor" = ?
						WHERE "siteid" = ? AND "id" = ?
					'
				),
				'search' => array(
					'ansi' => '
						SELECT :columns
							mserty."id" AS "slider.type.id", mserty."siteid" AS "slider.type.siteid",
							mserty."domain" AS "slider.type.domain", mserty."code" AS "slider.type.code",
							mserty."label" AS "slider.type.label", mserty."status" AS "slider.type.status",
							mserty."mtime" AS "slider.type.mtime", mserty."editor" AS "slider.type.editor",
							mserty."ctime" AS "slider.type.ctime", mserty."pos" AS "slider.type.position"
						FROM "sw_slider_type" AS mserty
						:joins
						WHERE :cond
						ORDER BY :order
						OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
					',
					'mysql' => '
						SELECT :columns
							mserty."id" AS "slider.type.id", mserty."siteid" AS "slider.type.siteid",
							mserty."domain" AS "slider.type.domain", mserty."code" AS "slider.type.code",
							mserty."label" AS "slider.type.label", mserty."status" AS "slider.type.status",
							mserty."mtime" AS "slider.type.mtime", mserty."editor" AS "slider.type.editor",
							mserty."ctime" AS "slider.type.ctime", mserty."pos" AS "slider.type.position"
						FROM "sw_slider_type" AS mserty
						:joins
						WHERE :cond
						ORDER BY :order
						LIMIT :size OFFSET :start
					'
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mserty."id"
							FROM "sw_slider_type" AS mserty
							:joins
							WHERE :cond
							ORDER BY mserty."id"
							OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
						) AS list
					',
					'mysql' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mserty."id"
							FROM "sw_slider_type" AS mserty
							:joins
							WHERE :cond
							ORDER BY mserty."id"
							LIMIT 10000 OFFSET 0
						) AS list
					'
				),
				'newid' => array(
					'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
					'mysql' => 'SELECT LAST_INSERT_ID()',
					'oracle' => 'SELECT sw_slider_type_seq.CURRVAL FROM DUAL',
					'pgsql' => 'SELECT lastval()',
					'sqlite' => 'SELECT last_insert_rowid()',
					'sqlsrv' => 'SELECT @@IDENTITY',
					'sqlanywhere' => 'SELECT @@IDENTITY',
				),
			),
		),
		'standard' => array(
			'delete' => array(
				'ansi' => '
					DELETE FROM "sw_slider"
					WHERE :cond AND siteid = ?
				'
			),
			'insert' => array(
				'ansi' => '
					INSERT INTO "sw_slider" ( :names
						"pos", "type", "code", "label", "provider", "start", "end",
						"config", "status", "domain", "mtime", "editor", "siteid", "ctime"
					) VALUES ( :values
						?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
					)
				'
			),
			'update' => array(
				'ansi' => '
					UPDATE "sw_slider"
					SET :names
						"pos" = ?, "type" = ?, "code" = ?, "label" = ?, "provider" = ?, "start" = ?,
						"end" = ?, "config" = ?, "status" = ?, "domain" = ?, "mtime" = ?, "editor" = ?
					WHERE "siteid" = ? AND "id" = ?
				'
			),
			'search' => array(
				'ansi' => '
					SELECT :columns
						mser."id" AS "slider.id", mser."siteid" AS "slider.siteid",
						mser."pos" AS "slider.position", mser."type" AS "slider.type",
						mser."code" AS "slider.code", mser."label" AS "slider.label",
						mser."provider" AS "slider.provider", mser."config" AS "slider.config",
						mser."start" AS "slider.datestart", mser."end" AS "slider.dateend",
						mser."status" AS "slider.status", mser."mtime" AS "slider.mtime",
						mser."domain" AS "slider.domain", mser."domain" AS "slider.domain",
						mser."editor" AS "slider.editor",	mser."ctime" AS "slider.ctime"
					FROM "sw_slider" AS mser
					:joins
					WHERE :cond
					GROUP BY :columns :group
						mser."id", mser."siteid", mser."pos", mser."type", mser."code", mser."label",
						mser."provider", mser."config", mser."start", mser."end", mser."status", mser."domain", mser."mtime",
						mser."editor",	mser."ctime"
					ORDER BY :order
					OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
				',
				'mysql' => '
					SELECT :columns
						mser."id" AS "slider.id", mser."siteid" AS "slider.siteid",
						mser."pos" AS "slider.position", mser."type" AS "slider.type",
						mser."code" AS "slider.code", mser."label" AS "slider.label",
						mser."provider" AS "slider.provider", mser."config" AS "slider.config",
						mser."start" AS "slider.datestart", mser."end" AS "slider.dateend",
						mser."status" AS "slider.status", mser."mtime" AS "slider.mtime",
						mser."domain" AS "slider.domain", mser."domain" AS "slider.domain",
						mser."editor" AS "slider.editor",	mser."ctime" AS "slider.ctime"
					FROM "sw_slider" AS mser
					:joins
					WHERE :cond
					GROUP BY :group mser."id"
					ORDER BY :order
					LIMIT :size OFFSET :start
				'
			),
			'count' => array(
				'ansi' => '
					SELECT count(*) as "count"
					FROM (
						SELECT mser."id"
						FROM "sw_slider" AS mser
						:joins
						WHERE :cond
						GROUP BY mser."id"
						ORDER BY mser."id"
						OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
					) AS list
				',
				'mysql' => '
					SELECT count(*) as "count"
					FROM (
						SELECT mser."id"
						FROM "sw_slider" AS mser
						:joins
						WHERE :cond
						GROUP BY mser."id"
						ORDER BY mser."id"
						LIMIT 10000 OFFSET 0
					) AS list
				'
			),
			'newid' => array(
				'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
				'mysql' => 'SELECT LAST_INSERT_ID()',
				'oracle' => 'SELECT sw_slider_seq.CURRVAL FROM DUAL',
				'pgsql' => 'SELECT lastval()',
				'sqlite' => 'SELECT last_insert_rowid()',
				'sqlsrv' => 'SELECT @@IDENTITY',
				'sqlanywhere' => 'SELECT @@IDENTITY',
			),
		),
	),
);
