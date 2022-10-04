<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class RepositoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/repositories",
     *     tags={"Repositories"},
     *     summary="Returns all the repositories",
     *     description="List of all hospitals and universities registred.",
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
    public function repositories()
    {
        try {
                return response()->json([ 'repositories' => User::all() ], Response::HTTP_OK);

        } catch (Exception $e) {

                return response()->json([ 'message' => ['Error imprevisto', $e->getMessage() ] ], Response::HTTP_CONFLICT);
        }
    }

    /**
     * @OA\Get(
     *     path="api/v1/repository/{repositoryId}/projects",
     *     tags={"Repositories"},
     *     summary="Returns all the projects of the given repository",
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
    public function projects( Request $request )
    {
        try {
                $projects = $request->user()->projects;

                return response()->json([ 'projects' => $projects ], Response::HTTP_OK);

        } catch (Exception $e) {

                return response()->json([ 'message' => ['Error imprevisto', $e->getMessage() ] ], Response::HTTP_CONFLICT);
        }
    }
}
