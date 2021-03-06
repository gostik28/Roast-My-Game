<?php

class CommentCest
{
    private function loginAs(AcceptanceTester $I, $email, $password)
    {
        $I->amOnPage('/auth/login');
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click(['id' => 'login']);
    }

    public function testAddWithoutPermissions(\AcceptanceTester $I)
    {
        $I->amOnPage('/game/test-game-2');

        $I->selectOption('select[name=positive]', 'Animation');
        $I->selectOption('select[name=negative]', 'Level Design');
        $I->fillField('body', 'This is a sample comment. This is a sample comment.');
        $I->click('Reply');

        $I->see('Login'); //verify the user was directed to the login page
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->see('Test Game 2'); //verify the user was redirected back
        $I->dontSee('Animation', '.media-body');
        $I->dontSee('Level Design', '.media-body');
        $I->dontSee('This is a sample comment. This is a sample comment.');
        $I->dontSeeInDatabase('comments', array('body' => 'This is a sample comment. This is a sample comment.'));
    }

    public function testAddReplyWithoutPermissions(\AcceptanceTester $I)
    {
        //Add a regular comment
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');

        $I->selectOption('select[name=positive]', 'Animation');
        $I->selectOption('select[name=negative]', 'Level Design');
        $I->fillField('body', 'This is a top level comment. This is a top level comment.');
        $I->click('Reply');

        //Logout
        $I->click('#profile-dropdown');
        $I->wait(1);
        $I->click('#logout-button');
        $I->wait(1);

        //Attempt to add a reply comment
        $I->amOnPage('/game/test-game-1');
        $I->click(['link' => 'Reply']);
        $I->fillField('.reply-form textarea', 'This is a sample reply comment. This is a sample reply comment.');
        $I->click('.reply-form button');

        $I->see('Login'); //verify the user was directed to the login page
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->see('Test Game 1'); //verify the user was redirected back
        $I->dontSee('This is a sample reply comment. This is a sample reply comment.');
        $I->dontSeeInDatabase('comments', array('body' => 'This is a sample reply comment. This is a sample reply comment.'));
    }

    public function testAddFullComment(\AcceptanceTester $I)
    {
        $I->resetEmails();
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');

        $I->selectOption('select[name=positive]', 'Animation');
        $I->selectOption('select[name=negative]', 'Level Design');

        //5000 characters
        $I->fillField('body', 'This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sampl');
        $I->click(['id' =>'main-reply-button']);

        $I->see('Comment added!');
        $I->see('Animation', '.media-body');
        $I->see('Level Design', '.media-body');
        $I->see('This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sampl');
        $I->seeInDatabase('comments', array('positive' => 'animation', 'negative' => 'level_design', 'body' => 'This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sampl'));

        //verify email
        $I->seeInLastEmailTo("roastmygame@gmail.com", "Someone has roasted Test Game 1");
        $I->seeInLastEmailTo("roastmygame@gmail.com", "https://clickr.app/game/test-game-1");
        $I->seeInLastEmailTo("user1@gmail.com", "Someone has roasted Test Game 1");
        $I->seeInLastEmailTo("user1@gmail.com", "https://clickr.app/game/test-game-1");
        $I->seeEmailCount(2);
    }

    public function testFullCommentToUnsubscribedUser(\AcceptanceTester $I)
    {
        $I->resetEmails();
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-6');

        $I->fillField('body', 'This is a sample comment.');
        $I->click(['id' =>'main-reply-button']);

        $I->see('Comment added!');

        //verify no email
        $I->seeEmailCount(0);
    }

    public function testAddOnlyPositive(\AcceptanceTester $I)
    {
        $I->resetEmails();
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');

        $I->selectOption('select[name=positive]', 'Physics');
        $I->click('Reply');

        $I->see('Please take a minute to add some details to your roast.');
        $I->seeEmailCount(0);
    }

    public function testAddFullOnlyNegative(\AcceptanceTester $I)
    {
        $I->resetEmails();

        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');

        $I->selectOption('select[name=negative]', 'Controls');
        $I->click('Reply');

        $I->see('Please take a minute to add some details to your roast.');
        $I->seeEmailCount(0);
    }

    public function testAddFullOnlyText(\AcceptanceTester $I)
    {
        $I->resetEmails();
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');

        $I->fillField('body', 'This is a another sample comment. This is a sample comment.');
        $I->click('Reply');

        $I->see('Comment added!');
        $I->see('This is a another sample comment. This is a sample comment.');
        $I->seeInDatabase('comments', array('positive' => NULL, 'negative' => NULL, 'body' => 'This is a another sample comment. This is a sample comment.'));

        $I->seeInLastEmailTo("roastmygame@gmail.com", "Someone has roasted Test Game 1");
        $I->seeInLastEmailTo("roastmygame@gmail.com", "https://clickr.app/game/test-game-1");
        $I->seeInLastEmailTo("user1@gmail.com", "Someone has roasted Test Game 1");
        $I->seeInLastEmailTo("user1@gmail.com", "https://clickr.app/game/test-game-1");
        $I->seeEmailCount(2);
    }

    public function testAddShortBody(\AcceptanceTester $I)
    {
        $I->resetEmails();

        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');

        $I->fillField('body', 'This is a short comment');
        $I->click('Reply');

        $I->see('Please take a minute to add a few more details to your roast, the game dev will really appreciate it!');
        $I->seeEmailCount(0);
    }

    public function testAddNothing(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');
        $I->click('Reply');

        $I->see('Please take a minute to add some details to your roast.');
    }

    public function testAddNothingReply(\AcceptanceTester $I)
    {
        //Add a regular comment
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');

        $I->selectOption('select[name=positive]', 'Animation');
        $I->selectOption('select[name=negative]', 'Level Design');
        $I->fillField('body', 'This is a top level comment. This is a top level comment.');
        $I->click('Reply');

        //Logout
        $I->click('#profile-dropdown');
        $I->wait(1);
        $I->click('#logout-button');
        $I->wait(1);

        //log back in (for some reason this->loginAs doesn't work)
        $I->amOnPage('/auth/login');
        $I->wait(1);
        $I->fillField('email', 'user3@gmail.com');
        $I->fillField('password', 'password3');
        $I->click(['id' => 'login']);

        //Add an empty reply comment
        $I->amOnPage('/game/test-game-1');
        $I->click(['link' => 'Reply']);
        $I->click('.reply-form button');

        $I->see('The comment field is required.');
    }

    public function testAddInvalidBody(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');

        $I->fillField('body', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasda');
        $I->click('Reply');

        $I->see('The body may not be greater than 5000 characters.');
        $I->dontSeeInDatabase('comments', array('positive' => NULL, 'negative' => NULL, 'body' => 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasda'));
    }

    public function testAddCommentReply(\AcceptanceTester $I)
    {
        $I->resetEmails();
        //Add a regular comment
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');

        $I->selectOption('select[name=positive]', 'Animation');
        $I->selectOption('select[name=negative]', 'Level Design');
        $I->fillField('body', 'This is a top level comment. This is a top level comment.');
        $I->click('Reply');

        //Logout
        $I->click('#profile-dropdown');
        $I->wait(1);
        $I->click('#logout-button');
        $I->wait(1);

        //log back in (for some reason this->loginAs doesn't work)
        $I->amOnPage('/auth/login');
        $I->wait(1);
        $I->fillField('email', 'user3@gmail.com');
        $I->fillField('password', 'password3');
        $I->click(['id' => 'login']);

        //Add a reply comment
        $I->amOnPage('/game/test-game-1');
        $I->click(['link' => 'Reply']);
        $I->fillField('.reply-form textarea', 'This is a sample reply comment. This is a sample reply comment.');
        $I->click('.reply-form button');

        $I->see('Comment reply added!');
        $I->see('This is a sample reply comment. This is a sample reply comment.', '.col-sm-offset-1 .media-body');
        $I->seeInDatabase('comments', array('positive' => NULL, 'negative' => NULL, 'body' => 'This is a sample reply comment. This is a sample reply comment.'));

        $I->seeInLastEmailTo("roastmygame@gmail.com", "Someone has replied to your comment. View it by clicking the button below.");
        $I->seeInLastEmailTo("roastmygame@gmail.com", "https://clickr.app/game/test-game-1");
        $I->seeInLastEmailTo("user2@gmail.com", "Someone has replied to your comment. View it by clicking the button below.");
        $I->seeInLastEmailTo("user2@gmail.com", "https://clickr.app/game/test-game-1");
        $I->seeEmailCount(4);

        $I->amOnPage('/profile/user3');
        $I->seeInSource('trophy1.jpg');
        $I->seeInSource('25 Points');
    }

    public function testReplyToUnsubscribedUser(\AcceptanceTester $I)
    {
        $I->resetEmails();
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-3');

        $I->click(['link' => 'Reply']);
        $I->fillField('.reply-form textarea', 'This is a sample reply comment. This is a sample reply comment.');
        $I->click('.reply-form button');
        $I->see('Comment reply added!');

        //verify no email
        $I->seeEmailCount(0);
    }

    public function testAddCommentOnOwnGame(\AcceptanceTester $I)
    {
        $I->resetEmails();
        //Add a regular comment
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->amOnPage('/game/test-game-1');

        $I->selectOption('select[name=positive]', 'Animation');
        $I->selectOption('select[name=negative]', 'Level Design');
        $I->fillField('body', 'This is a top level comment. This is a top level comment.');
        $I->click('Reply');
        $I->seeInDatabase('comments', array('positive' => 'animation', 'negative' => 'level_design', 'body' => 'This is a top level comment. This is a top level comment.'));

        $I->seeEmailCount(0); //2 emails from the first comment
    }

    public function testAddCommentReplyToSelf(\AcceptanceTester $I)
    {
        $I->resetEmails();

        //Add a regular comment
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');

        $I->selectOption('select[name=positive]', 'Animation');
        $I->selectOption('select[name=negative]', 'Level Design');
        $I->fillField('body', 'This is a top level comment. This is a top level comment.');
        $I->click('Reply');

        //Add a reply comment to self
        $I->amOnPage('/game/test-game-1');
        $I->click(['link' => 'Reply']);
        $I->fillField('.reply-form textarea', 'This is a sample reply comment. This is a sample reply comment.');
        $I->click('.reply-form button');

        $I->see('Comment reply added!');
        $I->see('This is a sample reply comment. This is a sample reply comment.', '.col-sm-offset-1 .media-body');
        $I->seeInDatabase('comments', array('positive' => NULL, 'negative' => NULL, 'body' => 'This is a sample reply comment. This is a sample reply comment.'));

        $I->seeEmailCount(2); //2 emails from the first comment
    }

    public function testAddCommentInvalidBodyReply(\AcceptanceTester $I)
    {
        //Add a regular comment
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');

        $I->selectOption('select[name=positive]', 'Animation');
        $I->selectOption('select[name=negative]', 'Level Design');
        $I->fillField('body', 'This is a top level comment. This is a top level comment.');
        $I->click('Reply');

        //Logout
        $I->click('#profile-dropdown');
        $I->wait(1);
        $I->click('#logout-button');
        $I->wait(1);

        //log back in (for some reason this->loginAs doesn't work)
        $I->amOnPage('/auth/login');
        $I->wait(1);
        $I->fillField('email', 'user3@gmail.com');
        $I->fillField('password', 'password3');
        $I->click(['id' => 'login']);

        //Add a reply comment
        $I->amOnPage('/game/test-game-1');
        $I->click(['link' => 'Reply']);
        $I->fillField('.reply-form textarea', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasda');
        $I->click('.reply-form button');

        $I->see('The body may not be greater than 5000 characters.');
        $I->dontSeeInDatabase('comments', array('positive' => NULL, 'negative' => NULL, 'body' => 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasda'));
    }

    public function testAddCommentShortReply(\AcceptanceTester $I)
    {
        //Add a regular comment
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');

        $I->selectOption('select[name=positive]', 'Animation');
        $I->selectOption('select[name=negative]', 'Level Design');
        $I->fillField('body', 'This is a top level comment. This is a top level comment.');
        $I->click('Reply');

        //Logout
        $I->click('#profile-dropdown');
        $I->wait(1);
        $I->click('#logout-button');
        $I->wait(1);

        //log back in (for some reason this->loginAs doesn't work)
        $I->amOnPage('/auth/login');
        $I->wait(1);
        $I->fillField('email', 'user3@gmail.com');
        $I->fillField('password', 'password3');
        $I->click(['id' => 'login']);

        //Add a reply comment
        $I->amOnPage('/game/test-game-1');
        $I->click(['link' => 'Reply']);
        $I->fillField('.reply-form textarea', 'tiny');
        $I->click('.reply-form button');

        $I->see('The comment must be at least 5 characters.');
    }

    public function testGetPoints(\AcceptanceTester $I)
    {
        $I->amOnPage('/auth/login');
        $this->loginAs($I, 'user3@gmail.com', 'password3');

        $I->amOnPage('/game/test-game-1');

        $I->selectOption('select[name=positive]', 'Animation');
        $I->selectOption('select[name=negative]', 'Level Design');
        $I->fillField('body', 'This is a top level comment. This is a top level comment.');
        $I->click('Reply');

        $I->amOnPage('/profile/user3');
        $I->seeInSource('trophy1.jpg');
        $I->seeInSource('25 Points');
    }

}