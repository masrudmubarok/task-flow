<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="Task Flow API",
 *     version="1.0.0",
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="OAuth2",
 *     description="Enter token in format: 'Bearer {token}'"
 * )
 * 
 */
abstract class Controller
{
    //
}
