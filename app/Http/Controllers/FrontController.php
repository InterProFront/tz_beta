<?php

namespace App\Http\Controllers;

use App\Page;
use App\Project;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{

    public  function userOptions(){
        return view('');
    }


    public function getProjects(){

        $project = Auth::user()->projects;
        return view('front.projects.projects-list',[
            'projects' => $project
        ]);
    }

    public function addProject(){
        return view('front.projects.project-add',[]);
    }

    public function getProjectItem( $slug ){
        $project = Project::where('slug',$slug)->first();
        $pages = $project->pages;

        return view('front.pages.pages-list',[
            'project' => $project,
            'pages'   => $pages
        ]);
    }
    public function addPages($slug){
        $project = Project::where('slug',$slug)->first();
        return view('front.pages.page-add', [
            'project' => $project
        ]);
    }

    public function getPage($project_slug, $page_slug){
        $project = Project::where('slug',$project_slug)->first();
        $page   = Page::where('slug', $page_slug)->first();

        return view('front.page.page',[
           'page' => $page,
           'project' => $project
        ]);
    }
}
