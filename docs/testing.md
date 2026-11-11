# Testing

This package provides a consistent set of [Composer](https://getcomposer.org/) scripts for local validation.

Tool references:

- [Composer Require Checker](https://github.com/maglnet/ComposerRequireChecker) for dependency definition checks.
- [Easy Coding Standard (ECS)](https://github.com/easy-coding-standard/easy-coding-standard) for coding standards.
- [Infection](https://infection.github.io/) for mutation testing.
- [PHPStan](https://phpstan.org/) for static analysis.
- [Rector](https://github.com/rectorphp/rector) for automated refactoring.
- [Testo](https://php-testo.github.io/) for unit tests.

## Automated refactoring (Rector)

Run Rector to apply automated code refactoring. This command modifies files.

```bash
composer rector
```

Preview the refactoring without modifying files.

```bash
composer rector-check
```

## Coding standards (ECS)

Check coding standards without modifying files.

```bash
composer ecs-check
```

Apply coding standard fixes. Review the changes before keeping them.

```bash
composer ecs
```

## Dependency definition check

Verify that runtime dependencies are correctly declared in `composer.json`.

```bash
composer check-dependencies
```

## Mutation testing (Infection)

Run mutation testing.

```bash
composer mutation
```

Run mutation testing with static analysis enabled.

```bash
composer mutation-static
```

Options live in `infection.json5`, which runs the mutants through the Testo adapter (`testo/bridge-infection`). A
coverage driver such as PCOV or Xdebug must be enabled. Inspect escaped mutants separately from line coverage; a
successful command alone does not imply a perfect mutation score.

## Static analysis (PHPStan)

Run static analysis.

```bash
composer static
```

## Unit tests (Testo)

Run the full test suite configured in `testo.php`.

```bash
composer tests
```

The suite checks theme resolution and rendered markup for both themes. Expected markup is defined in PHP data
providers; tests do not read HTML fixtures.

## Repository quality checks

Make the CLI tools used by the shared PHP Forge quality workflow available on `PATH`: actionlint with ShellCheck,
codespell, EditorConfig Checker, markdownlint-cli2, Prettier, and yamllint.

```bash
composer quality
```

Each check also has its own script.

```bash
composer actionlint
composer codespell
composer editorconfig-checker
composer markdownlint
composer prettier
composer yamllint
```

Linter configuration lives in `.github/linters`. Prettier uses its default configuration without repository-specific
configuration or ignore files. CI uses the same configuration choices; tool versions can differ locally.

## Workflow security checks

Make zizmor and Gitleaks available on `PATH`. Run both checks with the same pedantic persona and Gitleaks configuration
used by CI.

```bash
composer security
```

Each tool also has its own script. Zizmor uses GitHub API access for online audits;
an explicit offline check is available.

```bash
composer zizmor -- --offline
composer gitleaks
```

These checks do not replace a security review of application code or browser assets. Use `composer audit` separately
to check dependency advisories.

Report hosted CI execution and its PHP/OS matrix separately from local checks. Keep generated maintainer reports in
ignored `internal/`, which is excluded from Git and from distribution archives and is not part of the package.

## Browser verification

The tests check markup only. Load the matching Bootstrap assets in an application to assess visual output and
interactions. Bootstrap 6 coverage targets `6.0.0-alpha.1`; its navbar is static, and its ES modules require
application integration. A theme selector does not switch color schemes by itself.

## Passing extra arguments

Composer scripts support forwarding additional arguments using `--`.

Run Testo with a Clover code coverage report (needs PCOV or Xdebug).

```bash
composer tests -- --coverage-clover=runtime/coverage/clover.xml
```

Run one test class or group.

```bash
composer tests -- --filter=Bootstrap5ThemeTest
composer tests -- --group=theme
```

Run PHPStan with a different memory limit.

```bash
composer static -- --memory-limit=512M
```

[Back to documentation](../README.md#documentation)
