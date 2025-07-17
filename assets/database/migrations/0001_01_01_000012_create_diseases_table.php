<?php

use Hanafalah\ModuleDisease\Models\Disease;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use Hanafalah\LaravelSupport\Concerns\NowYouSeeMe;

    private $__table;

    public function __construct()
    {
        $this->__table = app(config('database.models.Disease', Disease::class));
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $table_name = $this->__table->getTable();
        if (!$this->isTableExists()) {
            Schema::create($table_name, function (Blueprint $table) {
                $table->ulid('id')->primary();
                $table->string('name')->nullable(false);
                $table->string('local_name')->nullable(false)->default('');
                $table->string('code', 10)->nullable(false)->default('')->comment('need empty string for unique case');
                $table->string('version')->nullable(true);
                $table->foreignIdFor($this->__table::class, 'classification_disease_id')
                    ->nullable()->index()->constrained($this->__table->getTable(), $this->__table->getKeyName())
                    ->cascadeOnUpdate()->restrictOnDelete();
                $table->json('props')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->fullText(['name', 'local_name', 'code'], 'ft_nm_cd');
                $table->unique(['name', 'code'], 'disease_uq');
                $table->index('code', 'idx_code');
            });

            Schema::table($table_name, function (Blueprint $table) {
                $table->foreignIdFor($this->__table::class, 'parent_id')
                    ->after('id')
                    ->nullable()->index()->constrained()
                    ->cascadeOnUpdate()->restrictOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->__table->getTable());
    }
};
