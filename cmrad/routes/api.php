<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::group([ 'prefix' => 'v1'], function () {

    //Auth
    Route::post('register', 'Auth\AuthController@register');
    Route::post('token', 'Auth\AuthController@token');

    Route::group(['middleware' => 'auth:api'], function() {

        //Repository
        Route::get( 'repositories', 'Api\RepositoryController@repositories' );

        //Project
        Route::get('repository/{repositoryId}/projects', 'Api\RepositoryController@projects' );

        //Subject
        Route::get('repository/{repositoryId}/subjects', 'Api\SubjectController@subjectsWithProjects');
        Route::post('repository/{repositoryId}/subjects/create', 'Api\SubjectController@createSubject');
        Route::post('repository/{repositoryId}/subjects/{subjectId}/projects/{projectId}/assign','Api\SubjectController@assignProject');

        //Auth
        Route::post('logout','Auth\AuthController@logout');
    });
});
