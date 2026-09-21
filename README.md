# Contao OpenGraph3

[![Packagist Version](https://img.shields.io/packagist/v/numero2/contao-opengraph3.svg?style=flat-square)](https://packagist.org/packages/numero2/contao-opengraph3)
[![License: LGPL v3](https://img.shields.io/badge/License-LGPL%20v3-blue.svg?style=flat-square)](http://www.gnu.org/licenses/lgpl-3.0)

Implementation of OpenGraph tags and X / Twitter Cards for Contao. [Read more](https://www.numero2.de/contao/erweiterungen/opengraph3.html)

---

## Requirements

- [Contao 5.7](https://github.com/contao/contao) (or newer)

> For Contao 4.13 use version 4.x of this bundle.

---

## Installation

Via **Contao Manager** or **Composer**:

```bash
composer require numero2/contao-opengraph3
```

Afterwards run a database update via the Contao Manager or the [contao:migrate](https://docs.contao.org/dev/reference/commands/) command.

---

## Compatible bundles

By default the OpenGraph fields are attached to the site structure. The values of a page are used as fallback for all of its subpages, the values of the website root as fallback for the whole website.

Furthermore the fields are available for the following bundles. If a reader module of one of these bundles is placed on a page, the data of the displayed record takes precedence over the data of the page:

| Bundle                                                          | Reader module          |
|-----------------------------------------------------------------|------------------------|
| [news](https://github.com/contao/news-bundle)                   | `newsreader`           |
| [calendar](https://github.com/contao/calendar-bundle)           | `eventreader`          |
| [faq](https://github.com/contao/faq-bundle)                     | `faqreader`            |
| [isotope](https://github.com/isotope/core)                      | `iso_productreader`    |
| [storelocator](https://github.com/numero2/contao-storelocator)  | `storelocator_details` |

The tags are added to the `HtmlHeadBag` and work with legacy as well as modern page layouts. Tags that have already been added by a template or another extension will not be overwritten.

---

## Developer API

### Adding support for your own reader module

Implement `numero2\Opengraph3Bundle\OpenGraph\Provider\ProviderInterface` and register the class as a service with autoconfiguration enabled:

```php
// src/OpenGraph/MyProvider.php
namespace App\OpenGraph;

use App\Model\MyModel;
use Contao\Input;
use Contao\ModuleModel;
use numero2\Opengraph3Bundle\OpenGraph\OpenGraphReference;
use numero2\Opengraph3Bundle\OpenGraph\Provider\ProviderInterface;

class MyProvider implements ProviderInterface
{
    public function supports(ModuleModel $model): bool
    {
        return $model->type === 'my_reader';
    }

    public function getReference(ModuleModel $model): ?OpenGraphReference
    {
        if (!$record = MyModel::findByIdOrAlias(Input::get('auto_item'))) {
            return null;
        }

        // the default values are used for fields that are empty in the record
        return new OpenGraphReference($record, [
            'og_type' => 'article',
            'og_article_published_time' => $record->date,
        ]);
    }
}
```

To add the OpenGraph fields to your own table, call the following in your DCA file:

```php
// contao/dca/tl_my_table.php
use numero2\Opengraph3Bundle\DataContainer\OpenGraphFields;

// add the legends before the "expert_legend" of the default palette and only allow the type "article"
OpenGraphFields::addToTable('tl_my_table', ['default' => 'expert_legend'], ['article']);
```

### Using a record from your own controller

The `numero2\Opengraph3Bundle\OpenGraph\OpenGraphManager` service can be injected to set the record providing the OpenGraph data directly:

```php
$this->openGraphManager->setReference(new OpenGraphReference($record, ['og_type' => 'article']));
```
