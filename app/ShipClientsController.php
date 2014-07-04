<?php

use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 *      resourcePath="/shipclients",
 *      @SWG\Api (
 *          path="/shipclients/{id}",
 *          description="Operations about ship clients",
 *          @SWG\Operation(
 *              method="GET",
 *              type="string",
 *              summary="Gets a particular shipping client",
 *              nickname="shipClientId",
 *              @SWG\Parameter(
 *                  name="id",
 *                  description="The shipping client's id",
 *                  paramType="path",
 *                  required="true",
 *                  type="string"
 *              )
 *          ),
 *          @SWG\Operation(
 *               method="DELETE", summary="Remove a shipping client", notes="Removes a shipping client based on their id",
 *               type="ShippingClient", nickname="destroy",
 *               @SWG\Parameter(
 *                  name="id",
 *                  description="The shipping client's id",
 *                  paramType="path",
 *                  required="true",
 *                  type="string"
 *              )
 *          )
 *      )
 * )
 */
class ShipClientsController extends BaseController {


	public function index()
	{
		return View::make('hello');
	}

    public function destroy($id)
    {
        Auth::logout();
    }
}