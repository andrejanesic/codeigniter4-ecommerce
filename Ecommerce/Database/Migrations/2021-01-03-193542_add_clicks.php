<?php

namespace Ecommerce\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClicks extends Migration {
	public function up() {
		$this->forge->addField([
			'click_id' => [
				'type'           => 'INT',
				'constraint'     => 8,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'session_id' => [
				'type'       => 'INT',
				'constraint' => 8,
				'unsigned'   => true
			],
			'path' => [
				'type' => 'TEXT',
				'null' => true
			],
			'element_id' => [
				'type'       => 'VARCHAR',
				'constraint' => 100,
				'null'       => true
			],
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
		]);
		$this->forge->addKey('click_id', TRUE);
		$this->forge->createTable('clicks');
	}

	public function down() {
		$this->forge->dropTable('clicks');
	}
}
