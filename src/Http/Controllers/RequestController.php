<?php

namespace Davidhsianturi\Compass\Http\Controllers;

use Davidhsianturi\Compass\Compass;
use Davidhsianturi\Compass\Contracts\RequestRepository;

class RequestController
{
    /**
     * The routes repository.
     *
     * @var \Davidhsianturi\Compass\Contracts\RequestRepository
     */
    protected $request;

    /**
     * Create a new RequestController instance.
     *
     * @param  \Davidhsianturi\Compass\Contracts\RequestRepository  $request
     */
    public function __construct(RequestRepository $request)
    {
        $this->request = $request;
    }

    /**
     * List the route requests.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $requests = $this->request->get();

        return response()->json([
            'data' => [
                'list' => $requests,
                'group' => Compass::groupingRoutes($requests),
            ],
        ]);
    }

    /**
     * Get route request with the given ID.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json($this->request->find($id));
    }

    /**
     * Store the route request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        return response()->json($this->request->save($this->validateRequest()));
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest()
    {
        return request()->validate([
            'id' => 'string|required',
            'storageId' => 'nullable',
            'title' => 'string|required',
            'description' => 'nullable',
            'content' => 'nullable|array',
        ]);
    }
}
