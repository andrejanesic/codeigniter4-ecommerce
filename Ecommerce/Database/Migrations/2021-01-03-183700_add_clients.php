<?php

namespace Ecommerce\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClients extends Migration {
	public function up() {
		$this->forge->addField([
			'client_id' => [
				'type'           => 'INT',
				'constraint'     => 8,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'client_uid' => [
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'unique'     => true,
			],
			'password' => [
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'null'       => true
			],
			'token' => [
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'null'       => true
			],
			'email' => [
				'type'       => 'VARCHAR',
				'constraint' => 100,
				'null'       => true
			],
			'firstname' => [
				'type'       => 'VARCHAR',
				'constraint' => 50,
				'null'       => true
			],
			'lastname' => [
				'type'       => 'VARCHAR',
				'constraint' => 50,
				'null'       => true
			],
			'phone' => [
				'type'       => 'VARCHAR',
				'constraint' => 50,
				'null'       => true
			],
			'country' => [
				'type'       => 'VARCHAR',
				'constraint' => 2,
				'null'       => true
			],
			'state' => [
				'type'       => 'VARCHAR',
				'constraint' => 100,
				'null'       => true
			],
			'city' => [
				'type'       => 'VARCHAR',
				'constraint' => 100,
				'null'       => true
			],
			'zip' => [
				'type'       => 'VARCHAR',
				'constraint' => 50,
				'null'       => true
			],
			'address_1' => [
				'type'       => 'VARCHAR',
				'constraint' => 150,
				'null'       => true
			],
			'address_2' => [
				'type'       => 'VARCHAR',
				'constraint' => 150,
				'null'       => true
			],
			'last_ip' => [
				'type'       => 'VARCHAR',
				'constraint' => 15,
				'null'       => true
			],
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
			'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
		]);
		$this->forge->addKey('client_id', TRUE);
		$this->forge->createTable('clients');
	}

	public function down() {
		$this->forge->dropTable('clients');
	}
}
