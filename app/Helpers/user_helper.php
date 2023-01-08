<?php

use App\Entities\Group;
use App\Models\UserModel;
use App\Entities\User;
use \CodeIgniter\HTTP\IncomingRequest;

function getUserModel(): UserModel
{
    return new UserModel();
}

/**
 * @return ?User
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
 */
function getUsers(): array
{
    return getUserModel()->findAll();
}

/**
 * @param int $id
 * @return ?User
 */
function getUserById(int $id): ?object
{
    return getUserModel()->find($id);
}

function getUserByName(string $name): ?object
{
    return getUserModel()->where('name', $name)->first();
}

/**
 * @param string $name
 * @param string $password
 * @return ?User
 */
function getUserByUsernameAndPassword(string $name, string $password): ?object
{
    return getUserModel()->where(['name' => $name, 'password' => $password])->first();
}

function saveUser(User $user): void
{
    getUserModel()->save($user);
}

function deleteUserById(int $id): void
{
    getUserModel()->where(['id' => $id])->delete();
}

function getUserShortNamesByProjectId(int $projectId): array
{
    $leaders = getProjectLeadersByProjectId($projectId);
    $shortNames = [];
    foreach ($leaders as $leader) {
        $shortNames[] = $leader->getShortName();
    }
    return $shortNames;
}

function generateUserPassword(): string
{
    $password = "";
    for ($i = 0; $i < 6; $i++) {
        $password .= rand(0, 9);
    }
    return $password;
}

function createUser(string $name, string $password, int $groupId): User
{
    $user = new User();
    $user->setName($name);
    $user->setPassword($password);
    $user->setGroupId($groupId);

    return $user;
}

function getUserFromForm(IncomingRequest $request): User
{
    $username = $request->getPost('username');
    $password = $request->getPost('password');
    $groupName = $request->getPost('groupName');
    $groupId = getGroupByName($groupName)->getId();
    return createUser($username, $password, $groupId);
}


/**
 * @throws Exception
 */
function getUsersFromForm(IncomingRequest $request): array
{
    $usernames = $request->getPost('username');
    $passwords = $request->getPost('password');
    $groupNames = $request->getPost('groupName');
    $users = [];

    if (!$usernames) {
        throw new Exception('no usernames');
    }
    if (!$passwords) {
        throw new Exception('no passwords');

    }
    if (!$groupNames) {
        throw new Exception('no groupnames');
    }

    try {
        foreach ($usernames as $index => $username) {
            $password = $passwords[$index];
            $groupName = $groupNames[$index];
            $groupId = getGroupByName($groupName)->getId();
            $users[] = createUser($username, $password, $groupId);
        }
    } catch (Exception $exception) {

    }


    return $users;
}


function getUsersFromFile(array $userData, array $keys): \CodeIgniter\HTTP\RedirectResponse|array
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
                $password = generateUserPassword();
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