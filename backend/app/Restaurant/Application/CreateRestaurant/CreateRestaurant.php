<?php

namespace App\Restaurant\Application\CreateRestaurant;

use App\Restaurant\Application\CreateRestaurant\CreateRestaurantResponse;
use App\Restaurant\Domain\Entity\Restaurant;
use App\Restaurant\Domain\Interfaces\RestaurantRepositoryInterface;
use App\Restaurant\Domain\ValueObject\LegalName;
use App\Restaurant\Domain\ValueObject\TaxID;
use App\Shared\Domain\Interfaces\PasswordHasherInterface;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\ImageSrc;
use App\Shared\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\PasswordHash;
use App\Shared\Domain\ValueObject\RestaurantID;
use App\User\Domain\Entity\User;
use App\User\Domain\Interfaces\UserRepositoryInterface;
use App\User\Domain\ValueObject\Pin;
use App\User\Domain\ValueObject\Role;
use App\User\Domain\ValueObject\UserName;

class CreateRestaurant
{
    public function __construct(
        private RestaurantRepositoryInterface $restaurantRepository,
        private PasswordHasherInterface $passwordHasher,
        private UserRepositoryInterface $userRepository,
    ) {}

    public function __invoke(string $nameAdmin, string $nameRestaurant, string $legalName, string $taxID, string $emailRestaurant, string $password)
    {
        $nameRestaurantVO = Name::create($nameRestaurant);
        $legalNameVO = LegalName::create($legalName);
        $taxIDVO = TaxID::create($taxID);
        $emailRestaurantVO = Email::create($emailRestaurant);
        $passwordVO = PasswordHash::create($this->passwordHasher->hash($password));
        $restaurant = Restaurant::dddCreate($nameRestaurantVO, $legalNameVO, $taxIDVO, $emailRestaurantVO, $passwordVO);

        $this->restaurantRepository->save($restaurant);

        $emailUser = strtolower(strtok($nameAdmin, " ")).strstr($emailRestaurant, '@');
        $restaurantID = $this->restaurantRepository->findIDbyUUID($restaurant->id()->value());
        $emailVO = Email::create($emailUser);
        $nameVO = UserName::create($nameAdmin);
        $passwordHashVO = PasswordHash::create($this->passwordHasher->hash($password));
        $restaurantIDVO = RestaurantID::create($restaurantID);
        $roleVO = Role::create('admin');
        $imageSrcVO = ImageSrc::create('default.jpg');
        $pinVO = Pin::create('1234');
        $admin = User::dddCreate($emailVO, $nameVO, $passwordHashVO, $restaurantIDVO, $roleVO, $imageSrcVO, $pinVO);
        $this->userRepository->save($admin);

        return CreateRestaurantResponse::create($restaurant, $admin);
    }
}
