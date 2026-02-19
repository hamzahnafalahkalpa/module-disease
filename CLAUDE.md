# CLAUDE.md - Module Disease

This file provides guidance to Claude Code when working with the `hanafalah/module-disease` package.

## CRITICAL: Memory Safety

**This module uses `registers(['*'])` in its ServiceProvider**, which is now safe due to optimizations in `laravel-support` v2.0. However, be aware of the following:

### Safe Pattern (Current Implementation)

```php
// ModuleDiseaseServiceProvider.php
public function register()
{
    $this->registerMainClass(ModuleDisease::class)
        ->registerCommandService(Providers\CommandServiceProvider::class)
        ->registers(['*']);  // NOW SAFE - only registers safe methods
}
```

The `registers(['*'])` call now only registers SAFE methods: `Config, Model, Database, Migration, Route, Namespace, Provider`

### Dangerous Patterns to Avoid

**DO NOT explicitly register Schema classes:**
```php
// DANGEROUS - Can cause memory exhaustion
$this->registers(['Schema']);
$this->registers(['Schema', 'Services']);
```

**DO NOT call config() in class constructors:**
```php
// DANGEROUS - BaseModuleDisease calls setConfig() in constructor
// This is acceptable only because it doesn't trigger HasModelConfiguration
```

### Why This Module is Safe

1. `ModuleDisease.php` extends `PackageManagement` but doesn't call `config()` during loading
2. Schema classes (`Disease.php`, `ClassificationDisease.php`) are not auto-loaded via `registers(['*'])`
3. `BaseModuleDisease.php` only calls `setConfig()` with a static config name, not dynamic model resolution

## Module Overview

Module Disease is a Laravel package for managing disease and classification data in healthcare applications (klinik/puskesmas). It provides models, schemas, DTOs, and resources for handling disease records, including support for ICD (International Classification of Diseases) codes.

**Namespace:** `Hanafalah\ModuleDisease`

**Dependencies:**
- `hanafalah/laravel-support` (dev-main)

## Architecture Overview

```
module-disease/
├── src/
│   ├── Commands/                    # Artisan commands
│   │   ├── EnvironmentCommand.php   # Base command with migration config
│   │   └── InstallMakeCommand.php   # Installation command
│   ├── Contracts/                   # Interfaces
│   │   ├── Data/
│   │   │   ├── ClassificationDiseaseData.php
│   │   │   └── DiseaseData.php
│   │   ├── Schemas/
│   │   │   ├── ClassificationDisease.php  # Defines all auto-generated methods
│   │   │   └── Disease.php                # Defines all auto-generated methods
│   │   └── ModuleDisease.php
│   ├── Data/                        # DTOs (Spatie Laravel Data)
│   │   ├── ClassificationDiseaseData.php
│   │   └── DiseaseData.php
│   ├── Enums/
│   │   └── EnumDiseaseFlag.php      # ICD, MANUAL_DISEASE flags
│   ├── Models/
│   │   ├── ClassificationDisease.php    # Single Table Inheritance
│   │   └── Disease.php                  # Base model with ULID
│   ├── Providers/
│   │   └── CommandServiceProvider.php
│   ├── Resources/
│   │   └── Disease/
│   │       └── ViewDisease.php      # API resource
│   ├── Schemas/                     # Business logic layer (DANGEROUS TO AUTO-LOAD)
│   │   ├── ClassificationDisease.php
│   │   └── Disease.php
│   ├── Supports/
│   │   └── BaseModuleDisease.php    # Base class with config setup
│   ├── ModuleDisease.php            # Main package class
│   └── ModuleDiseaseServiceProvider.php
│
└── assets/
    ├── config/
    │   └── config.php               # Package configuration
    └── database/
        └── migrations/
            └── 0001_01_01_000012_create_diseases_table.php
```

## Key Classes

### ModuleDiseaseServiceProvider

The entry point for this package. Extends `BaseServiceProvider` from `laravel-support`.

| Method | Purpose | Risk Level |
|--------|---------|------------|
| `registerMainClass()` | Register main module class | Safe |
| `registerCommandService()` | Register command provider | Safe |
| `registers(['*'])` | Auto-register safe methods | Safe (v2.0+) |

### Models

**Disease** (`src/Models/Disease.php`)
- Base model for all disease records
- Uses ULID as primary key (`HasUlids` trait)
- Supports soft deletes (`SoftDeletes`)
- Has JSON properties (`HasProps` from `hanafalah/laravel-has-props`)
- Self-referential relationship via `parent_id`
- Belongs to `ClassificationDisease`
- Auto-sets `flag` from morph class on creating

**ClassificationDisease** (`src/Models/ClassificationDisease.php`)
- Extends `Disease` model
- Uses same `diseases` table (Single Table Inheritance pattern)
- Used for disease classification/grouping

### Schemas (Business Logic Layer)

**CAUTION:** Schema classes extend `PackageManagement` which uses `HasModelConfiguration` trait. Do NOT auto-load these via `registers(['Schema'])`.

**Disease Schema** (`src/Schemas/Disease.php`)
- Entity: `Disease`
- Method: `prepareStoreDisease(DiseaseData $dto)` - Create/update disease
- Auto-generated methods (via contract PHPDoc):
  - `viewDiseaseList()` - Get formatted list
  - `viewDiseasePaginate()` - Get paginated list
  - `showDisease()` - Get single disease
  - `deleteDisease()` - Delete disease
  - `storeDisease()` - Store with request data

**ClassificationDisease Schema** (`src/Schemas/ClassificationDisease.php`)
- Extends Disease schema
- Entity: `ClassificationDisease`
- Method: `prepareStoreClassificationDisease(ClassificationDiseaseData $dto)`
- Method: `classificationDisease(mixed $conditionals)` - Query builder
- Has caching: 24 hours for index queries
```php
protected array $__cache = [
    'index' => [
        'name'     => 'classification_disease',
        'tags'     => ['classification_disease', 'classification_disease-index'],
        'duration' => 24 * 60  // 24 hours
    ]
];
```

### Data Transfer Objects (DTOs)

**DiseaseData** (`src/Data/DiseaseData.php`)
```php
$id                       // mixed, nullable
$name                     // string, required
$flag                     // string, nullable (defaults to 'Disease')
$local_name               // string, nullable (defaults to '')
$code                     // string, nullable (defaults to '')
$version                  // string, nullable (defaults to '')
$classification_disease_id // string, nullable
$props                    // array, nullable
```

**ClassificationDiseaseData** - Extends DiseaseData (no additional fields)

### Enums

**EnumDiseaseFlag** (`src/Enums/EnumDiseaseFlag.php`)
```php
case ICD            = "ICD";           // International Classification of Diseases
case MANUAL_DISEASE = "MANUAL_DISEASE"; // Manually added diseases
```

### Database Schema

The `diseases` table structure:

| Column | Type | Constraints |
|--------|------|-------------|
| `id` | ULID | Primary key |
| `parent_id` | ULID | Self-referential FK, nullable, indexed |
| `name` | string | Required |
| `flag` | string | Required, auto-set from morph class |
| `local_name` | string | Nullable, default '' |
| `code` | varchar(10) | Nullable, default '' (for ICD codes) |
| `version` | string | Nullable (for ICD version tracking) |
| `classification_disease_id` | ULID | FK to diseases, nullable, indexed |
| `props` | JSON | Nullable |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |
| `deleted_at` | timestamp | Soft deletes |

**Indexes:**
- Full-text index on `name`, `local_name`, `code` (`ft_nm_cd`)
- Unique constraint on `name`, `code` (`disease_uq`)
- Index on `code` (`idx_code`)

## Configuration

Configuration file: `assets/config/config.php`

```php
return [
    'namespace' => 'Hanafalah\\ModuleDisease',
    'app' => [
        'contracts' => [
            // Add custom contract bindings here
        ]
    ],
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts',
        'schema' => 'Schemas',
        'database' => 'Database',
        'data' => 'Data',
        'resource' => 'Resources',
        'migration' => '../assets/database/migrations'
    ],
    'database' => [
        'models' => [
            // Override model classes here if needed
        ]
    ],
];
```

## Usage Examples

### Storing a Disease

```php
use Hanafalah\ModuleDisease\Contracts\Schemas\Disease;
use Hanafalah\ModuleDisease\Data\DiseaseData;

$diseaseSchema = app(Disease::class);
$dto = DiseaseData::from([
    'name' => 'Diabetes Mellitus Type 2',
    'code' => 'E11',
    'version' => 'ICD-10',
    'local_name' => 'Kencing Manis'
]);
$disease = $diseaseSchema->prepareStoreDisease($dto);
```

### Querying Classification Diseases

```php
use Hanafalah\ModuleDisease\Contracts\Schemas\ClassificationDisease;

$schema = app(ClassificationDisease::class);
$classifications = $schema->classificationDisease()
    ->where('version', 'ICD-10')
    ->get();
```

### Using API Resources

```php
use Hanafalah\ModuleDisease\Contracts\Schemas\Disease;

$schema = app(Disease::class);
$list = $schema->viewDiseaseList();          // Returns formatted array
$paginated = $schema->viewDiseasePaginate(); // Returns paginated array
$single = $schema->showDisease($model);      // Returns single disease array
```

### Using the Enum

```php
use Hanafalah\ModuleDisease\Enums\EnumDiseaseFlag;

// Check if disease is from ICD
if ($disease->flag === EnumDiseaseFlag::ICD->value) {
    // Handle ICD disease
}
```

## Artisan Commands

```bash
# Install module (publish migrations)
php artisan module-Service:install
```

**Note:** The command signature is `module-Service:install` (with capital S), which appears to be a naming inconsistency in the codebase.

## Integration with Wellmed

This module integrates with the Wellmed healthcare system to provide:
- ICD-10/ICD-11 disease code management
- Disease classification hierarchies (via `classification_disease_id`)
- Local disease name translations (via `local_name`)
- Medical record disease associations
- Hierarchical disease structures (via `parent_id`)

### Multi-Tenant Context

When used in multi-tenant context, ensure tenant isolation is properly handled per the main CLAUDE.md guidelines. The `diseases` table will exist in each tenant's database/schema.

## Safe Development Patterns

### Adding New Methods to Schemas

```php
// SAFE - Add method that uses lazy model resolution
public function findByCode(string $code): ?Model
{
    return $this->usingEntity()->where('code', $code)->first();
}
```

### Extending This Module

```php
// SAFE - Extend Schema without calling config() in constructor
class MyDiseaseSchema extends \Hanafalah\ModuleDisease\Schemas\Disease
{
    // Add custom methods here
    // DO NOT override __construct() with config() calls
}
```

### Overriding Models

Use `config/database.php` to override models:
```php
// In config/database.php
'models' => [
    'Disease' => \App\Models\CustomDisease::class,
]
```

## Common Issues

### Issue: Memory exhausted during boot

**Symptom:** `PHP Fatal error: Allowed memory size exhausted`

**Cause:** Manually calling `registers(['Schema'])` or loading Schema classes during boot

**Fix:** Let `registers(['*'])` handle registration - it excludes Schema by default

### Issue: Config not loaded

**Symptom:** `config('module-disease.key')` returns null

**Cause:** Config merge happens after class tries to access it

**Fix:** Use `app()->booted()` callback for config-dependent code

### Issue: Disease flag not set

**Symptom:** Disease records have null `flag` column

**Cause:** Creating disease without going through model's creating event

**Fix:** Always create via Eloquent model, not raw DB insert

## Modification Checklist

Before modifying this module:

- [ ] Change won't add `registers(['Schema'])` call
- [ ] No new trait uses that call `config()` during load
- [ ] No circular imports added
- [ ] Tested with `php artisan config:clear`
- [ ] Tested boot in wellmed-backbone container
- [ ] Memory stays under 512MB during boot
- [ ] Cache tags properly invalidated when data changes
