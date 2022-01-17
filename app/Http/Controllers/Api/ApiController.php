<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\NotifyAdminAboutDocumentUpload;
use App\Jobs\NotifyEmployerAboutRating;
use App\User;
use App\Post;
use App\UserWebsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Mail;
use Notification;
use URL;
use Validator;

class ApiController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('api');
    }

    /**
     * @OA\Post(
     *      path="/api/create-post",
     *      operationId="users.createPost",
     *      tags={"Websites"},
     *      summary="Create new post for website",
     *      description="Create new post for website",
     *      @OA\Parameter(ref="#/components/parameters/X-localization"),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                  required={"website_id","title","description"},
     *                 @OA\Property(
     *                     property="website_id",
     *                     type="integer",
     *                     description="Website Id"
     *                 ),
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                 ),
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ApiModel")
     *       ),
     *
     *     )
     */
    public static function createPost(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'website_id' => 'required|integer|exists:websites,id',
                'title' => 'required|unique:posts,title',
                'description' => 'required',
            ]);

            if ($validator->fails()) {
                return response(array('success' => 0, 'statuscode' => 400, 'message' =>
                    $validator->getMessageBag()->first()), 400);
            }

            $post = Post::create($request->all());
            if ($post) {
                return response([
                    'success' => 1, 'statuscode' => 200,
                    'message' => __('Post successfully created!'), 'data' => $post,
                ], 200);
            } else {
                return response([
                    'success' => 0, 'statuscode' => 400,
                    'message' => __('Please try again!'), 'data' => [],
                ], 400);
            }
            return response([
                'success' => 0, 'statuscode' => 400,
                'message' => __('Please try again!'), 'data' => [],
            ], 400);
        } catch (\Exception $e) {
            return response(['success' => 0, 'statuscode' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/subscribe-website",
     *      operationId="users.subscribeWebsite",
     *      tags={"Websites"},
     *      summary="Subscribe website by user",
     *      description="Subscribe website by user",
     *      @OA\Parameter(ref="#/components/parameters/X-localization"),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                  required={"website_id","user_id"},
     *                 @OA\Property(
     *                     property="website_id",
     *                     type="integer",
     *                     description="Website Id"
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer",
     *                     description="User Id"
     *                 ),
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ApiModel")
     *       ),
     *
     *     )
     */
    public static function subscribeWebsite(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'website_id' => 'required|integer|exists:websites,id',
                'user_id' => 'required|integer|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response(array('success' => 0, 'statuscode' => 400, 'message' =>
                    $validator->getMessageBag()->first()), 400);
            }

            $subscribed = UserWebsite::updateOrCreate(['website_id'=>$request->website_id,'user_id'=>$request->user_id], $request->all());
            if ($subscribed) {
                return response([
                    'success' => 1, 'statuscode' => 200,
                    'message' => __('user successfully subscribed!'), 'data' => $subscribed,
                ], 200);
            } else {
                return response([
                    'success' => 0, 'statuscode' => 400,
                    'message' => __('Please try again!'), 'data' => [],
                ], 400);
            }
            return response([
                'success' => 0, 'statuscode' => 400,
                'message' => __('Please try again!'), 'data' => [],
            ], 400);
        } catch (\Exception $e) {
            return response(['success' => 0, 'statuscode' => 400, 'message' => $e->getMessage()], 400);
        }
    }
}
