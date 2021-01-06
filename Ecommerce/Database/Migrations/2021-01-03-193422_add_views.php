<?php

namespace Ecommerce\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddViews extends Migration {
	public function up() {
		$this->forge->addField([
			'view_id' => [
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
			'duration' => [
				'type'       => 'INT',
				'constraint' => 16,
				'null'       => true
			],
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
		]);
		$this->forge->addKey('view_id', TRUE);
		$this->forge->createTable('views');
	}

	public function down() {
		$this->forge->dropTable('views');
	}
}
