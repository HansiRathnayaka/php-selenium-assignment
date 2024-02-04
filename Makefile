prerequisites:
	@printf "\nInstalling dependencies..."
	composer install --ignore-platform-req=php
	sleep 5

run-tests: prerequisites
	@printf "\nRunning the test cases..."
	./vendor/bin/phpunit  --configuration phpunit-resources