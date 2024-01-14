<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_description' => $this->short_description,
            'full_description' => $this->full_description,
            'url' => $this->url,
            'logo' => $this->getLogo(),
            'cover' => $this->getCover(),
            'is_block' => $this->is_block,
            'translations' => $this->getTranslationsArray(),
            'portfolio_category' => new PortfolioCategoryResource($this->portfolioCategory),
        ];
    }
}
