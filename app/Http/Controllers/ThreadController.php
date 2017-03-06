<?php

namespace App\Http\Controllers;

use App\Page;
use App\Thread;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    use GenerateSlugTrait;

    /**
     * @return void
     */
    public function __construct()
    {

    }

    public function drawthread()
    {
        return view('makethread');
    }


    function renumThreads($page_id, $current_number = 0)
    {
        //[[[
        DB::beginTransaction();

        $threads = Thread::where('page_id', $page_id)->where('deleted', false)->where('index_number', '>', $current_number)->get();

        $zero_threads = true;

        foreach($threads as $thread)
        {
            $thread->index_number = $current_number;
            $thread->save();
            $current_number++;

            $zero_threads = false;
        }

        DB::commit();
        //]]]

        return $zero_threads;
    }

    /**
     * @param Request $request
     * @return array
     */
    function updateThread(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'project_id' => 'required|integer',
                'page_id' => 'required|integer',
                'top' => 'required|integer',
                'left' => 'required|integer',
                'deleted' => 'boolean'
            ]
        );

        $project_id = (int) $request->input('project_id');
        $page_id    = (int) $request->input('page_id');
        $top        = (int) $request->input('top');
        $left       = (int) $request->input('left');

        //--------------------------------------------------------------
        if($validator->fails()){
            return ['error' => true, 'error_message' => $validator->errors()->setFormat(':message<br>')->all()];
        }

        try
        {
            $page = Page::where('project_id', $project_id)->where('id', $page_id)->first();

            if(!$page)
            {
                return ['error' => true, 'error_message' => 'Страница ('.$page_id.') проекта ('.$project_id.') не найдена.'];
            }

            $user = $request->user();

            $member = DB::table('members')->where('project_id', $project_id)->where('user_id', $user->id)->first();

            if(!$member)
            {
                return ['error' => true, 'error_message' => 'Страница ('.$page_id.') проекта ('.$project_id.') не найдена.'];
            }
            //--------------------------------------------------------------

            //[[[
            DB::beginTransaction();

            if($request->has('number'))
            {
                $number = (int) $request->input('number');
            }
            else
            {
                $number = 0;
            }

            $itnew = false;

            if ($number !== 0)
            {
                $thread = Thread::where('project_id', $project_id)->where('page_id', $page_id)->where('number', $number)->first();

                if(!$thread)
                {
                    return ['error' => true, 'error_message' => 'Трэд ('.$number.') страницы ('.$page_id.') проекта ('.$project_id.') не найден.'];
                }
            }
            else
            {
                $number = $page->max_thread_number+1;
                $index_number = $page->max_thread_index_number+1;

                $thread = new Thread();
                $thread->number = $number;
                $thread->top = $top;
                $thread->left = $left;
                $thread->project_id = $page->project_id;
                $thread->page_id = $page_id;
                $thread->author_id = $user->id;
                $thread->index_number = $index_number;
                $thread->save();

                $itnew = true;

                $page->max_thread_number++;
                $page->max_thread_index_number++;
            }

            $change_deleted = false;

            $current_number = 9999;

            if ($request->has('deleted'))
            {
                $thread->deleted = (bool) $request->input('deleted');

                $change_deleted = true;

                $current_number = $thread->index_number;
            }

            if ($request->has('title'))
            {
                $thread->title = $request->input('title');
            }

            if ($request->has('description'))
            {
                $thread->description = $request->input('description');
            }

            if($itnew)
            {
                $thread->slug = $this->generateSlug($thread->id).'_project';
            }

            $thread->save();

            DB::commit();
            //]]]

            if($change_deleted)
            {
                $zero_threads = $this->renumThreads($page_id, $current_number);

                if($zero_threads)
                {
                    $page->max_thread_number = 0;
                    $page->max_thread_index_number = 0;
                }
                else
                {
                    $page->max_thread_index_number--;
                }
            }

            if($itnew or $change_deleted)
            {
                $page->save();
            }
        }
        catch(\Exception $e)
        {
            return ['error' => true, 'error_message' => $e->getMessage()];
        }

        return ['error' => false,
                'content' =>[
                    'number' => $number,
                    'index_number' => $thread->index_number,
                    'id'     => $thread->id
                ],
                'error_message' => ''];
    }

}
