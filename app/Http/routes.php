<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function(){
    return redirect()->to('/projects');
});

Route::auth();

//-------------------------------------------------------
Route::group(['middleware' => 'auth'], function()
{
    Route::get('/options', 'FrontController@userOptions');

    Route::get('/projects', 'FrontController@getProjects');
    Route::get('/projects/add', 'FrontController@addProject');

    Route::get('/project/{slug}', 'FrontController@getProjectItem');
    Route::get('/project/{slug}/add', 'FrontController@addPages');

    Route::get('/project/{project_slug}/page/{page_slug}', 'FrontController@getPage');




    Route::post('get_current_user', 'UserController@getCurrentUser');
    Route::post('get_user', 'UserController@getUser');
    Route::post('add_member', 'ProjectController@addMember');
    // system routes
    Route::post('pull_changes', ['as' => 'pull_changes', 'uses' => 'PullController@pullChanges']);
    Route::post('update_thread', ['as' => 'update_thread', 'uses' => 'ThreadController@updateThread']);
    Route::post('update_comment', ['as' => 'update_comment', 'uses' => 'CommentController@updateComment']);

    Route::post('update_page', ['as' => 'update_page', 'uses' => 'PageController@updatePage']);
    Route::post('update_project', ['as' => 'update_project', 'uses' => 'ProjectController@updateProject']);

    Route::post('update_user', ['as' => 'update_user', 'uses' => 'UserController@updateUser']);
});
//-------------------------------------------------------
Route::get('/marks', function(){
    return view('front.test');
});




Route::get('draw_pulling', ['as' => 'draw_pulling', 'uses' => 'PullController@draw']);
Route::get('draw_thread', ['as' => 'draw_thread', 'uses' => 'ThreadController@drawthread']);
Route::get('draw_comment', ['as' => 'draw_comment', 'uses' => 'CommentController@drawcomment']);

Route::auth();

Route::get('/home', 'HomeController@index');
