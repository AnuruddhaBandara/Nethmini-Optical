<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class insert_districts extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('districts')->insert([
            ['id' => 1, 'province_id' => 6, 'name_en' => 'Ampara', 'name_si' => 'අම්පාර', 'name_ta' => 'அம்பாறை'],
            ['id' => 2, 'province_id' => 8, 'name_en' => 'Anuradhapura', 'name_si' => 'අනුරාධපුරය', 'name_ta' => 'அனுராதபுரம்'],
            ['id' => 3, 'province_id' => 7, 'name_en' => 'Badulla', 'name_si' => 'බදුල්ල', 'name_ta' => 'பதுளை'],
            ['id' => 4, 'province_id' => 6, 'name_en' => 'Batticaloa', 'name_si' => 'මඩකලපුව', 'name_ta' => 'மட்டக்களப்பு'],
            ['id' => 5, 'province_id' => 1, 'name_en' => 'Colombo', 'name_si' => 'කොළඹ', 'name_ta' => 'கொழும்பு'],
            ['id' => 6, 'province_id' => 3, 'name_en' => 'Galle', 'name_si' => 'ගාල්ල', 'name_ta' => 'காலி'],
            ['id' => 7, 'province_id' => 1, 'name_en' => 'Gampaha', 'name_si' => 'ගම්පහ', 'name_ta' => 'கம்பஹா'],
            ['id' => 8, 'province_id' => 3, 'name_en' => 'Hambantota', 'name_si' => 'හම්බන්තොට', 'name_ta' => 'அம்பாந்தோட்டை'],
            ['id' => 9, 'province_id' => 9, 'name_en' => 'Jaffna', 'name_si' => 'යාපනය', 'name_ta' => 'யாழ்ப்பாணம்'],
            ['id' => 10, 'province_id' => 1, 'name_en' => 'Kalutara', 'name_si' => 'කළුතර', 'name_ta' => 'களுத்துறை'],
            ['id' => 11, 'province_id' => 2, 'name_en' => 'Kandy', 'name_si' => 'මහනුවර', 'name_ta' => 'கண்டி'],
            ['id' => 12, 'province_id' => 5, 'name_en' => 'Kegalle', 'name_si' => 'කෑගල්ල', 'name_ta' => 'கேகாலை'],
            ['id' => 13, 'province_id' => 9, 'name_en' => 'Kilinochchi', 'name_si' => 'කිලිනොච්චිය', 'name_ta' => 'கிளிநொச்சி'],
            ['id' => 14, 'province_id' => 4, 'name_en' => 'Kurunegala', 'name_si' => 'කුරුණෑගල', 'name_ta' => 'குருணாகல்'],
            ['id' => 15, 'province_id' => 9, 'name_en' => 'Mannar', 'name_si' => 'මන්නාරම', 'name_ta' => 'மன்னார்'],
            ['id' => 16, 'province_id' => 2, 'name_en' => 'Matale', 'name_si' => 'මාතලේ',  'name_ta' => 'மாத்தளை'],
            ['id' => 17, 'province_id' => 3, 'name_en' => 'Matara', 'name_si' => 'මාතර', 'name_ta' => 'மாத்தறை'],
            ['id' => 18, 'province_id' => 7, 'name_en' => 'Monaragala', 'name_si' => 'මොණරාගල', 'name_ta' => 'மொணராகலை'],
            ['id' => 19, 'province_id' => 9, 'name_en' => 'Mullaitivu', 'name_si' => 'මුලතිව්',  'name_ta' => 'முல்லைத்தீவு'],
            ['id' => 20, 'province_id' => 2, 'name_en' => 'Nuwara Eliya', 'name_si' => 'නුවර එළිය', 'name_ta' => 'நுவரேலியா'],
            ['id' => 21, 'province_id' => 8, 'name_en' => 'Polonnaruwa', 'name_si' => 'පොළොන්නරුව', 'name_ta' => 'பொலன்னறுவை'],
            ['id' => 22, 'province_id' => 4, 'name_en' => 'Puttalam', 'name_si' => 'පුත්තලම', 'name_ta' => 'புத்தளம்'],
            ['id' => 23, 'province_id' => 5, 'name_en' => 'Ratnapura', 'name_si' => 'රත්නපුර', 'name_ta' => 'இரத்தினபுரி'],
            ['id' => 24, 'province_id' => 6, 'name_en' => 'Trincomalee', 'name_si' => 'ත්‍රිකුණාමලය', 'name_ta' => 'திருகோணமலை'],
            ['id' => 25, 'province_id' => 9, 'name_en' => 'Vavuniya', 'name_si' => 'වව්නියාව', 'name_ta' => 'வவுனியா'],
        ]);
    }
}
