# Challenge

This repository is responsible for creating an utomated test suite for the login functionality of [Facebook](https://www.facebook.com/login/) using `Selenium`

> Special Note - The behavior of Facebook's login page may vary based on individual user configurations. Factors such as two-factor authentication settings, multiple login attempts, or other security features can influence the outcome of these tests.

---

[TLDR;](#-tldr)

[Prerequisites](#prerequisites)

[1. Assumptions Made ](#-assumptions-made)

[2. Directory Hierarchy](#-directory-hierarchy)

[3. How to run the Test Suite](#-how-to-run-the-test-suite)

## Prerequisites

- [PHP](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org/download/)
- [make](https://www.gnu.org/software/make/#download) (optional)

### If running in a local setup;


- [chromedriver](https://chromedriver.chromium.org/downloads) - this test suite is intended to run on **Google Chrome**


### If running with Selenium Server (Grid)
- [Java](https://www.oracle.com/java/technologies/downloads/)

- [Selenium Server (GRID)](https://github.com/SeleniumHQ/selenium/releases/download/selenium-4.17.0/selenium-server-4.17.0.jar) - to run a remote selenium server
    - And the server is up and running on port `4444`



# 👨‍💻 TLDR; 

You can simply run the test suite with the `make` command below. (make sure [Prerequisites](#prerequisites) are met)

```make
make run-tests
```

## 🤔 Assumptions Made 

As per the requirements, the test suite is for testing the logging functionality of the [Facebook](https://www.facebook.com) given the different scenarios. 

Assumptions:

- These tests are running on a Windows machine

- `HTML Structure` - HTML structure of the Facebook login page are made based on common practices. If the actual HTML structure is different significantly, we need to adjust the WebDriver locators accordingly.

- Assumes that Facebook login page behaves as expected based on the given scenarios
    - Sometimes accounts with 2 factor authentication is enabled redirects to `https://www.facebook.com/checkpoint/?next`, so the assumption is that it is not enabled and once logged in with correct credentials, facebook will be 

- `NULL` test case - the function `testCancelOrResetButton()` is expected to **_fail_** as Facebook [login](https://www.facebook.com/login/) doesn't have a `RESET/CANCEL` button. 
    


## 📂 Directory Hierarchy 

```
.
├── phpunit-resources
│   ├── phpunit.xml
├── tests
│   ├── facebookTest.php
├── composer.json
├── Makefile
├── README.md
```


- `phpunit-resources/` - This directory contains PHPUnit configuration resources.
    - `phpunit.xml` - PHPUnit configuration file. This includes settings and configurations for running PHPUnit tests

- `tests/` - Directory contains the actual PHPUnit test files.

    - `facebookTest.php` - PHPUnit test file specifically for testing Facebook login functionality. This file contains test cases, assertions, and setups to test given scenarios related to Facebook login.

- `composer.json` - Includes metadata about the project and its dependencies.

- `Makefile` - Contains a set of rules (commands to install dependencies, and run the test suite) to be executed.

## 🚀 How to run the Test Suite

make sure [Prerequisites](#prerequisites) are met


```powershell
composer install 
```
Note: if you have PHP `^5.6 || ~7.0`, `composer install` will fail. To overcome that version check use `--ignore-platform-req=php` option/flag.

```powershell
composer install --ignore-platform-req=php --ignore-platform-req=ext-zip
```

### If running in a local setup;


1. Start the `chromedriver`
```powershell
chromedriver --port=4444
```

2. Run the TestSuite

```powershell
./vendor/bin/phpunit  --configuration phpunit-resources
```

### If running with Selenium Server (Grid)

1. Start a Selenium standalone server on port `4444`
```powershell
java -jar <path-to-downloaded-jar-file> standalone --port 4444
```

2. Run the TestSuite

```powershell
./vendor/bin/phpunit  --configuration phpunit-resources
```

