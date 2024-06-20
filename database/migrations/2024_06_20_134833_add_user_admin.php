<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::insert('insert into users (id,name, email, password, roles) values (?, ?, ?, ?, ?)', [1, 'admin', 'admin@admin.com', '$2y$12$cdMNeaoeRS1LBxFU5ScyHu9kpKtG5T038zIspG26KRFnXrdxZ9yIe', 'ROLE_ADMIN']);
        DB::insert('insert into users (id,name, email, password, roles) values (?, ?, ?, ?, ?)', [2, 'user', 'user@user.com', '$2y$12$2fY8m8MDBKMJD453tq2yR.N2bDCBgNouN96QGfImJViLiVY1FmaiG', 'ROLE_USER']);
        
        DB::insert('insert into citoyens (nom, user_id) values (?, ?)', ['Admin', 1]);
        DB::insert('insert into citoyens (nom, user_id) values (?, ?)', ['User', 2]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::delete('delete from users where name = ?', ['user']);
        DB::delete('delete from users where name = ?', ['admin']);
        
        DB::delete('delete from citoyens where user_id = ?', [1]);
        DB::delete('delete from citoyens where user_id = ?', [2]);
    }
};
