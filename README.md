# ScriemCodat Repository Module Generator

## Description
This project includes a command-line tool that automates the creation of module directories and files, including services, repositories, interfaces, controllers, requests, models, and observers for Laravel applications.

## Features
- Generates necessary module structure for MVC components.
- Automatically creates folders and files for specified components.
- Implements repository and interface patterns.
- Automatically calls Laravel artisan commands to create factories and migrations.

## Installation

 ```bash
  composer require scriemcodat/repository
```

### Prerequisites
- PHP 8.0 or higher
- Composer
- Laravel Framework

## Usage

1. **Run the command to create a module**:
    ```bash
    php artisan create:module {name}
    ```
   Replace `{name}` with the name of the model (e.g., `Company`).

2. **Command will create the following structure**:
    - `app/Modules/Company/Controller`
    - `app/Modules/Company/Interface`
    - `app/Modules/Company/Request`
    - `app/Modules/Company/Model`
    - `app/Modules/Company/Observer`
    - `app/Modules/Company/Repository`
    - `app/Modules/Company/Service`


3. **Auto-created files**:
    - Repository Interfaces
    - Repository Implementations
    - Factories
    - Migrations
  
 ```php
public function doSomeStuff($productSearchService ProductSearchService)
{
$relationSearch = [
            'Facility' => [
                'relation' => [
                    'Company' => [
                        'fields' => ['name']
                    ],
                ],
                'fields' => ['name', 'fiscal_no', 'serial_no']
            ],
        ];

        $request->merge([
            'sortBy' => $this->sortBy ?? 'companies.id',
            'orderBy' => $this->sortDirection,
            'itemsPerPage' => config('app.itemsPerPage'),
            'page' => $this->getPage(),
            'status' => '1',
            'searchText' => $this->search,
            'searchIn' => ['name', 'fiscal_no', 'serial_no'],
            'relationSearch' => $relationSearch,

        ]);
    $this->amefsService->getAllFiltered($request);
}

## Running Tests
Tests are not yet defined in this project. Add your tests in the `tests` directory following Laravel's testing practices.

## Contributing
- Fork the repository.
- Create a new branch (`git checkout -b feature-branch`).
- Commit your changes (`git commit -m 'Add new feature'`).
- Push to the branch (`git push origin feature-branch`).
- Create a new Pull Request.

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
