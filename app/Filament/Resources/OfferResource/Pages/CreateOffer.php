<?php

namespace App\Filament\Resources\OfferResource\Pages;

use App\Filament\Resources\OfferResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Product;
use App\Models\Offer;
use App\Models\OfferedItem;

class CreateOffer extends CreateRecord
{
    protected static string $resource = OfferResource::class;

    public function getTitle(): string
    {
        return __('filament.addNewOffer');
    }
    
    protected function handleRecordCreation(array $data): Model
    {
        $offer = new Offer();
        $offer->value = $data['value'];
        $offer->type  = $data['type'];
        $offer->start_date = $data['start_date'];
        $offer->end_date = $data['end_date'];
        $offer->is_global = $data['is_global']; 
        $offer->save();

        if(!$data['is_global']){
            foreach($data['categories'] as $category_id){
                $offer_item = new OfferedItem(['offer_id' => $offer->id]);
                $category =  Category::find($category_id);
                $category->offers()->save($offer_item);
            }

            foreach($data['products'] as $product_id){
                $offer_item = new OfferedItem(['offer_id' => $offer->id]);
                $product =  Product::find($product_id);
                $product->offers()->save($offer_item);
            }
        }

        return $offer;
    }
}
