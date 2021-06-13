# Changelog

## [Unreleased](https://github.com/davidhsianturi/laravel-compass/compare/v1.2.1...HEAD)

## [v1.2.1 (2021-06-13)](https://github.com/davidhsianturi/laravel-compass/compare/v1.2.0...v1.2.1)

## Changes

- Allow host as a fallback domain when using variable domain ([#162](https://github.com/davidhsianturi/laravel-compass/pull/162))

## [v1.2.0 (2021-01-12)](https://github.com/davidhsianturi/laravel-compass/compare/v1.1.1...v1.2.0)

## Changes

- Make the example response body editable ([#123](https://github.com/davidhsianturi/laravel-compass/pull/123))

## [v1.1.1 (2020-12-12)](https://github.com/davidhsianturi/laravel-compass/compare/v1.1.0...v1.1.1)

## Changes

- PHP 8 support (#123)

## [v1.1.0 (2020-10-05)](https://github.com/davidhsianturi/laravel-compass/compare/v1.0.1...v1.1.0)

## Changes

- Add Laravel 8 support ([#103](https://github.com/davidhsianturi/laravel-compass/pull/103))
- Update Tailwind config file ([#100](https://github.com/davidhsianturi/laravel-compass/pull/100))
- Adding release drafter action ([#84](https://github.com/davidhsianturi/laravel-compass/pull/84))

## [v1.0.1 (2020-06-13)](https://github.com/davidhsianturi/laravel-compass/compare/v1.0.0...v1.0.1)

### Fixed
- Testing fixes ([@4fb6ecc ](https://github.com/davidhsianturi/laravel-compass/commit/dd16971cb407500c3b65fdd58b04168b34f4f2a5))

## [v1.0.0 (2020-04-03)](https://github.com/davidhsianturi/laravel-compass/compare/v0.6.0...v1.0.0)

### Added
- Authenticator for auth requests ([#76](https://github.com/davidhsianturi/laravel-compass/pull/76))
- Laravel 7 support ([#71](https://github.com/davidhsianturi/laravel-compass/pull/71))

### Changed
- Revamped the UI ([#73](https://github.com/davidhsianturi/laravel-compass/pull/73))
- Change `ApiDocsRepository` to `DocumenterRepository` ([#79](https://github.com/davidhsianturi/laravel-compass/pull/79))

### Removed
- Dropped support for Laravel 5.8

## [v0.6.0 (2020-03-08)](https://github.com/davidhsianturi/laravel-compass/compare/v0.5.1...v0.6.0)

### Added
- New request tab to manage query parameters ([#64 ](https://github.com/davidhsianturi/laravel-compass/pull/64))
- Add spotlight search to quickly find the endpoints ([#66 ](https://github.com/davidhsianturi/laravel-compass/pull/66))

## [v0.5.0 (2020-02-22)](https://github.com/davidhsianturi/laravel-compass/compare/v0.4.1...v0.5.0)

### Added
- Add response preview ([#57](https://github.com/davidhsianturi/laravel-compass/pull/57))
- Add auth tab components ([#59](https://github.com/davidhsianturi/laravel-compass/pull/59))
- Add default header ([@cadbac8](https://github.com/davidhsianturi/laravel-compass/commit/cadbac825efe8008ce212b1deefb4643b939383c))

### Changed
- Tidy up the front-end ([#60](https://github.com/davidhsianturi/laravel-compass/pull/60))

## [v0.4.1 (2020-01-11)](https://github.com/davidhsianturi/laravel-compass/compare/v0.4.0...v0.4.1)

### Fixed
- Fixed data-table for request header ([@a6bd01a](https://github.com/davidhsianturi/laravel-compass/commit/a6bd01ac27a31575f1130c5a3dfbcd4beb8a3d4a))

## [v0.4.0 (2019-12-13)](https://github.com/davidhsianturi/laravel-compass/compare/v0.3.0...v0.4.0)

### Added
- Add support for sub-domain routing ([#83d2541](https://github.com/davidhsianturi/laravel-compass/pull/53))
- New header select options component ([@8d6d5e8](https://github.com/davidhsianturi/laravel-compass/commit/7806673eb6108218524418b6c09cdc6757ba4f9e))

### Changed
- Removed forbidden header name from the suggestion list ([@c358263](https://github.com/davidhsianturi/laravel-compass/commit/8d6d5e86b4a2a8e796f3c87d3a20887bdffe684f))
- The selected method now saved to storage ([@33fbcce](https://github.com/davidhsianturi/laravel-compass/commit/6afadd081403e0127d49a9da7bf56ffb0c695c18))
- Use a selected method to the request list ([@0a322cd](https://github.com/davidhsianturi/laravel-compass/commit/ae5f2066ca92f9681390ff93d5d7e6afe6c76449))
- Dropped support for Laravel 5.7 ([@eb732c5](https://github.com/davidhsianturi/laravel-compass/commit/347a3bd7122ca44471523b80e6fa7570f9c061ba))

### Fixed
- Fix request body key type dropdown in Firefox ([@7806673](https://github.com/davidhsianturi/laravel-compass/commit/b80509753431ae38037778660dfa9b9fc81d4434))

## [v0.3.0 (2019-11-25)](https://github.com/davidhsianturi/laravel-compass/compare/v0.2.0...v0.3.0)

### Added
- Added more options to exclude the routes ([#40](https://github.com/davidhsianturi/laravel-compass/pull/40))
- Added form urlencoded & raw request body options ([#39](https://github.com/davidhsianturi/laravel-compass/pull/39))

### Fixed
- Fixed render HTTP response time and size components in `ResponseTabs.vue` ([71b7d38](https://github.com/davidhsianturi/laravel-compass/commit/71b7d3887f624e238043e22543cab21859bd4cfe))

## [v0.2.0 (2019-11-08)](https://github.com/davidhsianturi/laravel-compass/compare/v0.1.1...v0.2.0)

### Added
- Added HTTP methods component ([#26](https://github.com/davidhsianturi/laravel-compass/pull/26))
- Added HTTP status component ([#32](https://github.com/davidhsianturi/laravel-compass/pull/32))
- Added HTTP response size and timing component ([#35](https://github.com/davidhsianturi/laravel-compass/pull/35))

## [v0.1.1 (2019-10-31)](https://github.com/davidhsianturi/laravel-compass/compare/v0.1.0...v0.1.1)

### Fixed
- Fixed redirection route methods ([#12](https://github.com/davidhsianturi/laravel-compass/pull/12))
