# deployer.crontab

![Packagist Version](https://img.shields.io/packagist/v/codenamephp/deployer.crontab)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/codenamephp/deployer.crontab)
![Lines of code](https://img.shields.io/tokei/lines/github/codenamephp/deployer.crontab)
![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/codenamephp/deployer.crontab)
![CI](https://github.com/codenamephp/deployer.crontab/workflows/CI/badge.svg)
![Packagist Downloads](https://img.shields.io/packagist/dt/codenamephp/deployer.crontab)
![GitHub](https://img.shields.io/github/license/codenamephp/deployer.crontab)

## Installation

Easiest way is via composer. Just run `composer require codenamephp/deployer.crontab` in your cli which should install the latest version for you.

## Usage

Just install the package and use the task in your deploy.php, e.g:

```php

$deployerFunctions = new \de\codenamephp\deployer\base\functions\All();
$deployerFunctions->registerTask(new \de\codenamephp\deployer\crontab\Task\Install()); //expects file in {{release_or_current_path}}/crontab -> crontab {{release_or_current_path}}/crontab
$deployerFunctions->registerTask(new \de\codenamephp\deployer\crontab\Task\Install('path/to/file')); // crontab path/to/file
$deployerFunctions->registerTask(new \de\codenamephp\deployer\crontab\Task\Install('path/to/file', 'deployerUser')); // crontab -u deployerUser path/to/file
$deployerFunctions->registerTask(new \de\codenamephp\deployer\crontab\Task\Show()); // crontab -l
$deployerFunctions->registerTask(new \de\codenamephp\deployer\crontab\Task\Show('deployerUser')); // crontab -u deployerUser -l
$deployerFunctions->registerTask(new \de\codenamephp\deployer\crontab\Task\Delete()); // crontab -r
$deployerFunctions->registerTask(new \de\codenamephp\deployer\crontab\Task\Delete('deployerUser')); // crontab -u deployerUser -r
```
`vendor/bin/dep crontab:install`
`vendor/bin/dep crontab:show`
`vendor/bin/dep crontab:delete`