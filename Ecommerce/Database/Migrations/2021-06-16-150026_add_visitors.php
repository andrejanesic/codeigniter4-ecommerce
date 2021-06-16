<?php

namespace Ecommerce\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVisitors extends Migration {
	public function up() {
		$this->forge->addField([
			'visitor_id' => [
				'type'           => 'INT',
				'constraint'     => 8,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'visitor_uuid' => [
				'type'       => 'VARCHAR',
				'constraint' => 16,
				'unique'     => true,
			],
			'visitor_token' => [
				'type'       => 'VARCHAR',
				'constraint' => 32,
				'unique'     => true,
			],
			'contact_id' => [
				'type'       => 'INT',
				'constraint' => 8,
				'unsigned'   => true,
				'null'       => true,
			],
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
			'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
			'deleted_at DATETIME DEFAULT NULL',
		]);
		$this->forge->addKey('visitor_id', TRUE);
		$this->forge->createTable('visitors');
	}

	public function down() {
		$this->forge->dropTable('visitors');
	}
}
