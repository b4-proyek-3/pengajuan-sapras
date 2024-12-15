<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class AddTriggerToPengajuan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE OR REPLACE FUNCTION update_pengajuan_status()
            RETURNS TRIGGER AS \$\$
            DECLARE
                current_status VARCHAR(50);
                next_reviewer INT;
                next_status VARCHAR(50);
                reviewer_role VARCHAR(50);
            BEGIN
                SELECT status INTO current_status FROM pengajuan WHERE id_pengajuan = NEW.id_pengajuan;
                
                IF current_status = 'diajukan' THEN
                    SELECT id_reviewer INTO next_reviewer FROM reviewers WHERE role = 'sekum-bem' LIMIT 1;

                    IF NEW.status = 'direvisi' OR NEW.status = 'ditolak' THEN
                        next_status := NEW.status;
                    ELSE
                        next_status := 'direview';
                    END IF;

                ELSIF NEW.status = 'diterima' THEN
                    -- Mendapatkan role reviewer yang sedang meng-review
                    SELECT role INTO reviewer_role FROM reviewers WHERE id_reviewer = NEW.id_reviewer;

                    IF reviewer_role = 'sekum-bem' THEN
                        -- Reviewer sekum-bem, lanjutkan ke reviewer KLI
                        SELECT id_reviewer INTO next_reviewer FROM reviewers WHERE role = 'kli' LIMIT 1;
                        next_status := 'direview';
                    ELSIF reviewer_role = 'kli' THEN
                        -- Reviewer KLI, lanjutkan ke reviewer WD-3
                        SELECT id_reviewer INTO next_reviewer FROM reviewers WHERE role = 'wd-3' LIMIT 1;
                        next_status := 'direview';
                    ELSE
                        -- Jika sudah selesai review, set status selesai
                        next_reviewer := NULL;
                        next_status := 'selesai';
                    END IF;

                ELSIF NEW.status = 'direvisi' THEN
                    next_reviewer := NEW.id_reviewer;
                    next_status := 'direvisi';

                ELSIF NEW.status = 'ditolak' THEN
                    next_reviewer := NULL;
                    next_status := 'ditolak';

                ELSE
                    next_reviewer := NULL;
                    next_status := 'unknown'; -- Pastikan status yang tidak terduga ditangani dengan benar
                END IF;

            -- Memperbarui status pengajuan jika perlu
            UPDATE pengajuan
            SET status = next_status, updated_at = CURRENT_TIMESTAMP
            WHERE id_pengajuan = NEW.id_pengajuan;

                RETURN NEW;
            END;
            \$\$ LANGUAGE plpgsql;

            CREATE TRIGGER update_status_pengajuan
            AFTER INSERT OR UPDATE ON reviews
            FOR EACH ROW
            EXECUTE FUNCTION update_pengajuan_status();
        ");

    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop trigger and function on rollback
        DB::unprepared('
            DROP TRIGGER IF EXISTS trigger_update_pengajuan_status ON pengajuan;
            DROP FUNCTION IF EXISTS update_pengajuan_status;
        ');
    }
}
