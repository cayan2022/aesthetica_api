<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Resources\ServiceResource;
use App\Models\Portfolio;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Resources\PortfolioResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PortfolioController extends Controller
{

    public function __invoke(Request $request): AnonymousResourceCollection
    {
        return PortfolioResource::collection(Portfolio::whereIsActive()->filter()->latest()->get());
    }

    public function getPortfoliosByCategory($category_id)
    {
        $portfolios = Portfolio::whereIsActive()->where('portfolio_category_id', $category_id)->filter()->latest()->paginate();
        return PortfolioResource::collection($portfolios);
    }
}
