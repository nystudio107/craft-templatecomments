# Template Comments Changelog

## 4.0.3 - 2024.09.06
###  Changed
* Template Comments now requires `craftcms/cms` `^4.12.0` going forward, because of the addition of breaking changes in the version of Twig that it requires

### Fixed
* Fixed an issue with a change in Twig `3.12.0` (which is now used by Craft `4.12.0`) which would cause an exception to be thrown when rendering templates with an empty `{% block %}` tag ([#46](https://github.com/nystudio107/craft-templatecomments/issues/46))
* Fixed an issue with a change in Twig `3.12.0` (which is now used by Craft `4.12.0`) which would cause an exception to be thrown when rendering templates ([#45](https://github.com/nystudio107/craft-templatecomments/issues/45))

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
