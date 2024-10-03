#### Laravel Repository and Service Class
##### Repository
A simplified method to have all Eloquent Queries isolated in other classes than Eloquent in order to prevent code duplication or easily add caching.

Without a classical Repository implementation, this is just a new layer class over Eloquent. 

##### Service
A different layer to put the bussiness logic in. Following the pattern:
request -> controller -> call service -> get data from repository -> apply some logic -> return -> response

#### Added Interfaces for Model

The repository will implement an interface for the model, so you can easily switch the model in the repository.

#### Installation
`composer require scriemcodat/repository`

In  `config/app.php` at 'providers' add:

`ScriemCodat\Repository\RepositoryServiceProvider::class,`

#### Usage

`php artisan make:repo {modelName}`

This creates a new repo in app/Repositories
Ex: `php artisan make:repo Product` will create `app/Repositories/ProductRepository.php`

in constructor of `ProductRepository.php` the model will be setup to use
`App\Models\Product` and `$this->model = $model` `$model` being the instance of Product.

`php artisan make:service {serviceName}`

This creates a new service in app/Services
ex: `php artisan make:repo ProductSearch` will create `app/Service/ProductSearchService.php`

`php artisan make:logic {modelName}`
This creates a new service in app/Services and a new repo in app/Repositories
Ex: `php artisan make:logic Product` will create `app/Repositories/ProductRepository.php` , `app/Services/ProductService.php` and `app/Interface/ProductInterface.php`

in the constructor of 'ProductSearchService.php` you can inject all the repositories you need
in order to perform the business logic you want.

`ProductSearchService` can be injected in methods of a controller, command or other service.





```php
use App\Service\ProductSearchService
```

```php
public function doSomeStuff($productSearchService ProductSearchService)
{
    $this->productSearchService = $productSearchService;
    $this->productSearchService->someMethodFromService($par1,$par2)
}
```


