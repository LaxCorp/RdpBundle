INN + KPP validation for ORM Entity
=======================================================

Install 
-------
composer require laxcorp/rdp-bundle

Config
------
rdp:
    full_address: 'rdp.server'

Add in app/AppKernel.php
------------------------
```php
$bundles = [
    new LaxCorp\RdpBundle\RdpBundle()
]
```

Usage in controller for single file
------------------------
use LaxCorp\RdpBundle\Helper\RdpHelper;

....

```php
$responce = $this->get(RdpHelper::class)
                ->getDefault()
                ->setUserName('user1')
                ->responceFile('userfile');
```

Usage in controller for collection to zip
------------------------
use LaxCorp\RdpBundle\Helper\RdpHelper;

....

```php
$logins = ['user1', 'user2'];

$rdpHelper = $this->get(RdpHelper::class);
$rdp = $rdpHelper->getDefault();

foreach ($logins as $login){
    $rdp->add($rdpHelper->getDefault()->setUserName($login));
}

return $rdp->responceZip('all_rdp');
```
                