# InSquare OpenDXP DeepL Bundle

Bundle for integrating OpenDXP with DeepL. It enables translating:
- `localizedfields` in objects
- translated documents (full document)
- individual areablock blocks (only when the block is overridden)

## Requirements
- PHP 8.3
- Symfony 7.4
- OpenDXP 1.3

## Installation (Composer)
1. Install the package:
```bash
composer require in-square/opendxp-deepl-bundle
```
2. If the bundle was not added automatically, register it in `config/bundles.php`:
```php
InSquare\OpendxpDeeplBundle\InSquareOpendxpDeeplBundle::class => ['all' => true],
```
3. Run `bin/console assets:install`.

## Configuration
Set the following Website Settings:
- `deepl_api_key` – DeepL API key
- `deepl_account_type` – `FREE` or `PRO`

Optional YAML configuration (e.g. `config/packages/in_square_opendxp_deepl.yaml`):
```yaml
in_square_opendxp_deepl:
  overwrite:
    documents: false
    objects: false
```

## License
GPL-3.0-or-later
