<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'admin_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->enum('action', ['banned', 'unbanned', 'approved', 'declined', 'deactivated']);
            $table->foreignIdFor(User::class, 'user_affected_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(Project::class, 'project_affected_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('created_at')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_logs');
    }
};
