<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateSubjectPostRequest;
use App\Http\Requests\AssignSubjectPostRequest;
use App\Http\Controllers\Controller;
use App\Classes\SubjectManager;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\User;
use Exception;

class SubjectController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/repository/{repositoryId}/subjects",
     *     tags={"Subjects"},
     *     summary="Returns all the subjects with the projects they are enrolled in.",
     *     @OA\Response(
     *         response=200,
     *         description="Request has succeeded"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Request returned KO",
     *     )
     * )
     */
    public function subjectsWithProjects( Request $request )
    {
        try {
                $response = SubjectManager::enrolledProjects($request->user());

                return response()->json([ 'message' => $response ], Response::HTTP_OK);

        } catch (Exception $e) {

                return response()->json([ 'message' => ['Error imprevisto', $e->getMessage() ] ], Response::HTTP_CONFLICT);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/repository/{repositoryId}/subjects/create",
     *     tags={"Subjects"},
     *     summary="Let's the repositories create new subjects",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Marco Polo"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="name@mail.com"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Request has succeeded"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Request returned KO",
     *     )
     * )
     */
    public function createSubject( CreateSubjectPostRequest $request )
    {
        try {
                $validated = $request->validated();
                $response = SubjectManager::create($validated['name'], $validated['email'], $request->user()->id);

                return response()->json([ 'message' => $response ], Response::HTTP_CREATED);

        } catch (Exception $e) {

                return response()->json([ 'message' => ['Error imprevisto', $e->getMessage() ] ], Response::HTTP_CONFLICT);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/repository/{repositoryId}/subjects/{subjectId}/projects/{projectId}/assign",
     *     tags={"Subjects"},
     *     summary="Associate a subject with a project",
     *     @OA\Response(
     *         response=200,
     *         description="Request has succeeded"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Request returned KO",
     *     )
     * )
     */
    public function assignProject( Request $request )
    {
        try {
                $response = SubjectManager::assignProject($request->projectId, $request->subjectId);

                return response()->json([ 'message' => $response ], Response::HTTP_OK);

        } catch (Exception $e) {

                return response()->json([ 'message' => ['Error imprevisto', $e->getMessage() ] ], Response::HTTP_CONFLICT);
        }
    }

}
