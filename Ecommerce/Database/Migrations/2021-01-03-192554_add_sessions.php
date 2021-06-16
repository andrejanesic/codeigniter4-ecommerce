<?php

namespace Ecommerce\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSessions extends Migration {
	public function up() {
		$this->forge->addField([
			'session_id' => [
				'type'           => 'INT',
				'constraint'     => 8,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'visitor_id' => [
				'type'       => 'INT',
				'constraint' => 8,
				'unsigned'   => true
			],
			'utm_source' => [
				'type'       => 'VARCHAR',
				'constraint' => 150,
				'null'       => true
			],
			'utm_medium' => [
				'type'       => 'VARCHAR',
				'constraint' => 150,
				'null'       => true
			],
			'utm_campaign' => [
				'type'       => 'VARCHAR',
				'constraint' => 150,
				'null'       => true
			],
			'utm_term' => [
				'type'       => 'VARCHAR',
				'constraint' => 150,
				'null'       => true
			],
			'utm_content' => [
				'type'       => 'VARCHAR',
				'constraint' => 150,
				'null'       => true
			],
			'referrer' => [
				'type'       => 'VARCHAR',
				'constraint' => 100,
				'null'       => true
			],
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
		]);
		$this->forge->addKey('session_id', TRUE);
		$this->forge->createTable('sessions');
	}

	public function down() {
		$this->forge->dropTable('sessions');
	}
}
