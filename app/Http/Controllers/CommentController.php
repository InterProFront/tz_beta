<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Page;
use App\Thread;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CommentController extends Controller
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

    public function drawcomment()
    {
        return view('makecomment');
    }

    /**
     * @param Request $request
     * @return array
     */
    function updateComment(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'project_id' => 'required|integer',
                'page_id' => 'required|integer',
                'thread_number' => 'required|integer',
                'deleted' => 'boolean'
            ]
        );

        $project_id    = (int) $request->input('project_id');
        $page_id       = (int) $request->input('page_id');
        $thread_number = (int) $request->input('thread_number');

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

            $thread = Thread::where('project_id', $project_id)->where('page_id', $page_id)->where('number', $thread_number)->first();

            if(!$thread)
            {
                return ['error' => true, 'error_message' => 'Трэд ('.$thread_number.') страницы ('.$page_id.') проекта ('.$project_id.') не найден.'];
            }
            //--------------------------------------------------------------

            //[[[
            DB::beginTransaction();

            if($request->has('in_page_number'))
            {
                $in_page_number = (int) $request->input('in_page_number');
            }
            else
            {
                $in_page_number = 0;
            }

            $itnew = false;

            if ($in_page_number !== 0)
            {
                $comment = Comment::where('project_id', $project_id)->where('page_id', $page_id)->where('in_page_number', $in_page_number)->first();

                if(!$comment)
                {
                    return ['error' => true, 'error_message' => 'Коммент ('.$in_page_number.') страницы ('.$page_id.') проекта ('.$project_id.') не найден.'];
                }
            }
            else
            {
                $in_page_number = $page->max_comment_number+1;
                $in_thread_number = $thread->max_comment_number+1;

                $comment = new Comment();
                $comment->in_page_number = $in_page_number;
                $comment->in_thread_number = $in_thread_number;
                $comment->thread_id = $thread->id;
                $comment->project_id = $page->project_id;
                $comment->page_id = $page_id;
                $comment->author_id = $user->id;
                $comment->save();

                $itnew = true;

                $page->max_comment_number++;
                $page->save();

                $thread->max_comment_number++;
                $thread->save();
            }

            if ($request->has('deleted'))
            {
                $comment->deleted = (bool) $request->input('deleted');
            }

            if ($request->has('description'))
            {
                $comment->description = $request->input('description');
            }

            if($itnew)
            {
                $comment->slug = $this->generateSlug($comment->id).'_comment';
            }

            $comment->save();

            DB::commit();
            //]]]
        }
        catch(\Exception $e)
        {
            return ['error' => true, 'error_message' => $e->getMessage()];
        }

        return ['error' => false, 'in_page_number' => $in_page_number, 'error_message' => ''];
    }

}
