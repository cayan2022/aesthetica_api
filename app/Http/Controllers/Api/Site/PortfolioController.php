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
        $portfolios = Portfolio::where([
            'portfolio_category_id' => $category_id,
            'is_block' => 0
        ])->filter()->latest()->paginate();
        return PortfolioResource::collection($portfolios);
    }
}
