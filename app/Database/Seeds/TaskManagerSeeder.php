<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TaskManagerSeeder extends Seeder
{
    public function run()
    {
        $taskTable = $this->db->table('tasks');
        $projectTable = $this->db->table('projects');

        $taskTable->emptyTable();
        $projectTable->emptyTable();

        $now = date('Y-m-d H:i:s');

        $projectTable->insertBatch([
            ['name'=>'Website Redesign','color'=>null,'created_at'=>$now],
            ['name'=>'CRM Development','color'=>'blue','created_at'=>$now],
            ['name'=>'Mobile App','color'=>'orange','created_at'=>$now],
            ['name'=>'BD Booking','color'=>'purple','created_at'=>$now],
        ]);

        $rows = $projectTable->select('id,name')->get()->getResultArray();
        $ids = [];
        foreach ($rows as $row) {
            $ids[$row['name']] = (int) $row['id'];
        }

        $taskTable->insertBatch([
            ['project_id'=>$ids['Website Redesign'],'body'=>'Design homepage','assignee'=>'John','due_date'=>'2026-09-28','completed'=>0,'created_at'=>$now],
            ['project_id'=>$ids['Website Redesign'],'body'=>'Build login page','assignee'=>'Alex','due_date'=>'2026-09-29','completed'=>0,'created_at'=>$now],
            ['project_id'=>$ids['Website Redesign'],'body'=>'Make dashboard responsive','assignee'=>'Sarah','due_date'=>'2026-09-30','completed'=>0,'created_at'=>$now],
            ['project_id'=>$ids['Website Redesign'],'body'=>'Create initial wireframes','assignee'=>'John','due_date'=>'2026-09-22','completed'=>1,'created_at'=>$now],

            ['project_id'=>$ids['CRM Development'],'body'=>'Create customer pipeline','assignee'=>'Zerin','due_date'=>'2026-10-02','completed'=>0,'created_at'=>$now],
            ['project_id'=>$ids['CRM Development'],'body'=>'Build lead assignment workflow','assignee'=>'Alex','due_date'=>'2026-10-04','completed'=>0,'created_at'=>$now],
            ['project_id'=>$ids['CRM Development'],'body'=>'Create database schema','assignee'=>'Zerin','due_date'=>'2026-09-24','completed'=>1,'created_at'=>$now],

            ['project_id'=>$ids['Mobile App'],'body'=>'Create Flutter splash screen','assignee'=>'Sarah','due_date'=>'2026-10-01','completed'=>0,'created_at'=>$now],
            ['project_id'=>$ids['Mobile App'],'body'=>'Connect login API','assignee'=>'Zerin','due_date'=>'2026-10-03','completed'=>0,'created_at'=>$now],
            ['project_id'=>$ids['Mobile App'],'body'=>'Configure project repository','assignee'=>'Alex','due_date'=>'2026-09-23','completed'=>1,'created_at'=>$now],

            ['project_id'=>$ids['BD Booking'],'body'=>'Complete WhatsApp room selection flow','assignee'=>'Zerin','due_date'=>'2026-09-28','completed'=>0,'created_at'=>$now],
            ['project_id'=>$ids['BD Booking'],'body'=>'Create tentative booking endpoint','assignee'=>'Zerin','due_date'=>'2026-09-30','completed'=>0,'created_at'=>$now],
            ['project_id'=>$ids['BD Booking'],'body'=>'Test hotel PID context','assignee'=>'John','due_date'=>'2026-09-21','completed'=>1,'created_at'=>$now],
            ['project_id'=>$ids['BD Booking'],'body'=>'Test Near Me hotel search','assignee'=>'John','due_date'=>'2026-09-22','completed'=>1,'created_at'=>$now],
        ]);
    }
}
