<?php
declare(strict_types=1);

namespace UsersTask\Controller;

use UsersTask\Service\User\UserUpdaterInterface;
use UsersTask\Exception\DuplicateFieldValueException;
use UsersTask\Exception\UserNameException;
use UsersTask\Exception\UserNotFoundException;
use UsersTask\Service\User\UserCreatorInterface;

class UserController
{
    private UserCreatorInterface $userCreator;

    private UserUpdaterInterface $userUpdater;

    /**
     * UserController constructor.
     * @param UserCreatorInterface $userCreator
     * @param UserUpdaterInterface $userUpdater
     */
    public function __construct(UserCreatorInterface $userCreator, UserUpdaterInterface $userUpdater)
    {
        $this->userCreator = $userCreator;
        $this->userUpdater = $userUpdater;
    }

    public function updateUsers($users)
    {
        try {
            $this->userUpdater->update($users);
        } catch (DuplicateFieldValueException $e) {
            return Redirect::back()->withErrors(['error', ['We couldn\'t update user: ' . $e->getMessage()]]); // Consider to implement translations mechanism for messages like this.
        } catch (UserNotFoundException $e) {
            return Redirect::back()->withErrors(['error', ['We couldn\'t update user: ' . $e->getMessage()]]);
        } catch (\Throwable $e) {
            return Redirect::back()->withErrors(['error', ['We couldn\'t update user: ' . $e->getMessage()]]); // Consider if passing exception message to user is safe.
        }

        return Redirect::back()->with(['success', 'All users updated.']);
    }

    public function storeUsers($users)
    {
        try {
            $this->userCreator->create($users);
        } catch (DuplicateFieldValueException $e) {
            return Redirect::back()->withErrors(['error', ['We couldn\'t update user: ' . $e->getMessage()]]);
        } catch (UserNameException $e) {
            return Redirect::back()->withErrors(['error', ['We couldn\'t update user: ' . $e->getMessage()]]);
        } catch (\Throwable $e) {
            return Redirect::back()->withErrors(['error', ['We couldn\'t update user: ' . $e->getMessage()]]);
        }

       // $this->sendEmail($users); email notification logic moved to UserCreator
        return Redirect::back()->with(['success', 'All users created.']);
    }

}