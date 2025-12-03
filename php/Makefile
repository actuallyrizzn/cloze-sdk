.PHONY: test test-unit test-integration test-e2e test-coverage install

# Default PHP executable (can be overridden)
PHP := php
COMPOSER := composer

install:
	$(COMPOSER) install

test: install
	$(PHP) vendor/bin/phpunit

test-unit:
	$(PHP) vendor/bin/phpunit --testsuite Unit

test-integration:
	$(PHP) vendor/bin/phpunit --testsuite Integration

test-e2e:
	$(PHP) vendor/bin/phpunit --testsuite E2E

test-coverage:
	$(PHP) vendor/bin/phpunit --coverage-html coverage/html --coverage-clover coverage/clover.xml

