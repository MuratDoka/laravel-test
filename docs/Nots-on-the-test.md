# Gold Coffee Sales Application Documentation

## Table of Contents
1. [Project Overview](#project-overview)
2. [Setup & Installation](#setup--installation)
3. [Configuration](#configuration)
4. [Database](#database)
   - [Migrations](#migrations)
   - [Seeders](#seeders)
   - [Factory](#factory)
5. [Models & Relationships](#models--relationships)
6. [Controllers](#controllers)
7. [Routes](#routes)
8. [Views](#views)
9. [Service Provider Enhancements](#service-provider-enhancements)
10. [Testing](#testing)
11. [Git Workflow](#git-workflow)
12. [LaTeX Source](#latex-source)

---

## Project Overview
This Laravel application provides a quick Gold-coffee selling price calculator and sales recording functionality. Customer service inputs the quantity of coffee bags and unit cost; the system calculates the total cost and selling price with a 25% profit margin plus a £10 shipping cost, then records the sale.

---

## Setup & Installation

1. **Clone the repo**
   ```bash
   git clone https://github.com/Cyber-Duck/laravel-test.git
   cd laravel-test
   ```

2. **PHP dependencies & env**
   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   ```

3. **SQLite database (optional)**
   ```bash
   touch database/database.sqlite
   ```

4. **Node & front-end assets**
   ```bash
   npm install && npm run dev
   ```

5. **(Optional) Use Laravel Sail**
   ```bash
   ./vendor/bin/sail up -d
   ```

6. **Database setup**
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Serve the app**
   ```bash
   php artisan serve
   ```

---

## Configuration
- **`config/coffee.php`**
  ```php
  return [
      'profit_margin' => 0.25,   // 25% profit
      'shipping_cost' => 10.00,  // £10 shipping
  ];
  ```

---

## Database

### Migrations
- **`create_sales_table`** migration creates the `sales` table with columns:
  - `id`, `user_id`, `quantity`, `unit_cost`, `cost`, `selling_price`, timestamps.

### Seeders
- **`DatabaseSeeder`** seeds:
  1. A **Sales Agent** user with email `sales@coffee.shop` and password `Password123`.
  2. Ten sample **Sale** records linked to the agent.

### Factory
- **`SaleFactory`** generates realistic dummy sales:
  - Random `quantity` (1–20) and `unit_cost` (2.00–15.00).
  - Computes `cost` and `selling_price` using the same formula as the controller.

---

## Models & Relationships

- **`User`** model:
  ```php
  public function sales()
  {
      return $this->hasMany(Sale::class);
  }
  ```

- **`Sale`** model:
  ```php
  protected $fillable = ['user_id','quantity','unit_cost','cost','selling_price'];

  public function user()
  {
      return $this->belongsTo(User::class);
  }
  ```

---

## Controllers

- **`SaleController`** (resource-style, but only `create` & `store` used):
  - `create()`: loads the sales form and previous sales for the authenticated user.
  - `store()`: validates input, calculates cost & selling price, saves a new `Sale`, then redisplays the form with results.

---

## Routes
Defined in **`routes/web.php`**, protected by `auth` & `verified` middleware:
```php
// All of these routes require authentication
Route::middleware(['auth','verified'])->group(function () {
    Route::redirect('/dashboard', '/sales')->name('coffee.sales');
    
    Route::resource('sales', SaleController::class)
         ->only(['index', 'store'])
         ->names([
             'index' => 'sales.index',
             'store' => 'sales.store',
         ]);
    Route::get('/shipping-partners', function () {
        return view('shipping_partners');
    })->name('shipping.partners');
});

require __DIR__.'/auth.php';
```

---

## Views

**`resources/views/sales/coffee-sales.blade.php`**:
- Responsive Tailwind form with inputs for **Quantity**, **Unit Cost**, and readonly **Selling Price**.
- "Record Sale" button.
- Table of previous sales, formatted with alternating row backgrounds.

---

## Service Provider Enhancements

**`App/Providers/AppServiceProvider`** registers a custom Blade directive `@money($amount)` to prefix and format currency values consistently across views.

---

## Testing

The **`SalesPageTest`** in **`tests/Feature`** verifies:
- Authenticated user can access the sales page.
- Previous sales seeded via factory appear in the view.
- The `sales.index` route is defined and returns status 200.

Run all tests with:
```bash
php artisan test
```
