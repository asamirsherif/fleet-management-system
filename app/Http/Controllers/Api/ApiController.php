<?php

namespace App\Http\Controllers\Api;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use App\Helpers\ResponseObject;
use App\Http\Controllers\Controller;


class ApiController extends Controller
{
    public function handleResponse( Object $data = null)
    {
        $response = new ResponseObject();
        $response->data = $data;
        $response->statusCode = empty($data) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;
        return response()->json($response,$response->statusCode);
    }

    public function handleResponseWithCount( Object $data = null, $count)
    {
        $response = new ResponseObject();
        $response->data['items'] = $data;
        $response->data['total'] = $count;
        $response->statusCode = empty($data) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;
        return response()->json($response,$response->statusCode);
    }

    public function handleResponseMessage($message)
    {
        $response = new ResponseObject();
        $response->message = $message;
        $response->statusCode = Response::HTTP_OK;
        return response()->json($response,$response->statusCode);
    }

    public function handleCreated($message)
    {
        $response = new ResponseObject();
        $response->message = $message;
        $response->statusCode = Response::HTTP_CREATED;
        return response()->json($response,$response->statusCode);
    }

    public function handleResponseError($message)
    {
        $response = new ResponseObject();
        $response->errorMessage = $message;
        $response->statusCode = Response::HTTP_BAD_REQUEST;
        $response->errored = true;
        return response()->json($response,$response->statusCode);
    }

    public function handlePaginateResponse($data)
    {
        $response = new ResponseObject();
        $response->data['items'] = $data->items();
        $response->data['total'] = $data->total();
        $response->statusCode = empty($data) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;
        return response()->json($response,$response->statusCode);
    }

    public function paginateCollection($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function getFilters($request, $defaultLimit = 15)
    {
        $filters['limit'] = ($request->has('limit')) ? $request->limit : $defaultLimit;
        $filters['order_by'] = ($request->has('order_by')) ? $request->order_by : 'id';
        $filters['search'] = ($request->has('search')) ? $request->search : '';
        $filters['expand'] = ($request->has('expand')) ? $request->expand : [];
        $filters['order_type'] = ($request->has('order_type') && in_array($request->order_type, ['desc', 'asc'])) ? $request->order_type : 'desc';
        return $filters;
    }

    public function getItemsFromCollectionArrays($collectionItems)
    {
        $items = [];
        foreach ($collectionItems as $item) {
            $items[] = $item;
        }
        return collect($items);
    }

    public function handleEmptyResponse(Object $data = null)
    {
        $response = new ResponseObject();
        $response->data = $data;
        $response->statusCode = Response::HTTP_OK;
        return response()->json($response,$response->statusCode);
    }
}
