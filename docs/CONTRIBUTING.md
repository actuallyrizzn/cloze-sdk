# Contributing to Cloze SDK

Thank you for your interest in contributing to the Cloze SDK project! This document provides guidelines and instructions for contributing.

## Code of Conduct

- Be respectful and inclusive
- Welcome newcomers and help them learn
- Focus on constructive feedback
- Respect different viewpoints and experiences

## How to Contribute

### Reporting Bugs

1. Check if the bug has already been reported in [GitHub Issues](https://github.com/cloze/cloze-sdk/issues)
2. If not, create a new issue with:
   - Clear title and description
   - Steps to reproduce
   - Expected vs actual behavior
   - Environment details (OS, language version, SDK version)
   - Error messages or logs

### Suggesting Features

1. Check if the feature has already been suggested
2. Create a new issue with:
   - Clear description of the feature
   - Use case and motivation
   - Proposed implementation (if applicable)

### Submitting Code

1. **Fork the repository**
2. **Create a branch** from `main`:
   ```bash
   git checkout -b feature/your-feature-name
   ```
3. **Make your changes**:
   - Follow the existing code style
   - Add tests for new features
   - Update documentation as needed
   - Ensure all tests pass
4. **Commit your changes**:
   ```bash
   git commit -m "Add: description of your changes"
   ```
5. **Push to your fork**:
   ```bash
   git push origin feature/your-feature-name
   ```
6. **Create a Pull Request**:
   - Provide a clear description
   - Reference any related issues
   - Ensure CI checks pass

## Development Setup

### Python SDK

```bash
cd python
python -m venv venv
source venv/bin/activate  # or venv\Scripts\activate on Windows
pip install -r requirements-dev.txt
```

### PHP SDK

```bash
cd php
composer install
```

## Coding Standards

### Python

- Follow PEP 8 style guide
- Use type hints where applicable
- Write docstrings for all public functions
- Maintain 100% test coverage

### PHP

- Follow PSR-12 coding standard
- Use type hints for all parameters and return types
- Write PHPDoc comments for all public methods
- Maintain 100% test coverage

## Testing Requirements

### Before Submitting

- All unit tests must pass
- Code coverage must remain at 100%
- Integration tests should pass (if applicable)
- No linter errors

### Running Tests

**Python:**
```bash
cd python
make test
```

**PHP:**
```bash
cd php
make test-unit
```

## Documentation

- Update relevant README files
- Add examples for new features
- Update API documentation if endpoints change
- Keep the comprehensive guides in `docs/` up to date

## Pull Request Process

1. Ensure your branch is up to date with `main`
2. All tests pass
3. Code coverage is maintained at 100%
4. Documentation is updated
5. Commit messages are clear and descriptive
6. PR description explains the changes and motivation

## License

By contributing, you agree that your contributions will be licensed under the same license as the project:
- **Code**: AGPLv3 (see [`LICENSE-CODE`](../LICENSE-CODE))
- **Documentation**: CC-BY-SA 4.0 (see [`LICENSE-DOCS`](../LICENSE-DOCS))

## Questions?

If you have questions about contributing, please:
- Open an issue for discussion
- Contact support@cloze.com
- Check existing documentation in the `docs/` folder

Thank you for contributing to Cloze SDK!

