<?php

namespace App\Traits;

use App\EmployeeRelation;
use App\Employee;
use App\ProjectAssign;

trait CommonProjectFunctions
{

    private function ProjectAssignEmployee($haed_employeer_ids, $project_id)
    {

            ProjectAssign::where('project_id', $project_id)->delete();

            $dataInsert = array();
            foreach ($haed_employeer_ids as $assinee) {

                $emloyees = EmployeeRelation::select('employee_child_id')->where('employee_id', '=', $assinee)->get();
                //dd($safety_assignee[0]);
                foreach ($emloyees as $emloyee) {
                    $dataInsert[] = array('project_id' => $project_id, 'employee_id' => $emloyee->employee_child_id, 'employee_head_id' => $assinee);
                }

                $dataInsert[] = array('project_id' => $project_id, 'employee_id' => $assinee, 'employee_head_id' => 0);

            }
            if (count($dataInsert) > 0) {
                ProjectAssign::insert($dataInsert); // Eloquent approach
            }
    }

    private function ProjectAssignNewEmployee($haed_employeer_id,$assinee ,$projects)
    {
        foreach ($projects as $project) {
            ProjectAssign::insert(['project_id' => $project->id, 'employee_id' => $assinee, 'employee_head_id' => $haed_employeer_id]); // Eloquent approach
        }
    }

    private function GenerateProjectCode($n)
    {
        $n=$n;

        // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters=array('ا','ب','ت','و','ه','ن','م','ل','ك','ق','ف','غ','ع','ظ','ط','ض','ش','س','ز','ر','ذ','د','خ','ح','ج','ث','ي');
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, count($characters) - 1);
            $randomString .= ' '.$characters[$index];
        }

        return $randomString;

    }

    private function GeneratePassword( $length ) {

        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars),0,$length);

    }
}
