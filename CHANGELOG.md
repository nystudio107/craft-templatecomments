# Template Comments Changelog

## 5.0.6 - 2026.01.30
###  Changed
* Template Comments now requires `craftcms/cms` `^5.9.0` going forward, because of the addition of breaking changes in the version of Twig that it requires ([#52](https://github.com/nystudio107/craft-templatecomments/issues/52))
* Updated `TemplateCommentsParser.php` to match Twig `3.23.x`'s `Parser` ([#52](https://github.com/nystudio107/craft-templatecomments/issues/52))

## 5.0.5 - 2026.01.29
###  Changed
* Template Comments now requires `craftcms/cms` `^5.6.0` going forward, because of the addition of breaking changes in the version of Twig that it requires ([#51](https://github.com/nystudio107/craft-templatecomments/issues/51))
* Updated `TemplateCommentsParser.php` to match Twig `3.15.x`'s `Parser` ([#51](https://github.com/nystudio107/craft-templatecomments/issues/51))

## 5.0.4 - 2024.11.29
###  Changed
* Defer installing Template Comments until Craft is fully setup, to avoid a "Twig instantiated before Craft is fully initialized" warning ([#50](https://github.com/nystudio107/craft-templatecomments/issues/50))

## 5.0.3 - 2024.09.06
###  Changed
* Template Comments now requires `craftcms/cms` `^5.4.0` going forward, because of the addition of breaking changes in the version of Twig that it requires

### Fixed
* Fixed an issue with a change in Twig `3.12.0` (which is now used by Craft `5.4.0`) which would cause an exception to be thrown when rendering templates with an empty `{% block %}` tag ([#46](https://github.com/nystudio107/craft-templatecomments/issues/46))
* Fixed an issue with a change in Twig `3.12.0` (which is now used by Craft `5.4.0`) which would cause an exception to be thrown when rendering templates ([#44](https://github.com/nystudio107/craft-templatecomments/issues/44))

## 5.0.1 - 2024.08.06
### Fixed
* Fixed an issue where Template Comments would cause the Craft Closure `^1.0.6` package to not work

## 5.0.0 - 2024.04.18
### Added
* Stable release for Craft CMS 5
