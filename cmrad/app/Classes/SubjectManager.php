<?php

namespace App\Classes;

use Illuminate\Support\Facades\Auth;
use App\Models\User as Repository;
use App\Models\Subject;
use App\Models\Project;

class SubjectManager
{
    /**
     * Return all repository projects
     */
    public static function create($name, $email, $repositoryId)
    {
        if( Repository::find($repositoryId) ){

            Subject::create([ 'name' => $name, 'email' => $email , 'repository_id' => $repositoryId]);
            return "Subject created successfully!";
        }

        return "This repository dosen't exists";
    }

    /**
     * Return subjects and the projects they are enrrollen in
     */
    public static function enrolledProjects(Repository $repository)
    {
        return Repository::where('id', $repository->id)->with('subjects.projects')->get();
    }

    /**
     * Return all repository projects
     */
    public static function assignProject($projectId, $subjectId)
    {

        $repository = Auth::user();

        //Check if this subject belongs to this repository
        $subject = Subject::find($subjectId);
        if( ! $repository->subjects->contains($subjectId) ){

            return "This subject is not associated with ".$repository->name;
        }

        //Check if repository owns this projects
        $project = Project::find($projectId);
        if( !$repository->projects->contains($project) ){

            return $repository->name." doesn't own this project!";
        }


        if( $subject ) {
            //Check if project is already attached to the subject
            $alreadyAttached = $subject->projects()->where('project_id', $projectId)->exists();

            if ( !$alreadyAttached ){

                $subject->projects()->attach($projectId);

                return "Subject enrolled successfully!";
            }

            return "Subject already enrolled to this project!";

        }
    }
}
