<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAdminTable extends Migration
{
    /**
     * Initialize data in the table.
     *
     * @return void
     */
    private function initialize()
    {
        if (file_exists ( $_ENV["BACKUP_PATH"]."admin.csv" )) {

            /**
             * Read data from the backup file and add into database
             */
            $fp = fopen($_ENV["BACKUP_PATH"]."admin.csv", 'r');
            
            // Read the first row
            fgetcsv($fp);

            // Read rows until null
            while (($line = fgetcsv($fp)) !== false)
            {
                $name = $line[0];
                $email = $line[1];    
                DB::table('admin')->insert(
                    ['name' => $name, 'email' => $email]
                );
            }

            // Close file
            fclose($fp);

            return;
        }

        // Insert the primary admin if backup file does not exist
        DB::table('admin')->insert([
            'email' => $_ENV["ADMIN_PRIMARY_EMAIL"], 
            'name' => $_ENV["ADMIN_PRIMARY_NAME"]    
        ]);
    }

    /**
     * Backup data in the table.
     *
     * @return void
     */
    private function backup()
    {
        /** 
         * Save data sets into a csv file
         */        
        $filename = $_ENV["BACKUP_PATH"]."admin.csv";
        $data = DB::table('admin')->get();
        
        // Erase existing file
        $output = fopen($filename, 'w+');
        // Set up the first row
        fputcsv($output, array(
            'name', 
            'email'
        ));
        // Add all rows
        foreach ($data as $info) {
            fputcsv($output, array(
                $info['name'],
                $info['email']
            ));
        }

        // Close file
        fclose($output);
    
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->string('name'); // Name of the admin
            $table->string('email')->unique()->primary(); // Primary Key: email of the admin

            // Add for future extension
            $table->timestamps();
        });

        self::initialize();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        self::backup();

        Schema::dropIfExists('admin');
    }
}
