# Template Comments Changelog

## 4.0.2 - 2024.08.06
### Fixed
* Fixed an issue where Template Comments would cause the Craft Closure `^1.0.6` package to not work

## 4.0.1 - 2024.04.18
### Added
* Added support for template comments for `{% include %}` and `{% extends %}` back into the plugin ([#40](https://github.com/nystudio107/craft-templatecomments/issues/40))
* Add `phpstan` and `ecs` code linting
* Add `code-analysis.yaml` GitHub action

### Changed
* Updated docs to use node 20 & a new sitemap plugin
* PHPstan code cleanup
* ECS code cleanup

## 4.0.0 - 2022.05.07
### Added
* Initial release for Craft CMS 4

## 4.0.0-beta.2 - 2022.03.12

### Added

* Added `excludeBlocksThatContain` config setting to allow excluding of template comments based on the `{% block %}` name

## 4.0.0-beta.1 - 2022.03.12

### Added

* Initial Craft CMS 4 compatibility
