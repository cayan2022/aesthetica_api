<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ServiceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return AnonymousResourceCollection
     */
    public function __invoke(): AnonymousResourceCollection
    {
        return ServiceResource::collection(Service::whereIsActive()->filter()->latest()->paginate());
    }

    public function getServiceByCategory($category_id)
    {
        $services = Service::whereIsActive()->where('category_id', $category_id)->filter()->latest()->paginate();
        return ServiceResource::collection($services);
    }
}
