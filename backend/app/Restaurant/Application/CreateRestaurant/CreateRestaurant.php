<?php

namespace App\Restaurant\Application\CreateRestaurant;

use App\Restaurant\Domain\Entity\Restaurant;
use App\Restaurant\Domain\Interfaces\RestaurantRepositoryInterface;
use App\Restaurant\Domain\ValueObject\LegalName;
use App\Restaurant\Domain\ValueObject\TaxID;
use App\Shared\Domain\Interfaces\PasswordHasherInterface;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\PasswordHash;

class CreateRestaurant
{
    public function __construct(
        private RestaurantRepositoryInterface $restaurantRepository,
        private PasswordHasherInterface $passwordHasher,
    ){}

    public function __invoke(string $name, string $legalName, string $taxID, string $email, string $password)
    {
        $nameVO = Name::create($name);
        $legalNameVO = LegalName::create($legalName);
        $taxIDVO = TaxID::create($taxID);
        $emailVO = Email::create($email);
        $passwordVO = PasswordHash::create($this->passwordHasher->hash($password));
        $restaurant = Restaurant::dddCreate($nameVO, $legalNameVO, $taxIDVO, $emailVO, $passwordVO);
        $this->restaurantRepository->save($restaurant);

        return CreateRestaurantResponse::create($restaurant);
    }
}