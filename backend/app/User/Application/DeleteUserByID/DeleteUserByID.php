<?php

namespace App\User\Application\DeleteUserByID;

use App\Shared\Domain\Interfaces\ImageManagerInterface;
use App\User\Domain\Interfaces\UserRepositoryInterface;

class DeleteUserByID
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private ImageManagerInterface $imageManager
    ) {}

    public function __invoke(string $id, int $restaurantID): bool
    {
        $exists = $this->userRepository->findById($id);

        if ($exists === null || $exists->restaurantID()->value() !== $restaurantID) {
            return false;
        } else {
            $this->imageManager->delete($exists->imageSrc()->value());
            $this->userRepository->deleteByID($id);

            return true;
        }
    }
}
