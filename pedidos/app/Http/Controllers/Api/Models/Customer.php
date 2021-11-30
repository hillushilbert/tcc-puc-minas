<?php

namespace App\Http\Controllers\Api\Models;

/**
 * @OA\Schema(schema="NewCustomer", required={"name"})
 */


/**
 *  @OA\Schema(
 *   schema="Customer",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/Customer"),
 *       @OA\Schema(
 *           required={"name"},
 *           @OA\Property(property="id", format="int64", type="integer"),
 *           @OA\Property(property="name", type="string"),
 *           @OA\Property(property="email", type="string", format="email"),
 *           @OA\Property(property="birth_date", type="string", format="date-time"),
 *       )
 *   }
 * )
 */


 /**
 *  @OA\Schema(
 *   schema="Adress",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/Adress"),
 *       @OA\Schema(
 *           required={"name"},
 *           @OA\Property(property="street", type="string"),
 *           @OA\Property(property="number", type="integer", format="int64"),
 *           @OA\Property(property="city", type="string"),
 *           @OA\Property(property="state", type="string"),
 *           @OA\Property(property="country", type="string"),
 *           @OA\Property(property="active", type="boolean"),
 *       )
 *   }
 * )
 */


 /**
 *  @OA\Schema(
 *   schema="Supplier",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/Supplier"),
 *       @OA\Schema(
 *           required={"name"},
 *           @OA\Property(property="id", format="int64", type="integer"),
 *           @OA\Property(property="name", type="string"),
 *           @OA\Property(property="email", type="string"),
 *       )
 *   }
 * )
 */

 /**
 *  @OA\Schema(
 *   schema="Order",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/Order"),
 *       @OA\Schema(
 *           required={"customer"},
 *           @OA\Property(property="customer", ref="#/components/schemas/Customer"),
 *           @OA\Property(property="origin_adress", ref="#/components/schemas/Adress"),
 *           @OA\Property(property="destination_adress", ref="#/components/schemas/Adress"),
 *           @OA\Property(property="supplier", ref="#/components/schemas/Supplier"),
 *           @OA\Property(property="unity", type="string"),
 *           @OA\Property(property="weight", type="number"),
 *           @OA\Property(property="height", type="number"),
 *           @OA\Property(property="width", type="number"),
 *           @OA\Property(property="length", type="number"),
 *       )
 *   }
 * )
 */

  /**
 *  @OA\Schema(
 *   schema="ErrorModel",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/ErrorModel"),
 *       @OA\Schema(
 *           @OA\Property(property="message", type="string"),
 *           @OA\Property(property="status", type="number"),
 *       )
 *   }
 * )
 */