# Contributing

Welcome to the SolarPoint community, and thank you for contributing! The following guide outlines the basics of how to get involved.

Have any questions about contributing to this project? Ask them on [GitHub Discussions](https://github.com/solarpointwp/solarpoint-framework/discussions/categories/q-a).

## Table of Contents

- [How You Can Help](#how-you-can-help)
- [Before You Get Started](#before-you-get-started)
    - [Community Guidelines](#community-guidelines)
    - [Project Licensing](#project-licensing)
    - [AI-Assisted Contributions](#ai-assisted-contributions)
    - [Governance](#governance)
- [Getting Help & Support](#getting-help--support)
- [Submitting Issues](#submitting-issues)
    - [Bug Reports](#bug-reports)
    - [Feature Requests](#feature-requests)
- [Triaging Issues](#triaging-issues)
- [Your First Contribution](#your-first-contribution)
- [Local Development Setup](#local-development-setup)
    - [Prerequisites](#prerequisites)
    - [Installation](#installation)
    - [Git Configuration](#git-configuration)
    - [Monorepo Architecture](#monorepo-architecture)
- [Coding Standards](#coding-standards)
- [Deprecation Policy](#deprecation-policy)
- [Development Workflow](#development-workflow)
    - [Branching Strategy](#branching-strategy)
    - [Writing Tests](#writing-tests)
    - [Commit Messages](#commit-messages)
    - [Commit Signing](#commit-signing)
- [Opening a Pull Request](#opening-a-pull-request)
    - [Submitting Code](#submitting-code)
    - [Submitting Documentation](#submitting-documentation)
    - [PR Requirements](#pr-requirements)
    - [Review Process](#review-process)
- [Project Communication](#project-communication)
    - [Global Communication Standards](#global-communication-standards)
    - [GitHub Discussions](#github-discussions)
    - [Using GitHub Issues and Discussions](#using-github-issues-and-discussions)
    - [Project and Development Updates](#project-and-development-updates)

## How You Can Help

You can contribute to this project in several ways. Here are some examples:

- Report and triage bugs.
- Contribute to the codebase and documentation.
- Request new features or improvements.
- Write blog posts or tutorials about the project.
- Help others by answering questions about this project.

Anything else that could enhance the project!

## Before You Get Started

### Community Guidelines

This project follows a [Code of Conduct](https://github.com/solarpointwp/solarpoint-framework?tab=coc-ov-file) that all community members are asked to read and abide by.

### Project Licensing

By submitting a pull request, you represent that you have the right to license your contribution to the project and the community. All contributions are licensed under the [GPL-3.0-or-later](LICENSE) license.

### AI-Assisted Contributions

AI tools are not prohibited. They are a normal part of modern development, and the requirement is understanding, not avoidance.

If you use AI tooling in any part of your contribution, you must disclose this in the Pull Request. All AI-assisted contributions are held to the exact same standards as any other submission:

- **Total Ownership:** You are fully responsible for every line of code you submit, regardless of how it was generated. When you sign your commits (DCO), you are certifying you have the right to submit this code.
- **Comprehension:** Code that you cannot explain, debug, or defend during the review process will not be merged.
- **Human Context:** Pull Request descriptions must be written in your own words. PRs with generic, AI-generated descriptions, or low-effort AI dumps without human insight, will be closed.
- **License Compatibility:** All contributions must be compatible with the project's GPL-3.0-or-later license. You must avoid AI tools whose terms restrict GPL usage or impose redistribution limitations on generated output.

AI tools should be used to **enhance, not replace** the human elements that make OSS special: learning, collaboration, and community growth.

### Governance

At project launch, SolarPoint has a light governance structure. The intention is for the community to evolve and adopt additional processes as participation grows. Stay tuned, and stay engaged! Your feedback is welcome.

## Getting Help & Support

Questions, troubleshooting, and usage discussions belong in [GitHub Discussions](https://github.com/solarpointwp/solarpoint-framework/discussions/categories/q-a). Search existing discussions before starting a new topic.

See the [support documentation](SUPPORT.md) for full guidance on where to direct your inquiry, how to ask quality questions, and what to expect from the community.

> [!IMPORTANT]
> GitHub Issues are reserved for confirmed bug reports and approved feature requests. Support questions opened as issues will be converted or closed.

## Submitting Issues

All issues related to SolarPoint should be submitted to the [issue tracker](https://github.com/solarpointwp/solarpoint-framework/issues). See the [support documentation](SUPPORT.md) for detailed guidance on what to include in your report.

> [!IMPORTANT]
> Do not open public issues for security vulnerabilities. Refer to the [security policy](https://github.com/solarpointwp/solarpoint-framework/security/policy) for reporting instructions.

**For new features or significant changes, open an issue before submitting a pull request.** Filing an issue first allows the maintainers and community to discuss the design before significant time is invested.

**Small fixes such as documentation fixes, typo corrections, and minor bug fixes do not require an issue.** A pull request on its own is sufficient. This is a judgement call, and a maintainer may ask you to file an issue if larger design decisions are involved.

### Bug Reports

Before submitting a new bug report, review the [support documentation](SUPPORT.md) and search [existing issues](https://github.com/solarpointwp/solarpoint-framework/issues) to see if the problem has already been reported.

[Submit a bug report →](https://github.com/solarpointwp/solarpoint-framework/issues/new?template=01-bug-report.yml)

### Feature Requests

Before submitting a feature request, check the [existing issues](https://github.com/solarpointwp/solarpoint-framework/issues) and active [pull requests](https://github.com/solarpointwp/solarpoint-framework/pulls) to see if anyone is already working on it. If not, open a [GitHub Discussion](https://github.com/solarpointwp/solarpoint-framework/discussions/categories/ideas) before writing any code to confirm it aligns with the project's direction. This will save you from investing time on a feature that may not be accepted.

[Submit a feature request →](https://github.com/solarpointwp/solarpoint-framework/issues/new?template=02-feature-request.yml)

## Triaging Issues

Triage helps ensure issues are resolved quickly by:

- Ensuring the issue's intent is clearly conveyed so contributors have what they need before starting work.
- Preventing duplicate issues and discussions.
- Keeping the issue tracker organized and actionable.

If you don't have the time or background to contribute code, consider helping with triage instead. You can ask clarifying questions, reproduce reported bugs, identify duplicates, and suggest workarounds directly in the issue comments. No repository access is required.

As the project grows, trusted contributors may be granted the GitHub **Triage** role, allowing them to manage labels and organize issues without write access to the codebase.

## Your First Contribution

New to open source or to this project? Welcome.

- Look for issues labeled [`good first issue`](https://github.com/solarpointwp/solarpoint-framework/issues?q=is%3Aissue+is%3Aopen+label%3A%22good+first+issue%22) for approachable starting points.
- Ask questions in [GitHub Discussions](https://github.com/solarpointwp/solarpoint-framework/discussions/categories/q-a) before starting work on anything non-trivial. It is far better to check alignment upfront than to have a PR rejected after significant effort.
- Small contributions such as documentation fixes, additional test coverage, and typo corrections are just as valued as new features.

## Local Development Setup

### Prerequisites

- Git
- PHP 8.1 or higher
- Composer
- A local WordPress environment (required for integration tests)

### Installation

1. [Fork](https://docs.github.com/en/pull-requests/collaborating-with-pull-requests/working-with-forks/fork-a-repo) and clone the repository:

   ```bash
   git clone https://github.com/YOUR-USERNAME/solarpoint-framework.git
   ```

2. Add the upstream remote to keep your fork in sync:

   ```bash
   git remote add upstream https://github.com/solarpointwp/solarpoint-framework.git
   ```

3. Install PHP dependencies:

   ```bash
   composer install
   ```

### Git Configuration

Make sure your name and email are configured in Git. These must match your GitHub account for the DCO check to pass:

```bash
git config user.name "Your Name"
git config user.email "your@email.com"
```

### Monorepo Architecture

SolarPoint is structured as a monorepo. The `packages/` directory contains the individual components that make up the framework, each with its own test suite under `packages/*/tests/`.

Each package declares its own dependencies in `packages/*/composer.json`. These are mirrored in the root `composer.json`, so a single `composer install` at the project root is sufficient for all development and testing.

## Coding Standards

All code contributions must pass automated quality checks before being reviewed. Run `composer cs:fix` to apply formatting, then `composer qa` to verify coding standards, static analysis, and tests all pass.

### PHP CS Fixer

Code style follows [@PhpCsFixer](https://cs.symfony.com/doc/ruleSets/PhpCsFixer.html) (based on [PER Coding Style 3.0](https://www.php-fig.org/per/coding-style/)) with custom modifications. Run `composer cs:fix` to apply all formatting and do not hand-format; let the fixer decide.

> [!NOTE]
> See `.php-cs-fixer.dist.php` for the full ruleset.

Notable rules and overrides:

- **No Yoda conditions:** Write `$value === null` rather than `null === $value`.
- **Void returns:** Always declare `: void` on void methods.
- **Type ordering:** Ensure `null` is always the last element in union types (e.g., `string|int|null`).
- **Namespace imports:** Use `use` statements instead of inline fully-qualified class names.
- **Strict types:** Include `declare(strict_types=1)` in all PHP files.

### PHPStan

All code must pass PHPStan static analysis at `max` level. See `phpstan.neon.dist` for the configuration. Static analysis failures are blocking in CI and must be resolved.

### Naming Conventions

| Construct | Convention | Example |
| --- | --- | --- |
| Classes | `UpperCamelCase` | `PluginLoader` |
| Abstract classes | `Abstract` prefix | `AbstractHook` |
| Interfaces | `Interface` suffix | `HookInterface` |
| Traits | `Trait` suffix | `SingletonTrait` |
| Exceptions | `Exception` suffix | `InvalidConfigException` |
| Methods and variables | `camelCase` | `hasContainer()` |
| Constants | `SCREAMING_SNAKE_CASE` | `DEFAULT_PRIORITY` |

### PHPDoc

- Add PHPDoc blocks only when they provide information not already expressed by type hints.
- Avoid writing PHPDoc blocks that simply restate the type signature.
- Place `null` at the end of union types.

## Deprecation Policy

Public APIs are never removed without first going through a deprecation cycle. This protects downstream code from unexpected breakage.

**Three-step deprecation process:**

1. **PHPDoc:** Mark the method, class, or property with `@deprecated`:

   ```php
   /**
    * @deprecated since 1.2, use Bar::newMethod() instead.
    */
   public function oldMethod(): void
   ```

2. **Runtime notice:** Trigger a deprecation inside the method body so it surfaces during testing (only when `WP_DEBUG` is enabled):

   ```php
   if (defined('WP_DEBUG') && WP_DEBUG) {
       trigger_error('Call Bar::newMethod() instead.', E_USER_DEPRECATED);
   }
   ```

3. **CHANGELOG entry:** Document the deprecation under the appropriate version in `CHANGELOG.md`.

The deprecated API remains functional until the next major version, at which point it is removed.

> [!IMPORTANT]
> To prevent breaking changes, you must never:
>
> - Remove a public API in a minor or patch release without a prior deprecation cycle.
> - Change the signature of a public method in a patch release.
> - Change exception messages in a patch release, as downstream code may depend on them.

## Development Workflow

This section outlines the step-by-step process for moving a contribution from a local idea to a merged Pull Request.

### Branching Strategy

The default branch on GitHub is always the current active version branch (e.g., `1.x`). The `main` branch reflects the latest stable release and is never committed to directly. All active development occurs on version branches.

#### How Version Branches Work

**Creation:** When a new major version enters active development, a new version branch is created (e.g., `2.x`).

**Maintenance:** Standard bug fixes are maintained for the lowest actively supported version branch. Security vulnerabilities are patched for all actively maintained version branches until they reach end-of-life.

**Propagation:** Bug fixes are applied to the lowest actively maintained version branch and cherry-picked forward to newer branches by maintainers. Critical security fixes are applied across all relevant version branches simultaneously.

#### Branch Naming Conventions

Branch names should follow the format `<prefix>/<description>` using lowercase letters, numbers, and hyphens. Include the issue number where applicable.

| Prefix | Purpose | Target Branch |
| --- | --- | --- |
| `feature/` | New features or enhancements | Next version branch (e.g., `2.x`) |
| `bugfix/` | Regular bug fixes | Lowest actively maintained version branch |
| `security/` | Patches for confirmed security vulnerabilities | All actively maintained version branches |
| `hotfix/` | Urgent production-breaking fixes (non-security) | Latest version branch (merged to `main` via release) |
| `chore/` | Maintenance, documentation, or dependencies | Appropriate version branch |

> [!IMPORTANT]
> Do not target `main` directly. Pull requests targeting `main` will be closed.

> [!TIP]
> If you are unsure which version branch to target, ask in the linked issue. When in doubt, target the highest-numbered `x.x` branch.

**Examples:**

```text
feature/hook-priority-ordering
bugfix/issue-42-container-null-dereference
hotfix/fix-production-crash
chore/update-installation-guide
chore/update-dependencies
```

### Writing Tests

All new features must include unit tests. Bug fixes must include a regression test: a test that fails before the fix is applied and passes afterward.

#### Test Location & Execution

Tests are located within each package at `packages/*/tests/`. The root `phpunit.xml.dist` defines the test suites and environment settings for the entire monorepo.

- **Run all tests:** Execute `composer test` from the project root.
- **Run package tests:** To save time, run tests for a single package: `vendor/bin/phpunit packages/<package-name>/tests`.
- **Unit vs. Integration:** Most tests should be "pure" unit tests that mock WordPress functions to ensure speed. Only use a full WordPress bootstrap (integration tests) when testing direct interactions with the WordPress database or the plugin/theme lifecycle.

#### CI & Strict Mode

Our PHPUnit configuration is set to strict mode. The following will cause CI to fail and must be resolved, not suppressed:

- **Risky tests:** These are tests that do not perform any assertions or have unintended side effects (e.g., a test that modifies a global variable but never checks the result).
- **Deprecations:** Any `E_USER_DEPRECATED` notices or `@deprecated` tags triggered during the test run.
- **PHP errors:** All standard PHP warnings, notices, and errors triggered in the source code.

#### Best Practices & Quality

- **Mocking:** Use mocking utilities to isolate the code under test. This ensures your tests remain fast and do not require a live WordPress environment unless absolutely necessary.
- **Naming conventions:** Test classes must mirror the source class name with a Test suffix. For example, a class located at `src/PluginLoader.php` should have a corresponding test at `tests/PluginLoaderTest.php`.
- **Coverage:** While we don't enforce a strict percentage, aim for meaningful coverage of all logical paths. Avoid "happy path only" testing; ensure edge cases and error states are accounted for.
- **Isolation:** Tests should never rely on the state of a previous test. Always use `setUp()` and `tearDown()` to reset the environment.

### Commit Messages

SolarPoint follows the [Conventional Commits](https://www.conventionalcommits.org/) specification. This consistency allows us to automatically generate changelogs, determine semantic version bumps, and maintain a readable project history.

#### Message Format

Every commit must follow this structural pattern:

```text
<type>[optional scope]: <description>

[optional body]

[optional footer(s)]
```

#### Common Types

| Type | Purpose |
| --- | --- |
| `feat` | A new feature (correlates with MINOR in SemVer) |
| `fix` | A bug fix (correlates with PATCH in SemVer) |
| `docs` | Documentation changes only |
| `style` | Formatting changes that do not affect code logic |
| `refactor` | Code changes that neither fix a bug nor add a feature |
| `perf` | A change that improves performance |
| `test` | Adding or updating tests |
| `chore` | Routine maintenance, dependencies, or configuration |
| `ci` | Changes to CI configuration and workflows |
| `revert` | Reverts a previous commit |

#### Contribution Rules

- **Imperative mood:** Use "add", "fix", or "remove" rather than "added" or "fixes" to describe the action taken.
- **Lowercase description:** Start the description with a lowercase letter to maintain a clean, uniform log.
- **Character limit:** Limit the subject line to 72 characters or fewer to ensure readability across all Git interfaces.
- **Specific scoping:** Use an optional scope in parentheses to provide context, such as `feat(logger): add new handler`.
- **Issue referencing:** Place references to issues in the commit body or footer instead of the subject line.
- **Atomic commits:** Focus each commit on a single change to keep the codebase stable and the history easy to navigate.

#### Breaking Changes

Breaking changes (correlating with MAJOR in SemVer) must be highlighted so they aren't missed during automated releases. You can indicate these in two ways:

- **The Bang (!):** Append a `!` immediately before the colon, e.g., `feat(mailer)!: remove SMTP transport provider`.
- **The Footer:** Include `BREAKING CHANGE:` as the first words of a footer, followed by a description of the change.

A Breaking Change with a Footer:

```text
refactor(logger): update error reporting signature

This change ensures all error logs include a mandatory error code for better debugging.

BREAKING CHANGE: the log() method now requires a numeric error code as the second argument.
```

### Commit Signing

All commits must be signed off using the [Developer Certificate of Origin (DCO)](https://developercertificate.org/). By adding a `Signed-off-by` line to your commits, you certify that you wrote the code and have the right to submit it under the project's license.

```text
Developer Certificate of Origin
Version 1.1

Copyright (C) 2004, 2006 The Linux Foundation and its contributors.

Everyone is permitted to copy and distribute verbatim copies of this
license document, but changing it is not allowed.


Developer's Certificate of Origin 1.1

By making a contribution to this project, I certify that:

(a) The contribution was created in whole or in part by me and I
    have the right to submit it under the open source license
    indicated in the file; or

(b) The contribution is based upon previous work that, to the best
    of my knowledge, is covered under an appropriate open source
    license and I have the right under that license to submit that
    work with modifications, whether created in whole or in part
    by me, under the same open source license (unless I am
    permitted to submit under a different license), as indicated
    in the file; or

(c) The contribution was provided directly to me by some other
    person who certified (a), (b) or (c) and I have not modified
    it.

(d) I understand and agree that this project and the contribution
    are public and that a record of the contribution (including all
    personal information I submit with it, including my sign-off) is
    maintained indefinitely and may be redistributed consistent with
    this project or the open source license(s) involved.
```

#### How to Sign Your Commits

Add the sign-off using the `-s` flag:

```bash
git commit -s -m "fix: short description of the change"
```

This produces:

```text
Signed-off-by: Your Name <your@email.com>
```

> [!IMPORTANT]
> Make sure your [Git configuration](#git-configuration) is set up before committing.

#### Fixing a Missing Sign-off

If you have already committed and forgot to include the sign-off, you can fix it without needing to redo your work.

For the most recent commit:

```bash
git commit --amend --no-edit -s
```

For multiple previous commits:

```bash
# Replace 'n' with the number of commits you need to sign
git rebase --signoff HEAD~n
```

After fixing the commits locally, you will need to force-push the changes to your fork:

```bash
git push --force-with-lease origin HEAD
```

## Opening a Pull Request

For significant changes, ensure your contribution corresponds to an open issue before opening a pull request. For small fixes, a pull request on its own is sufficient. See the [support documentation](SUPPORT.md) for additional guidance.

### Submitting Code

Code contributions must meet the project's strict quality and testing standards.

- **Branch:** Create a branch from the appropriate version branch (e.g., `1.x`). See [Branching Strategy](#branching-strategy).
- **Standards:** Ensure your code adheres to the [Coding Standards](#coding-standards).
- **Tests:** Include or update tests as necessary. See [Writing Tests](#writing-tests).
- **Quality:** Run `composer qa` before committing.
- **Commit:** Sign your commits and follow the [Commit Messages](#commit-messages) format.

### Submitting Documentation

Documentation improvements are highly valued and do not require running the full code quality suite.

- **Branch:** Create a branch for your edits. See [Branching Strategy](#branching-strategy).
- **Style:** Ensure your language is clear and follows the [Global Communication Standards](#global-communication-standards).
- **Commit:** Use the `docs:` prefix in your commit message (e.g., `docs: add section to getting started`).

### PR Requirements

Before hitting "Create pull request", ensure your submission meets these criteria:

- **One focus per PR:** Do not mix unrelated changes. Each commit should be atomic and leave the project in a working state. See [Commit Messages](#commit-messages).
- **Linked issue:** Reference an existing issue if one was created (e.g., `Fixes #123`).
- **Conventional title:** Follow the [Conventional Commits](https://www.conventionalcommits.org/) format (e.g., `feat: add container support`).
- **Human description:** Fill out the PR template in your own words. Generic or AI-generated descriptions will be returned for revision.
- **Root .gitignore:** Do not add editor specific entries. Maintain a global `.gitignore` file instead.
- **Passing CI:** All automated checks must pass. If CI fails, resolve the errors before requesting a review.
- **License:** All contributions are licensed under [GPL-3.0-or-later](LICENSE).

We require that your Pull Request description matches our template. A new Pull Request description will be automatically pre-populated based on `pull_request_template.md` content.

> [!IMPORTANT]
> See the [support documentation](SUPPORT.md) for full context on what qualifies as an approved contribution.

### Review Process

Once a Pull Request is opened:

- **CI Checks:** Code style checks, static analysis, and automated tests will run. These must pass before a human review begins.
- **Feedback:** A maintainer will review your contribution. Be prepared to discuss your implementation and make requested changes.
- **Approval:** Once approved, your PR will be merged into the active development branch and eventually included in the next release.

Pull requests labeled `needs info` that receive no response will be marked stale after 30 days and closed after 7 additional days. They can be reopened once you are ready to continue.

Draft PRs are welcome for early feedback. Convert to "Ready for Review" once complete. Drafts left inactive for more than 7 days may be closed, but can be reopened when you are ready to proceed.

## Project Communication

### Global Communication Standards

To ensure consistency and clarity across a global community, the following standards apply to all documentation, issues, and discussions:

- **Simplicity First:** This project serves an international audience. Strive for simple, clear language and avoid unnecessary jargon or complex idioms.
- **Language & Grammar:** Use modern American English spellings and grammar for all public-facing documentation, commit messages, and release notes.
- **Dates & Time:** Prefer only [ISO 8601](https://www.iso.org/iso-8601-date-and-time-format.html) / [IETF RFC 3339](https://datatracker.ietf.org/doc/html/rfc3339) date and time formats.
- **Units of Measure:** Where applicable, prefer Metric (SI) units.
- **Secure Links:** Always use `https` URLs. Ensure links are direct and do not rely on unnecessary redirects.

### GitHub Discussions

Join the conversation, ask questions, and help improve the SolarPoint framework on [GitHub Discussions](https://github.com/solarpointwp/solarpoint-framework/discussions). The discussions are organized into categories to help you find what you need:

- **Announcements:** For official development announcements, release notes, and project updates.
- **General:** For community chat and topics that don't fit anywhere else.
- **Ideas:** For proposing new features, architectural changes, or discussing the framework's direction.
- **Q&A:** For technical questions, troubleshooting, and general support related to the SolarPoint framework.

### Using GitHub Issues and Discussions

While both GitHub Issues and Discussions are great places to collaborate, they serve very different purposes. Here is a quick guide on where to post:

GitHub Issues should be used for tracking actionable tasks. If you know the specific code that needs to be changed, it goes in Issues. Everything else goes to Discussions. For example:

- I am experiencing a weird error when using the framework, but I am not sure why: *Discussions (Q&A)*.
- There is a bug in a specific class or method (e.g., a line of code is causing a crash): *GitHub Issues*.
- I have an idea for a new architectural component or feature: *Discussions (Ideas)*.
- Implementing an agreed-upon feature or fix: *GitHub Issues*.

### Project and Development Updates

Stay connected to the project and the community as the framework evolves. Official development announcements and project updates are regularly posted in the **Announcements** category within GitHub Discussions.

To receive notifications about new features, updates, and releases, click the **Watch** button at the top right of the repository and select your notification preferences (such as Custom → Releases or Discussions).
