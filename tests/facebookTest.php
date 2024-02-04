<?php

namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;

require_once('vendor/autoload.php');

class FacebookLoginTest extends TestCase
{
    private $webDriver;

    protected function setUp(): void
    {
        // Set up the WebDriver instance before each test
        $host = 'localhost:4444';
        $capabilities = DesiredCapabilities::chrome();
        $this->webDriver  = RemoteWebDriver::create($host, $capabilities);
    }

    protected function tearDown(): void
    {
        // Quit the WebDriver instance after each test
        $this->webDriver->quit();
    }

    // Test for successful login
    public function testSuccessfulLogin()
    {

        $correctEmail = "CORRECT-EMAIL-HERE@gmail.com";
        $correctPassword = "CORRECT-PW-HERE";

       
        $this->webDriver->get('https://www.facebook.com/login/');

       
        $emailField = $this->webDriver->findElement(WebDriverBy::name('email'));
        $passwordField = $this->webDriver->findElement(WebDriverBy::name('pass'));
        $loginButton = $this->webDriver->findElement(WebDriverBy::name('login'));

        $emailField->sendKeys($correctEmail);
        $passwordField->sendKeys($correctPassword);

        $this->webDriver->wait(3)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('login'))
        );

        $loginButton->click();

        $this->assertTrue($this->webDriver->getCurrentURL() === 'https://www.facebook.com/');
    }

    // Test for incorrect email and correct password
    public function testIncorrectEmailAndCorrectPassword()
    {        
        $incorrectEmail = "incorrect_email@gmail.com";
        $correctPassword = "CORRECT-PW-HERE";
        
        $this->webDriver->get('https://www.facebook.com/login/');
        
        $emailField = $this->webDriver->findElement(WebDriverBy::name('email'));
        $passwordField = $this->webDriver->findElement(WebDriverBy::name('pass'));
        $loginButton = $this->webDriver->findElement(WebDriverBy::name('login'));
        
        $emailField->sendKeys($incorrectEmail);
        $passwordField->sendKeys($correctPassword);
        
        $this->webDriver->wait(3)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('login'))
        );
        
        $loginButton->click();        
        $errorMessage = $this->webDriver->findElement(WebDriverBy::cssSelector('#facebook ._44mg ._9ay7'))->getText();
        $this->assertEquals('The email address you entered isn\'t connected to an account. Find your account and log in.', $errorMessage);
    }

    // Test for correct email and incorrect password
    public function testCorrectEmailAndIncorrectPassword()
    {        
        $correctEmail = "CORRECT-EMAIL-HERE@gmail.com";
        $incorrectPassword = "incorrectpassword";
        
        $this->webDriver->get('https://www.facebook.com/login/');
        
        $emailField = $this->webDriver->findElement(WebDriverBy::name('email'));
        $passwordField = $this->webDriver->findElement(WebDriverBy::name('pass'));
        $loginButton = $this->webDriver->findElement(WebDriverBy::name('login'));
        
        $emailField->sendKeys($correctEmail);
        $passwordField->sendKeys($incorrectPassword);
        
        $this->webDriver->wait(3)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('login'))
        );
        
        $loginButton->click();
        
        $this->assertTrue($this->webDriver->getCurrentURL() === 'https://www.facebook.com/login/web/?email=CORRECT-EMAIL-HERE%40gmail.com&is_from_lara=1');
    }

    // Test for incorrect email and password combination
    public function testIncorrectEmailAndPasswordCombination()
    {        
        $incorrectEmail = "incorrect_email@gmail.com";
        $incorrectPassword = "incorrectpassword";
        
        $this->webDriver->get('https://www.facebook.com/login/');
        
        $emailField = $this->webDriver->findElement(WebDriverBy::name('email'));
        $passwordField = $this->webDriver->findElement(WebDriverBy::name('pass'));
        $loginButton = $this->webDriver->findElement(WebDriverBy::name('login'));
        
        $emailField->sendKeys($incorrectEmail);
        $passwordField->sendKeys($incorrectPassword);
        
        $this->webDriver->wait(3)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('login'))
        );
        
        $loginButton->click();
        
        $errorMessage = $this->webDriver->findElement(WebDriverBy::cssSelector('div._9ay7'))->getText();
        $this->assertEquals('The email address you entered isn\'t connected to an account. Find your account and log in.', $errorMessage);
    }

    // Test for attempting login with empty fields
    public function testEmptyFieldsLogin()
    {       
        $this->webDriver->get('https://www.facebook.com/login/');
       
        $loginButton = $this->webDriver->findElement(WebDriverBy::name('login'));       
        $this->webDriver->wait(3)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('login'))
        );
       
        $loginButton->click();
       
        $errorMessage = $this->webDriver->findElement(WebDriverBy::cssSelector('#facebook ._44mg ._9ay7'))->getText();
        $this->assertEquals('The email address or mobile number you entered isn\'t connected to an account. Find your account and log in.', $errorMessage);
    }

    // Test for cancel or reset button functionality
    public function testCancelOrResetButton()
    {        
        $this->webDriver->get('https://www.facebook.com/login/');
        
        $emailField = $this->webDriver->findElement(WebDriverBy::name('email'));
        $passwordField = $this->webDriver->findElement(WebDriverBy::name('pass'));
        $resetButton = $this->webDriver->findElement(WebDriverBy::xpath('//button[@type="reset"]'));
        
        $emailField->sendKeys('your_valid_email@example.com');
        $passwordField->sendKeys('your_valid_password');
        
        $this->webDriver->wait(3)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('login'))
        );
        
        $resetButton->click();
        
        $this->assertFalse($this->webDriver->getCurrentURL() === 'https://www.facebook.com/');
    }
}
