<?php

namespace Ecommerce\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVisits extends Migration {
	public function up() {
		$this->forge->addField([
			'visit_id' => [
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
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
		]);
		$this->forge->addKey('visit_id', TRUE);
		$this->forge->createTable('visits');
	}

	public function down() {
		$this->forge->dropTable('visits');
	}
}
