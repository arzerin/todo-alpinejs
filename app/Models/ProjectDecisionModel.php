<?php
namespace App\Models; use CodeIgniter\Model; class ProjectDecisionModel extends Model { protected $table='project_decisions'; protected $primaryKey='id'; protected $returnType='array'; protected $allowedFields=['project_id','meeting_id','source_type','source_id','title','decision_text','rationale','status','decided_at','decided_by','created_by']; protected $useTimestamps=true; }
