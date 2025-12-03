#!/usr/bin/env python
"""Test runner script for Cloze SDK."""

import sys
import subprocess

def run_tests(test_type="unit"):
    """Run tests by type."""
    if test_type == "unit":
        cmd = ["pytest", "-m", "unit", "-v", "--cov=cloze_sdk", "--cov-report=term-missing", "--cov-report=html"]
    elif test_type == "integration":
        cmd = ["pytest", "-m", "integration", "-v"]
    elif test_type == "e2e":
        cmd = ["pytest", "-m", "e2e", "-v", "-s"]
    elif test_type == "all":
        cmd = ["pytest", "-v", "--cov=cloze_sdk", "--cov-report=term-missing", "--cov-report=html"]
    else:
        print(f"Unknown test type: {test_type}")
        print("Available types: unit, integration, e2e, all")
        return 1
    
    result = subprocess.run(cmd)
    return result.returncode

if __name__ == "__main__":
    test_type = sys.argv[1] if len(sys.argv) > 1 else "unit"
    sys.exit(run_tests(test_type))

