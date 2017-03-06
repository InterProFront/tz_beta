<?php

namespace App\Http\Controllers;

use App\Pageview;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Jenssegers\Date\Date;

class PullController extends Controller
{

    /**
     * @return void
     */
    public function __construct()
    {

    }

    public function draw()
    {
        return view('pulling');
    }

    function pullChanges(Request $request)
    {


        $validator = Validator::make(
            $request->all(),
            [
                'project_id' => 'required|integer',
                'page_id' => 'required|integer',
                'last_update' => 'integer',
            ]
        );

        $project_id = (int) $request->input('project_id');
        $page_id = (int) $request->input('page_id');
        if($request->has('last_update'))
        {
            $last_update = (int) $request->input('last_update');
        }
        else
        {
            $last_update = time();
        }

        //--------------------------------------------------------------
        if($validator->fails()){
            return ['error' => true, 'error_message' => $validator->errors()->setFormat(':message<br>')->all()];
        }

        $page = DB::table('pages')->where('project_id', $project_id)->where('id', $page_id)->first();

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

        $max_thread_number = (int) $page['max_thread_number'];
        $max_comment_number = (int) $page['max_comment_number'];
//        Log::info($last_update);
//        $threads = DB::table('threads')->where('page_id', $page_id)->get();
//        foreach($threads as $item){
//            Log::info($item->updated_at->timestamp.'');
//        }


        $ruDate = Date::createFromTimestamp($last_update)->format('d F Y');
        $last_update_date = date('Y-m-d H:i:s', $last_update);

        $threads = DB::table('threads')->where('page_id', $page_id)->where('updated_at', '>', $last_update_date)->get();
        $comments = DB::table('comments')->where('page_id', $page_id)->where('updated_at', '>', $last_update_date)->get();

        $thread_count = count($threads);
        $comment_count = count($comments);


        if($thread_count > 0 or $comment_count > 0) //Если массив не пустой, значит в результате записи до максимальных номеров на странице
        {
            $pageview = Pageview::firstOrNew(['user_id' => $user->id, 'page_id' => $page_id]);
            $pageview->thread_last_number = $max_thread_number;
            $pageview->comment_last_number = $max_comment_number;
            $pageview->save();
        }
        else
        {
            $threads = [];
            $comments = [];
        }

        return ['error' => false, 'content' => [
                'threads' => $threads,
                'comments' => $comments],
                'last_update' => time(), 'error_message' => ''];
    }

}
