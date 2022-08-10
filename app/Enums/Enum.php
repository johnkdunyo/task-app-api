<?php 
namespace App\Enums;

enum TaskStatus: string {
    case TODO = 'TODO';
    case PROGRESS = 'PROGRESS';
    case COMPLETED = 'completed';
};


?>