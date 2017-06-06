Contao OpenGraph3
=======================

About
--
Implementation of OpenGraph tags and Twitter Cards for Contao 4.

System requirements
--

* [Contao 4](https://github.com/contao/core)


Installation
--

* Create a folder named `opengraph3` in `system/modules`
* Clone this repository into the new folder
* Open `app/AppKernel.php` and add the following line to the $bundles array
  ```php
  new Contao\CoreBundle\HttpKernel\Bundle\ContaoModuleBundle('opengraph3', $this->getRootDir())
  ```
* Run a database update via the Installtool

