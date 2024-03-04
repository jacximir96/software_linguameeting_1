<?php

namespace App\Http\Controllers;

use App\Models\InstructorHelpType;
use Illuminate\Http\Request;

class InstructorHelpTypeController extends Controller
{
    public function index()
    {
        $instructorHelpTypes = InstructorHelpType::with(['helps' => function ($query) {

            $query->whereNull('deleted_at')->orderBy('description');
        }])->get();
    
        return view('instructor.help.index', compact('instructorHelpTypes'));
    }
}
