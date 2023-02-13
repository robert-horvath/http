.PHONY: sanity-test

sanity-test:
	@echo "\033[0;33m>>> Running sanity test\033[0m"
	composer validate --strict
