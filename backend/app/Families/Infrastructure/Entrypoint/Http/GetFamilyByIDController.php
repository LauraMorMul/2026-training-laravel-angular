<?php

namespace App\Families\Infrastructure\Entrypoint\Http;

use App\Families\Application\GetFamilyByID\GetFamilyByID;
use Illuminate\Http\JsonResponse;

class GetFamilyByIDController
{
    public function __construct(
        private GetFamilyByID $getFamilyByID,
    )
    {}

    public function __invoke(string $id)
    {
        $response = ($this->getFamilyByID)($id);
        if($response == null) {
            return new JsonResponse('Family not found', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }
        
    }
}