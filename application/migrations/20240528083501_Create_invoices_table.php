<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_invoices_table extends CI_Migration {

    public function up() {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'order_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ],
            'invoice_number' => [
                'type' => 'VARCHAR',
                'constraint' => '50'
            ],
            'issue_date' => [
                'type' => 'DATETIME'
            ],
            'due_date' => [
                'type' => 'DATETIME'
            ],
            'total_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2'
            ],
            'status' => [
                'type' => 'ENUM('draft','sent','paid','canceled')',
                'default' => 'draft'
            ],
            'pdf_path' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ]
        ]);
        
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('order_id');
        $this->dbforge->create_table('invoices');
    }

    public function down() {
        $this->dbforge->drop_table('invoices');
    }
}