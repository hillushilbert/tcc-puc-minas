<?php 


    /**
     * @OA\Get(
     *     path="/mic/clientes",
     *     description="Retorna a lista de clientes cadastrados",
     *     tags={"InformacoesCadastrais"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id do cliente",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="successful operation",
     *     @OA\JsonContent(ref="#/components/schemas/Customer"),
     * ),
     *     @OA\Response(
     *         response=422,
     *         description="Missing Data",
     *         @OA\JsonContent()
     *     )
     * )
     */  

    /**
     * @OA\Post(
     *     path="/mic/clientes",
     *     description="Armazena um novo cliente",
     *     security={{"bearerAuth":{}}},
     *     tags={"InformacoesCadastrais"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Customer"),
     *    ),
     *     @OA\Response(
     *         response=201,
     *         description="OK",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Missing Data",
     *         @OA\JsonContent()
     *     )
     * )
     */     

     /**
     * @OA\Get(
     *     path="/mic/clientes/{id}",
     *     description="Retorna um cliente cadastrado",
     *     tags={"InformacoesCadastrais"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id do cliente",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="successful operation",
     *     @OA\JsonContent(ref="#/components/schemas/Customer"),
     * ),
     *     @OA\Response(
     *         response=422,
     *         description="Missing Data",
     *         @OA\JsonContent()
     *     )
     * )
     */ 


     /**
     * @OA\Delete(
     *     path="/mic/clientes/{id}",
     *     description="Remove um cliente cadastrado",
     *     tags={"InformacoesCadastrais"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id do cliente",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     * @OA\Response(
     *     response=204,
     *     description="successful operation",
     *     @OA\JsonContent(ref="#/components/schemas/Customer"),
     * ),
     *     @OA\Response(
     *         response=422,
     *         description="Missing Data",
     *         @OA\JsonContent()
     *     )
     * )
     */ 

     /**
     * @OA\Put(
     *     path="/mic/clientes/{id}",
     *     description="Atualiza um cliente cadastrado",
     *     tags={"InformacoesCadastrais"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id do cliente",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="successful operation",
     *     @OA\JsonContent(ref="#/components/schemas/Customer"),
     * ),
     *     @OA\Response(
     *         response=422,
     *         description="Missing Data",
     *         @OA\JsonContent()
     *     )
     * )
     */