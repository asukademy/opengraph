<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

use Opengraph\Table\Table;
use Windwalker\Core\Migration\AbstractMigration;
use Windwalker\Database\Schema\Column;
use Windwalker\Database\Schema\Key;

/**
 * Migration class, version: 20150620111808
 */
class InitSystem extends AbstractMigration
{
	/**
	 * Migrate Up.
	 */
	public function up()
	{
		$this->db->getTable(Table::RESULTS)
			->addColumn(new Column\Primary('id'))
			->addColumn(new Column\Varchar('url'))
			->addColumn(new Column\Longtext('html'))
			->addColumn(new Column\Varchar('graph_id'))
			->addColumn(new Column\Longtext('graph_object'))
			->addColumn(new Column\Datetime('created'))
			->addColumn(new Column\Datetime('last_search'))
			->addColumn(new Column\Integer('searches'))
			->addColumn(new Column\Integer('hits'))
			->addIndex(Key::TYPE_INDEX, 'idx_url', 'url')
			->addIndex(Key::TYPE_INDEX, 'idx_graph_id', 'graph_id')
			->create();
	}

	/**
	 * Migrate Down.
	 */
	public function down()
	{
		$this->db->getTable(Table::RESULTS)->drop();
	}
}
