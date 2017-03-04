<?php

namespace App\Http\Controllers;

use App\Account;
use App\Member;
use App\Project;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use GenerateSlugTrait;

    /**
     * @return void
     */
    public function __construct()
    {

    }

    public function drawproject()
    {
        return view('makeproject');
    }

    /**
     * @param Request $request
     * @return array
     */
    function addMember(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email', //|exists:users,email
                'project_id' => 'required|integer'
            ]
        );

        if($validator->fails()){
            return ['error' => true, 'error_message' => $validator->errors()->setFormat(':message<br>')->all()];
        }

        $email = $request->input('email');
        $project_id = (int) $request->input('project_id');

        //[[[
        DB::beginTransaction();

        $user = $request->user();

        $account = Account::where('owner_id', $user->id);

        if(!$account)
        {
            return ['error' => true, 'error_message' => 'Пользователю ('.$user->email.') не принадлежит ни один проект.'];
        }

        $project = Project::where('project_id', $project_id)->first();

        if(!$project)
        {
            return ['error' => true, 'error_message' => 'Проект ('.$project_id.') не найден.'];
        }
        elseif($project->account_id !== $account->id)
        {
            return ['error' => true, 'error_message' => 'Проект ('.$project->slug.') не принадлежит пользователю ('.$user->email.').'];
        }

        $user_member = User::where('email', $email)->first();

        if(!$user_member)
        {
            return ['error' => true, 'error_message' => 'Пользователь ('.$email.') не найден.'];
        }

        $member = Member::where('project_id', $project_id)->where('user_id', $user_member->id)->first();

        if($member)
        {
            return ['error' => true, 'error_message' => 'Пользователь ('.$email.') уже добавлен к проекту ('.$project->slug.').'];
        }

        $member = new Member();
        $member->number = $project->max_member_number+1;
        $member->user_id = $user_member->id;
        $member->project_id = $project_id;
        $member->save();

        $project->max_member_number++;
        $project->save();

        DB::commit();
        //]]]

        return ['error' => false, 'number' => $member->number, 'error_message' => ''];
    }

    /**
     * @param Request $request
     * @return array
     */
    function updateProject(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'slug' => 'alpha_dash|unique:projects',
                'deleted' => 'boolean'
            ]
        );

        if($validator->fails()){
            return ['error' => true, 'error_message' => $validator->errors()->setFormat(':message<br>')->all()];
        }

        try
        {
            $user = $request->user();

            $account = Account::firstOrNew(['owner_id' => $user->id]);

            //--------------------------------------------------------------

            //[[[
            DB::beginTransaction();

            if($request->has('project_id'))
            {
                $project_id = (int) $request->input('project_id');
            }
            else
            {
                $project_id = 0;
            }

            $itnew = false;

            if ($project_id !== 0)
            {
                $member = Member::where('project_id', $project_id)->where('user_id', $user->id)->first();

                if(!$member or (int) $account->id !== (int) $member->account_id)
                {
                    return ['error' => true, 'error_message' => 'Проект ('.$project_id.') не найден.'];
                }

                $project = Project::find($project_id);

                if(!$project)
                {
                    return ['error' => true, 'error_message' => 'Проект ('.$project_id.') не найден.'];
                }

                $number = $project->number;
            }
            else
            {
                $number = $account->max_project_number+1;

                $account->max_project_number++;
                $account->save();

                $project = new Project();
                $project->number = $number;
                $project->max_page_number = 0;
                $project->max_member_number = 1;
                $project->account_id = $account->id;
                $project->save();

                $itnew = true;

                $member = new Member();
                $member->number = 1;
                $member->user_id = $user->id;
                $member->project_id = $project->id;
            }

            if ($request->has('deleted'))
            {
                $project->deleted = (bool) $request->input('deleted');
            }

            if ($request->has('title'))
            {
                $project->title = $request->input('title');
            }

            if ($request->has('description'))
            {
                $project->description = $request->input('description');
            }

            /*if ($request->has('slug'))
            {
                $project->slug = $request->input('slug');
            }*/

            if($itnew)
            {
                $project->slug = $this->generateSlug($project->id).'_project';
            }

            $project->save();
            $member->save();

            DB::commit();
            //]]]
        }
        catch(\Exception $e)
        {
            return ['error' => true, 'error_message' => $e->getMessage()];
        }

        return ['error' => false, 'content' => [
            'number' => $number,
            'slug' => $project->slug] , 'error_message' => ''];
    }

}
