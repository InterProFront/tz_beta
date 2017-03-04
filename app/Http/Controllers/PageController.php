<?php

namespace App\Http\Controllers;

use App\Member;
use App\Page;
use App\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PageController extends Controller
{
    use GenerateSlugTrait;

    /**
     * @return void
     */
    public function __construct()
    {

    }

    public function drawpage()
    {
        return view('makepage');
    }

    /**
     * @param Request $request
     * @return array
     */
    function updatePage(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'project_id' => 'required|integer',
                'slug' => 'alpha_dash|unique:pages',
                'deleted' => 'boolean'
            ]
        );

        $project_id = (int) $request->input('project_id');

        //--------------------------------------------------------------
        if($validator->fails()){
            return ['error' => true, 'error_message' => $validator->errors()->setFormat(':message<br>')->all()];
        }

        try
        {
            $user = $request->user();

            $member = Member::where('project_id', $project_id)->where('user_id', $user->id)->first();

            if(!$member)
            {
                return ['error' => true, 'error_message' => 'Проект ('.$project_id.') не найден.'];
            }

            $project = Project::find($project_id);

            //--------------------------------------------------------------

            //[[[
            DB::beginTransaction();

            if($request->has('page_id'))
            {
                $page_id = (int) $request->input('page_id');
            }
            else
            {
                $page_id = 0;
            }

            $itnew = false;

            if ($page_id !== 0)
            {
                $page = Page::where('project_id', $project_id)->where('id', $page_id)->first();

                if(!$page)
                {
                    return ['error' => true, 'error_message' => 'Страница ('.$page_id.') проекта ('.$project_id.') не найдена.'];
                }

                $number = $page->number;
            }
            else
            {
                $number = $project->max_page_number+1;

                $page = new Page();

                $page->number = $number;
                $page->max_thread_number = 0;
                $page->max_comment_number = 0;
                $page->project_id = $project_id;
                $page->save();

                $project->max_page_number++;
                $project->save();

                $itnew = true;
            }

            if ($request->has('deleted'))
            {
                $page->deleted = (bool) $request->input('deleted');
            }

            if ($request->has('title'))
            {
                $page->title = $request->input('title');
            }

            if ($request->has('description'))
            {
                $page->description = $request->input('description');
            }

            /*if ($request->has('slug'))
            {
                $page->slug = $request->input('slug');
            }*/

            if($request->hasFile('picture'))
            {
                $uploadedFile = $request->file('picture');

                $file_path = '/files/projects/project_'.$project->id;
                $public_file_path = public_path() . $file_path;

                if(!File::isDirectory($public_file_path))
                {
                    File::makeDirectory($public_file_path, $mode = 0755);
                }

                $file_name = 'page'.$page->id.'.'.$uploadedFile->guessClientExtension();

                $uploadedFile->move(
                    $public_file_path,
                    $file_name
                );

                chmod($public_file_path.'/'.$file_name, 0644);

                $page->picture = $file_path.'/'.$file_name;
            }

            if($itnew)
            {
                $page->slug = $this->generateSlug($page->id).'_page';
            }

            $page->save();

            DB::commit();
            //]]]
        }
        catch(\Exception $e)
        {
            return ['error' => true, 'error_message' => $e->getMessage()];
        }

        return ['error' => false, 'number' => $number, 'error_message' => ''];
    }

}
