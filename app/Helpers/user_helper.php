<?php

use App\Models\UserModel;
use App\Entities\User;
use CodeIgniter\Database\Exceptions\DatabaseException;
use \CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * @return ?User
 * @throws DatabaseException
 */
function getCurrentUser(): ?object
{
    $user_id = session('user_id');
    if (!$user_id) {
        return null;
    }

    return getUserById($user_id);
}

/**
 * @return User[]
 * @throws DatabaseException
 */
function getUsers(): array
{
    $users = getUserModel()->findAll();
    usort($users, fn($a, $b) => strcmp($a->getName(), $b->getName()));
    return $users;
}


function getUsersWithQrCode(): array
{
    helper('credential');
    $users = getUsers();
    $usersWithQr = [];
    foreach ($users as $user) {
        $qrCodeUrl = generateQrCode($user->getName(), $user->getPassword());
        $userWithQr = [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'password' => $user->getPassword(),
            'qrCodeUrl' => $qrCodeUrl
        ];
        $usersWithQr[] = $userWithQr;
    }
    usort($usersWithQr, fn($a, $b) => strcmp($a['name'], $b['name']));

    return $usersWithQr;

}


/**
 * @return User
 * @throws DatabaseException
 */
function getFirstUser(): User
{
    $users = getUsers();
    return $users[0];
}

/**
 * @return User
 * @throws DatabaseException
 */
function getLastUser(): User
{
    $users = getUsers();
    return end($users);
}

/**
 * @param int $id
 * @return ?User
 * @throws DatabaseException
 */
function getUserById(int $id): ?object
{
    return getUserModel()->find($id);
}

/**
 * @param string $name
 * @return ?User
 * @throws DatabaseException
 */
function getUserByName(string $name): ?object
{
    return getUserModel()->where('name', $name)->first();
}

/**
 * @param string $name
 * @param string $password
 * @return ?User
 * @throws DatabaseException
 */
function getUserByUsernameAndPassword(string $name, string $password): ?object
{
    return getUserModel()->where(['name' => $name, 'password' => $password])->first();
}

/**
 * @param User $user
 * @return void
 * @throws DatabaseException|ReflectionException
 */
function saveUser(User $user): void
{
    getUserModel()->save($user);
}

/**
 * @param int $id
 * @return void
 * @throws DatabaseException
 */
function deleteUserById(int $id): void
{
    getUserModel()->where(['id' => $id])->delete();
}

/**
 * @param IncomingRequest $request
 * @return array
 * @throws DatabaseException
 */
function getUsersFromForm(IncomingRequest $request): array
{
    $usernames = $request->getPost('username');
    $passwords = $request->getPost('password');
    $groupNames = $request->getPost('groupName');

    $users = [];
    if (!$usernames) {
        throw new RuntimeException('no usernames');
    }

    if (!$passwords) {
        throw new RuntimeException('no passwords');
    }

    if (!$groupNames) {
        throw new RuntimeException('no groupnames');
    }

    foreach ($usernames as $index => $username) {
        $password = $passwords[$index];
        $groupName = $groupNames[$index];
        $groupId = getGroupByName($groupName)->getId();
        $users[] = createUser($username, $password, $groupId);
    }

    return $users;
}

function getUsersFromFile(array $userData, array $keys): RedirectResponse|array
{
    $users = [];
    $errors = [];
    foreach ($userData as $data) {
        try {
            $firstName = $data[$keys['firstName']];
            $lastName = $data[$keys['lastName']];
            $name = "$firstName $lastName";
            $grade = $data[$keys['grade']];
            try {
                $user = getUserByName($name);
                if ($user) {
                    throw new Exception(lang('user.import.errors.userExists'));
                }

                $groupId = getGroupByName("Klasse $grade")?->getId();
                if (!$groupId) {
                    throw new Exception(lang('user.import.errors.gradeNotFound'));
                }

                $password = generatePassword();
                $users[] = createUser($name, $password, $groupId);
            } catch (Exception $exception) {
                $errors[] = [
                    'user' => [
                        'name' => $name,
                    ],
                    'cause' => $exception->getMessage()
                ];
            }
        } catch (Exception $exception) {
            $errors[] = [
                'user' => [
                    'name' => 'GENERAL_ERROR',
                ],
                'cause' => $exception->getMessage()
            ];
        }
    }
    return [$users, $errors];
}

/**
 * @param string $name
 * @param string $password
 * @param int $groupId
 * @return User
 */
function createUser(string $name, string $password, int $groupId): User
{
    $user = new User();
    $user->setName($name);
    $user->setPassword($password);
    $user->setGroupId($groupId);
    return $user;
}

/**
 * @return string
 */
function generatePassword(): string
{
    $password = "";
    for ($i = 0; $i < 6; $i++) {
        $password .= rand(0, 9);
    }
    return $password;
}

/**
 * @return UserModel
 */
function getUserModel(): UserModel
{
    return new UserModel();
}