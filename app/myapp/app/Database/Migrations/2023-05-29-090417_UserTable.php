<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserTable extends Migration
{
    public function up()
    {
      $this->forge->addField([
          'user_id' => ['type' => 'VARCHAR', 'constraint' => 255],
          'user_name' => ['type' => 'VARCHAR', 'constraint' => 255],
          'user_password_hash' => ['type' => 'VARCHAR', 'constraint' => 255],
      ]);
      $this->forge->addKey('user_id', true);
      $this->forge->createTable('user');
    }

    public function down()
    {
      $this->forge->dropTable('user');
    }
}
