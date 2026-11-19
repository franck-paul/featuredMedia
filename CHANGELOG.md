# Changelog

## 8.1 — 2026-11-07

- Add a // @phpcode-ignore on PHP comment line, not necessary in PHP output

## 8.0.1 — 2026-09-27

- Fix MP3 mime-type (see https://codeberg.org/Dotclear/dotclear/issues/176)
- Cope with RTL
- Enforces some verification before registering module

## 8.0 — 2026-08-03

- Avoid using magic methods for user preferences and blog settings (2.39+)
- Use MetaRecord::strField(), MetaRecord::intField() and MetaRecord::boolField() whenever is possible

## 7.5 — 2026-06-27

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 7.4 — 2026-04-21

- Add tpl:FeaturedMediaAlt and tpl:FeaturedMediaLegend template values, closes #9

## 7.3.1 — 2026-04-09

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 7.3 — 2026-04-08

- DA -&gt; DC

## 7.2 — 2025-09-22

- Use backend services rather than static calls

## 7.1 — 2025-09-12

- Replace static call to Ctx by context() — thanks JcDenis for advice

## 7.0 — 2025-09-07

- DC 2.36 compliance

## 6.0.3 — 2025-08-31

- Fix Hidden value type

## 6.0.2 — 2025-04-07

- Use context variable rather than global one in template code, fix #8

## 6.0.1 — 2025-04-04

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 6.0 — 2025-04-03

- Use TemplateHelper for template blocks/values DC 2.34+

## 5.2 — 2025-02-26

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 5.1 — 2025-02-08

- Use Helper/Html/Form rather than direct HTML code

## 5.0 — 2025-01-08

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 4.3 — 2024-09-04

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 4.2 — 2024-03-04

- Use SVG rather then PNG for icon

## 4.1.1 — 2024-01-07

- Do not use My::hiddenFields() on indirect action/form, fix #5

## 4.1 — 2023-10-27

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 4.0 — 2023-10-24

- 2.28 compliance

## 3.0 — 2023-08-25

- Dotclear 2.27 compliance, PHP 8.1+

## 2.1.1 — 2023-06-27

- Add local static $init variable

## 2.1 — 2023-06-15

- Add void Install.php

## 2.0.1 — 2023-06-01

- Fix type hint

## 2.0 — 2023-06-01

- Switch to namespace
- Update README
- Prepare 2.26

## 1.0 — 2023-04-05

- Add featured media filter for posts list, closes #2
- Minified version
- Group behaviors

## 0.6 — 2022-11-26

- Dotclear 2.24 compliance
- Avoid using globals variables if not necessary

## 0.5 — 2022-08-14

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 0.4.2 — 2022-05-22

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 0.4.1 — 2022-05-21

- Update default branch in _define.php for alternative repository
- Add alternative repository

## 0.4 — 2021-08-06

- Dotclear 2.19 compliance

## 0.3.1 — 2020-09-10

- Switch back from nowdoc to heredoc

## 0.3 — 2020-03-31

- No more inline JS
- Entrée devient publication
- Minor change, still compatible with 2.13 but may do strange things with FLV media

## 0.2 — 2020-02-14

- Add support URL - fix markdown doc for markup sample
- Prepare 0.2 release
- Provide the first featured media (image only) on socialMetaMedia behaviour
- No more flv (dc 2.15+)
- short notation for array (array() → [])

## 0.1 — 2016-02-11

- First draft, needs Dotclear 2.9
- Minimum for plugin
