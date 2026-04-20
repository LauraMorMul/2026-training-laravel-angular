<?php

namespace App\Product\Infrastructure\Persistence\Repositories;

use App\Product\Domain\Entity\Product;
use App\Product\Domain\Interfaces\ProductRepositoryInterface;
use App\Product\Infrastructure\Persistence\Models\EloquentProduct;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        private EloquentProduct $model,
    ) {}

    public function save(Product $product): void
    {
        $this->model->newQuery()->updateOrCreate(
            ['uuid' => $product->id()->value()],
            [
                'restaurant_id' => $product->restaurantID()->value(),
                'family_id' => $product->familyID()->value(),
                'tax_id' => $product->taxID()->value(),
                'image_src' => $product->imageSrc()->value(),
                'name' => $product->name()->value(),
                'price' => $product->price()->value(),
                'stock' => $product->stock()->value(),
                'active' => $product->active(),
                'created_at' => $product->createdAt()->value(),
                'updated_at' => $product->updatedAt()->value(),
            ]
        );
    }

    public function findById(string $id): ?Product
    {
        $model = $this->model->newQuery()->where('uuid', $id)->first();

        if ($model === null) {
            return null;
        }

        return Product::fromPersistence(
            $model->uuid,
            $model->restaurant_id,
            $model->family_id,
            $model->tax_id,
            $model->image_src,
            $model->name,
            $model->price,
            $model->stock,
            $model->active,
            $model->created_at->toDateTimeImmutable(),
            $model->updated_at->toDateTimeImmutable(),
        );
    }

    public function getByRestaurant(string $restaurantID): ?array
    {
        $models = $this->model->newQuery()->whereIn('restaurant_id', function ($query) use ($restaurantID) {
            $query->select('id')
                ->from('restaurants')
                ->where('uuid', $restaurantID);
        })->getModels();
        $products = [];

        if ($models === null) {
            return null;
        }

        foreach ($models as $model) {
            $product = Product::fromPersistence(
                $model->uuid,
                $model->restaurant_id,
                $model->family_id,
                $model->tax_id,
                $model->image_src,
                $model->name,
                $model->price,
                $model->stock,
                $model->active,
                $model->created_at->toDateTimeImmutable(),
                $model->updated_at->toDateTimeImmutable(),
            );
            array_push($products, $product);
        }

        return $products;
    }

    public function deleteByID(string $id): void
    {
        $productModel = $this->model->newQuery()->where('uuid', $id)->first();

        if ($productModel === null) {
            return;
        }

        $productModel->delete();
    }
}
