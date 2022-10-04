<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RepositoryPostRequest;
use App\Http\Requests\TokenPostRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Classes\RepositoryManager;
use Illuminate\Http\Response;
use App\Classes\AuthManager;
use Illuminate\Http\Request;
use App\Models\Repository;
use App\Models\User;
use Carbon\Carbon;
use Exception;

/**
* @OA\Info(title="API cmRad", version="1.0")
*
* @OA\Server(url="http://localhost:8000")
*/
class AuthController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/v1/register",
     *     tags={"Authtentication"},
     *     summary="Create a new repository",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Hospital de Mallorca"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="name@mail.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     example = "secret"
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
    public function register( RepositoryPostRequest $request )
    {
        try {

                $validated = $request->validated();
                RepositoryManager::createRepository($validated['name'], $validated['email'], $validated['password']);

                return response()->json([ 'message' => 'Organization successfully registered!'], Response::HTTP_CREATED);

        } catch (Exception $e) {

                return response()->json([ 'message' => ['Error imprevisto', $e->getMessage() ] ], Response::HTTP_CONFLICT);
        }

    }

    /**
     * @OA\Post(
     *     path="/api/v1/token",
     *     tags={"Authtentication"},
     *     summary="Create a Token to access de other endpoint using the repository credentials",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="hb@mail.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     example = "secret"
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
    public function token( TokenPostRequest $request )
    {
        try {

                $validated = $request->validated();
                $credentials = $request->only(['email', 'password']);

                //Validate credentials
                if (!Auth::attempt( $credentials )){

                    return response()->json( ['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED );
                }

                //Create token
                $accessToken = AuthManager::createToken( $request->user() );

                return response()->json(['access_token' => $accessToken,'token_type' => 'Bearer'], Response::HTTP_CREATED);

        } catch (Exception $e) {

            return response()->json([ 'message' => ['Error imprevisto', $e->getMessage() ] ], Response::HTTP_CONFLICT);
        }


    }

    /**
     * @OA\Post(
     *     path="/api/v1/logout",
     *     tags={"Authtentication"},
     *     summary="Revoke all tokens",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="hb@mail.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     example = "secret"
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
    public function logout( Request $request )
    {
        try {

            AuthManager::revokeToken( $request->user()->tokens );

            return response()->json([ 'message' => 'Successfully logged out'], Response::HTTP_OK);

        } catch (Exception $e) {

            return response()->json([ 'message' => ['Error imprevisto', $e->getMessage() ] ], Response::HTTP_CONFLICT);
        }
    }

}
