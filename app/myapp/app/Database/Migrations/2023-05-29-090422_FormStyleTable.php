<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FormStyleTable extends Migration
{
    public function up()
    {
      $this->forge->addField([
          'form_style_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
          'form_html' => ['type' => 'TEXT'],
          'form_css' => ['type' => 'TEXT'],
      ]);
      $this->forge->addKey('form_style_id', true);
      $this->forge->createTable('form_style');
    }

    public function down()
    {
      $this->forge->dropTable('form_style');
    }
}
