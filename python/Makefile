.PHONY: test test-unit test-integration test-e2e test-all install install-dev clean coverage

# Install dependencies
install:
	pip install -r requirements.txt

# Install development dependencies
install-dev:
	pip install -r requirements-dev.txt

# Run unit tests
test-unit:
	pytest -m unit -v --cov=cloze_sdk --cov-report=term-missing --cov-report=html

# Run integration tests (requires CLOZE_API_KEY)
test-integration:
	pytest -m integration -v

# Run E2E tests (requires CLOZE_API_KEY)
test-e2e:
	pytest -m e2e -v -s

# Run all tests
test-all:
	pytest -v --cov=cloze_sdk --cov-report=term-missing --cov-report=html

# Run only unit tests for 100% coverage check
test:
	pytest -m "not integration and not e2e" -v --cov=cloze_sdk --cov-report=term-missing --cov-fail-under=100

# Generate coverage report
coverage:
	pytest -m "not integration and not e2e" --cov=cloze_sdk --cov-report=html
	@echo "Coverage report generated in htmlcov/index.html"

# Clean up
clean:
	rm -rf .pytest_cache
	rm -rf htmlcov
	rm -rf .coverage
	rm -rf coverage.xml
	find . -type d -name __pycache__ -exec rm -r {} +
	find . -type f -name "*.pyc" -delete

