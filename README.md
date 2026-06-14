 # Laravel CRUD — Customer Module (Practice Notes)
> Nehal's scratch-built CRUD 

 

## Project Setup

bash
composer create-project laravel/laravel revision
cd revision
php artisan serve

php artisan storage:link  # symlink for file uploads


---

## Folder Structure (Important Files)

```
app/
├── Http/
│   └── Controllers/
│       └── CustomerController.php
├── Models/
│   └── Customer.php
database/
└── migrations/
    └── xxxx_create_customers_table.php
resources/
└── views/
    └── customers/
        ├── index.blade.php
        ├── create.blade.php
        └── edit.blade.php
routes/
└── web.php
storage/
└── app/public/profile/   ← actual files yahan hain
public/
└── storage/              ← symlink (shortcut) — browser yahan se access karta hai
```

---

## Migration

```php
Schema::create('customers', function (Blueprint $table) {
    $table->id();
    $table->string('name', 255);
    $table->string('gender', 20);
    $table->json('payment');        // array store hoga — ["Cash","Online"]
    $table->string('country', 100);
    $table->string('profile', 255); // sirf filename/path store hoga
    $table->timestamps();
});
```

### Key Learnings
- `string()` → VARCHAR — short text (naam, email, country)
- `text()` → TEXT — long content (bio, description, paragraphs)
- `json()` → JSON column — array/object store karne ke liye
- `unique()` → sirf wahan lagao jahan value genuinely unique ho (email, username) — gender pe mat lagao
- `migrate:fresh` → sab tables drop karke dobara banata hai (development mein use karo)
- `migrate:rollback` → last migration undo karta hai

---

## Model

```php
class Customer extends Model
{
    // Mass assignment ke liye allowed columns
    protected $fillable = [
        'name', 'gender', 'payment', 'country', 'profile'
    ];

    // payment JSON → PHP array auto convert
    protected $casts = [
        'payment' => 'array'
    ];
}
```

### Key Learnings
- `$fillable` → `create()` / `update()` se sirf ye columns pass honge — security ke liye
- Bina `$fillable` ke `create()` call karo → `MassAssignmentException` error
- `$casts` → database se fetch karte waqt auto type conversion
- `$guarded = []` → sab columns allow karo (opposite of fillable)
- `save()` vs `create()`:
  - `create([...])` → ek line mein insert — fillable zaruri
  - `new Model() + save()` → manually assign karo — fillable zaruri nahi

---

## Routes (Manual — No Route::resource)

```php
Route::get('/customers',              [CustomerController::class, 'index'])  ->name('customers.index');
Route::get('/customers/create',       [CustomerController::class, 'create']) ->name('customers.create');
Route::post('/customers',             [CustomerController::class, 'store'])  ->name('customers.store');
Route::get('/customers/{customer}',   [CustomerController::class, 'show'])   ->name('customers.show');
Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
Route::put('/customers/{customer}',   [CustomerController::class, 'update']) ->name('customers.update');
Route::delete('/customers/{customer}',[CustomerController::class, 'destroy'])->name('customers.destroy');
```

### Key Learnings
- `/` sirf homepage ke liye — resource ka URL descriptive hona chahiye `/customers`
- Route NAME aur URL alag hote hain:
  - URL → browser mein daalo: `127.0.0.1:8000/customers`
  - Name → blade mein use karo: `route('customers.index')`
- `->name()` use karo — URL change hone pe blade files nahi todna padega
- Debug tip: `php artisan route:list` → saare registered routes dekho
- 404 aaye → pehle route:list check karo

---

## Controller

```php
// INDEX — list
public function index()
{
    $customer_data = Customer::latest()->get();
    return view('customers.index', compact('customer_data'));
}

// CREATE — form show karo
public function create()
{
    return view('customers.create');
}

// STORE — form data save karo
public function store(Request $request)
{
    $request->validate([
        'name'    => 'required|string|min:3|max:255',
        'gender'  => 'required|string|max:10',
        'payment' => 'required|array',
        'country' => 'required|string|min:3|max:100',
        'image'   => 'required|file|image|max:2048',
    ]);

    $path = $request->file('image')->store('profile', 'public');

    Customer::create([
        'name'    => $request->name,
        'gender'  => $request->gender,
        'payment' => $request->payment,   // $casts handle karega array→json
        'country' => $request->country,
        'profile' => $path,
    ]);

    return redirect()->route('customers.index')->with('success', 'Customer created!');
}

// EDIT — form with existing data
public function edit(Customer $customer)
{
    return view('customers.edit', compact('customer'));
    // Laravel Route Model Binding — ID se auto fetch karta hai
}

// UPDATE — data update karo
public function update(Request $request, Customer $customer)
{
    $request->validate([
        'name'    => 'required|string|min:3|max:255',
        'gender'  => 'required|string',
        'payment' => 'required|array',
        'country' => 'required|string',
        'image'   => 'nullable|file|image|max:2048',  // nullable — optional
    ]);

    $data = [
        'name'    => $request->name,
        'gender'  => $request->gender,
        'payment' => $request->payment,
        'country' => $request->country,
    ];

    if ($request->hasFile('image')) {
        Storage::disk('public')->delete($customer->profile); // purani delete
        $data['profile'] = $request->file('image')->store('profile', 'public');
    }

    $customer->update($data);

    return redirect()->route('customers.index')->with('success', 'Customer updated!');
}

// DESTROY — delete karo
public function destroy(Customer $customer)
{
    Storage::disk('public')->delete($customer->profile);
    $customer->delete();
    return redirect()->route('customers.index')->with('success', 'Customer deleted!');
}
```

### Key Learnings
- Validation pehle, file upload baad mein
- `$request->file()` → uploaded file object
- `->store('folder', 'disk')` → file save karo, unique naam auto generate hota hai
- `$request->hasFile()` → check karo file aayi ya nahi — null crash se bachao
- `Storage::disk('public')->delete()` → purani file delete karo update pe
- Route Model Binding → `Customer $customer` — Laravel ID se auto fetch karta hai
- `update([...])` vs `save()`:
  - `$customer->update([...])` → ek line, clean
  - `$customer->name = '...'; $customer->save();` → verbose

---

## Blade Tips

```blade
{{-- Success message --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Image display --}}
<img src="{{ asset('storage/' . $customer->profile) }}" width="50">

{{-- Payment array display --}}
@foreach($customer->payment as $p)
    <span class="badge badge-info">{{ $p }}</span>
@endforeach

{{-- Radio checked --}}
<input type="radio" name="gender" value="Male"
    {{ $customer->gender == 'Male' ? 'checked' : '' }}>

{{-- Checkbox checked --}}
<input type="checkbox" name="payment[]" value="Cash"
    {{ in_array('Cash', $customer->payment) ? 'checked' : '' }}>

{{-- Select selected --}}
<option value="India" {{ $customer->country == 'India' ? 'selected' : '' }}>India</option>

{{-- Delete form --}}
<form method="POST" action="{{ route('customers.destroy', $customer->id) }}">
    @csrf
    @method('DELETE')
    <button type="submit">Delete</button>
</form>

{{-- Edit form --}}
<form method="POST" action="{{ route('customers.update', $customer->id) }}"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
</form>
```

### Key Learnings
- `asset('storage/...')` → public URL banata hai browser ke liye
- `storage:link` → `public/storage` ko `storage/app/public` se connect karta hai
- File input mein `value` nahi hota — current image alag `<img>` tag se show karo
- DELETE/PUT routes ke liye `@method()` directive zaruri hai — HTML forms sirf GET/POST support karte hain
- `@csrf` har POST/PUT/DELETE form mein mandatory hai

---

## Storage — Important Concept

```
Actual file:    storage/app/public/profile/photo.jpg
Symlink:        public/storage/ → shortcut to storage/app/public/
Browser URL:    yourdomain.com/storage/profile/photo.jpg

Browser directly storage/ folder access nahi kar sakta — security reason
Sirf public/ folder web server expose karta hai
storage:link sirf public/storage ka shortcut banata hai
```

---

## Common Mistakes Log

| Mistake | Galat | Sahi |
|---|---|---|
| Route method | `->route('name')` | `->name('name')` |
| fillable | method banaya | protected property hai |
| File upload | `create()` ke andar | pehle store, phir create |
| Update method | `Customer::update()` | `$customer->update()` |
| Delete route | GET request | POST + @method('DELETE') |
| Payment display | direct echo | loop ya implode |
| File nullable | required in update | nullable in update |
| storage:link | skip kiya | zaruri hai — warna image nahi dikhi |

---

## Artisan Commands Cheatsheet

```bash
php artisan serve                  # server start
php artisan make:model Customer -mc # model + migration + controller
php artisan migrate                # new migrations run karo
php artisan migrate:fresh          # sab drop, fresh start
php artisan migrate:rollback       # last migration undo
php artisan route:list             # saare routes dekho — 404 debug
php artisan storage:link           # public/storage symlink banao
php artisan cache:clear            # cache clear
```

---

*Built from scratch — blank file, no copy paste, no tutorial*
*Every mistake logged = real learning*
