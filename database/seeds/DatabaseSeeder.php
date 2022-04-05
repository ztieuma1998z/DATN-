<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admins')->insert(['full_name' => 'Nguyễn Văn A', 'email' => 'datnt@gmail.com', 'password' => bcrypt('123456'), 'avatar' => '', 'phone' => '', 'status' => 1]);

        \DB::table('students')->insert([
            'full_name' => 'Nguyễn Văn S',
            'code' => 'T001',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'avatar' => '',
            'phone' => '0981432463',
            'address' => 'VN',
            'birth_date' => '1999-02-03',
            'gender' => 1,
            'status' => 1
        ]);

        \DB::table('teachers')->insert([
            'full_name' => 'Nguyễn Văn G',
            'code' => 'T001',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('1'),
            'avatar' => '',
            'phone' => '0981432453',
            'address' => 'VN',
            'specialized_id' => '1',
            'birth_date' => '1999-02-03',
            'gender' => 1,
            'status' => 1
        ]);

        \DB::table('settings')->insert([
            'favicon' => 'demo',
            'logo' => 'demo',
            'banner' => "demo",
            'banner_title' => 'demo',
            'banner_description' => 'demo',
            'banner_home' => 'demo',
            'banner_home_title' => 'demo',
            'banner_home_description' => 'demo',
            'phone' => '098143243',
            'email' => 'email',
            'address' => 'address',
            'copyright' => 'copyright',
            'link_fanpage' => 'link_fanpage'
        ]);

        \DB::table('about_page')->insert([
            'title' => 'demo',
            'image' => 'demo',
            'content' => "demo"
        ]);

        \App\Models\Weekday::getQuery()->delete();

        $stt = 1;

        for ($i=2; $i <= 8; $i++) {
            if ($i == 8) {
                \DB::table('weekdays')->insert([
                    'id' => $stt,
                    'name' => 'Chủ nhật'
                ]);
            }else{
                \DB::table('weekdays')->insert([
                    'id' => $stt,
                    'name' => "Thứ $i"
                ]);
            }
            $stt++;
        }

    }
}
