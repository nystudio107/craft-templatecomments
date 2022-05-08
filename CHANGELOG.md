# Template Comments Changelog

## 4.0.0 - 2022.05.07
### Added
* Initial release for Craft CMS 4

## 4.0.0-beta.2 - 2022.03.12

### Added

* Added `excludeBlocksThatContain` config setting to allow excluding of template comments based on the `{% block %}` name

## 4.0.0-beta.1 - 2022.03.12

### Added

* Initial Craft CMS 4 compatibility

## 1.1.2 - 2019-08-25
### Changed
* Don't check `getIsAjax()` for console requests

## 1.1.1 - 2019-08-24
### Changed
* Don't install event listeners for AJAX requests

## 1.1.0 - 2019-06-12
### Changed
* Fixed an issue with Craft CMS `^3.1.29` due to it requiring Twig `^2.11.0` that caused imported macros to not be scoped properly
* Template Comments now _requires_ Craft CMS `^3.1.29`

## 1.0.6 - 2019-02-23
### Changed
* Fixed an issue that caused unparsed tags to be generated for Twig's `source()` function

## 1.0.5 - 2019-01-25
### Changed
* Fixed a regression that caused it to throw an exception on console requests

## 1.0.4 - 2019-01-22
### Changed
* Do nothing at all on AJAX requests

## 1.0.3 - 2018-12-04
### Changed
* Fixed an issue that could result in a compile error if the `CommentsNode` had no `body`

## 1.0.2 - 2018-10-04
### Changed
* Only parse templates that end in `.twig`, `.htm`, `.html` or that have no extension

## 1.0.1 - 2018-10-02
### Added
* Added performance timings to the `<<< END <<<` comments
* Fixed an issue with comments appearing inline in field heading tags in the Control Panel
* Disabled Template Comments by default in the Control Panel, because most people won't want them there

## 1.0.0 - 2018-10-02
### Added
* Initial release
