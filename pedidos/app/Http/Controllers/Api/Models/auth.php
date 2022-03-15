<?php 

    /**
     * @OA\Post(
     *     path="/auth/token",
     *     operationId="authToken",
     *     description="Recupera o token de autenticação JWT",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AuthToken"),
     *     ),
     *     @OA\Response(
     *         description="Open-id connect response",
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/AuthTokenResponse")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Missing Data",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorModel")
     *     )
     * )
     */


    /**
     * @OA\Post(
     *     path="/auth/refresh_token",
     *     operationId="RefreshToken",
     *     description="Recupera o token de autenticação JWT",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         description="Open-id connect response",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RefreshTokenRequest"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/AuthTokenResponse")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Missing Data",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorModel")
     *     )
     * )
     */

     /**
     * @OA\Post(
     *     path="/auth/logout",
     *     operationId="AuthLogout",
     *     description="Recupera o token de autenticação JWT",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         description="Open-id connect response",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RefreshTokenRequest"),
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Missing Data",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorModel")
     *     )
     * )
     */


/**
 *  @OA\Schema(
 *   schema="AuthToken",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/AuthToken"),
 *       @OA\Schema(
 *           required={"email","password"},
 *           @OA\Property(property="email", type="string", format="email"),
 *           @OA\Property(property="password", type="string"),
 *       )
 *   }
 * )
 */

/**
 *  @OA\Schema(
 *   schema="RefreshTokenRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/RefreshTokenRequest"),
 *       @OA\Schema(
 *           required={"refresh_token"},
 *           @OA\Property(property="refresh_token", type="string"),
 *       )
 *   }
 * )
 */

 /**
 *  @OA\Schema(
 *   schema="AuthTokenResponse",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/AuthTokenResponse"),
 *       @OA\Schema(
 *           required={"email","password"},
 *           @OA\Property(property="access_token", type="string"),
 *           @OA\Property(property="expires_in", type="string"),
 *           @OA\Property(property="refresh_expires_in", type="string"),
 *           @OA\Property(property="refresh_token", type="string"),
 *           @OA\Property(property="token_type", type="string"),
 *       )
 *   }
 * )
 */
