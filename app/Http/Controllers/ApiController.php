<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\DataStructures\JsonBuilder;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    /**
     * Response status code.
     * @var integer
     */
    private $statusCode = 200;

    /**
     * Setter for $statusCode
     * @param integer $code
     *
     * @return $this
     */
    public function setStatusCode($code)
    {
        $this->statusCode = $code;

        return $this;
    }

    /**
     * Getter for $statusCode
     *
     * @return integer
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Respond with data if any or respond with not found if $data equals to null.
     * @param  array $data
     *
     * @return \Illuminate\Http\Response
     */
    public function respondOrFail($data)
    {
        if( ! $data)
        {
            return $this->respondNotFound();
        }

        return $this->respondWithData($data);
    }

    /**
     * Respond with success json format.
     * @param  string  $message
     * @param  integer $code
     * @return \Illuminate\Http\Response
     */
    public function respondWithSuccess($message = 'success')
    {
        return $this->respond(JsonBuilder::success($message, $this->statusCode));
    }
    /**
     * Respond with message json format.
     * @param  string $message
     * @return \Illuminate\Http\Response
     */
    public function respondWithMessage($message)
    {
        return $this->respond(JsonBuilder::message($message));
    }

    /**
     * Set status code to 404 and respond with error json format.
     * @param  string $message
     *
     * @return \Illuminate\Http\Response
     */
    public function respondNotFound($message = 'Resource Not Found.')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * Respond with json error format.
     * @param  string $message
     *
     * @return \Illuminate\Http\Response
     */
    public function respondWithError($message)
    {
        return $this->respond(JsonBuilder::error($message, $this->getStatusCode()));
    }

    /**
     * Respond with json data format.
     * @param  array $data
     *
     * @return \Illuminate\Http\Response
     */
    public function respondWithData($data)
    {
        return $this->respond(JsonBuilder::data($data));
    }

    /**
     * Respond with json data type.
     * @param  array $data
     * @param  array $headers
     *
     * @return \Illuminate\Http\Response
     */
    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }
}
