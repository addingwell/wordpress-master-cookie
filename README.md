# Wordpress Master Cookie

A simple plugin to create a visitor UUID server cookie named _aw_master_id.

- [Wordpress Master Cookie](#wordpress-master-cookie)
  - [Description](#description)
  - [Installation](#installation)
  - [Frequently Asked Questions](#frequently-asked-questions)
    - [How does this plugin work?](#how-does-this-plugin-work)
  - [Security](#security)
    - [Bearer](#bearer)
    - [Add exception](#add-exception)
    - [Current exceptions](#current-exceptions)
  - [Screenshots](#screenshots)
  - [Changelog](#changelog)
  - [Upgrade Notice](#upgrade-notice)

## Description

This plugin sets a unique UUID for each visitor and stores it as a server-side cookie called `_aw_master_id`. 
The cookie lifetime is set to 13 months.

- Contributors: Addingwell
- Tags: uuid, cookie, visitor, tracking
- Requires at least: 4.6
- Tested up to: 5.7
- Requires PHP: 5.6
- Stable tag: trunk
- License: GPLv2 or later
- License URI: https://www.gnu.org/licenses/gpl-2.0.html

## Installation

1. Upload the plugin files to the `/wp-content/plugins/visitor-uuid-cookie` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.

## Frequently Asked Questions

### How does this plugin work?

The plugin generates a UUID for each visitor who is not logged in and stores it in a cookie named `_aw_master_id` and in the server-side session.

## Security 

### Bearer

To ensure the security of AddingWell’s codebase, this repository uses [Bearer](https://www.bearer.com/bearer-cli) to scan and detect vulnerabilities in code. Bearer is an open-source static analysis tool, improving the overall security of the development lifecycle.

### Add exception

Some Bearer detections may flag content that is a false positive. In such cases, you can whitelist specific findings to prevent unnecessary alerts. To do so, use `bearer:disable` comment immediately before the block where the vulnerability is found.

```
// bearer:disable php_lang_exception
throw new Exception("error for {$user->email}");
```

### Current exceptions

There are no exceptions yet.

| Rule ID                  | File                        | Justification         |
| ------------------------ | --------------------------- | --------------------- |
| _Eg: php_lang_exception_ | _Eg: mastercookie/index.php:34_ | _Eg: Write justification_ |

### Gitleaks

To ensure the security of AddingWell’s codebase, this repository uses Gitleaks to scan and detect potential sensitive information leaks within version control. Gitleaks is an open-source static analysis tool that helps identify secrets and sensitive data, protecting against accidental exposure and improving the overall security of the development lifecycle.

The implementation of Gitleaks in this repository allows you to:

- Detect secrets such as API keys, credentials, and tokens that may have been accidentally committed to the repository.
- Automate secret scanning across all branches and pull requests, ensuring sensitive data is identified early in the development process.
- Continuously monitor and validate that sensitive information is not exposed in the repository, reducing the risk of data breaches.
- Generate detailed reports on scan results, providing developers information to fix the problem.

### Add exception

Some Gitleaks detections may flag content that is not truly sensitive or is a false positive. In such cases, you can whitelist specific rules or files to prevent unnecessary alerts. To do so, comment the line where the secret is detected with this comment : `#gitleaks:allow`

```
SECRET=fake_password #gitleaks:allow
```

### Current exceptions

| Secret id                                                                                                            | Justification             |
|----------------------------------------------------------------------------------------------------------------------|---------------------------|


| 💡 Id are formed like this : <commit_hash>:<file_path>:<secret_type>:<line>

## Screenshots

1. No screenshots needed for this simple plugin.

## Changelog

1.0
* Initial release.

## Upgrade Notice

1.0
Initial release.
