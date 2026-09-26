<?php

namespace Database\Factories;

use App\Models\GeneratedImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GeneratedImage>
 */
class GeneratedImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bengaliPrompts = [
            'একটি সুন্দর সূর্যাস্তে নদীর বুকে পালতোলা নৌকা চালিয়ে যাচ্ছে এক মাঝি, লাল-কমলা আকাশ',
            'সবুজ গ্রাম্য মেঠোপথ, দুপাশে কাশফুল এবং দূর দিগন্তে বর্ষার মেঘ',
            'বৃষ্টিস্নাত কলকাতার ট্রাম রাস্তা, হলুদ ট্যাক্সি ও সন্ধ্যার নিয়ন আলোর প্রতিফলন',
            'সাইবারপাঙ্ক ঢাকা ২০৮০: আকাশচুম্বী নিয়ন টাওয়ার, উড়ন্ত রিকশা এবং বৃষ্টিভেজা রাস্তা',
            'পহেলা বৈশাখের রঙিন মেলা, মঙ্গল শোভাযাত্রা, মুখোশ ও ঐতিহ্যবাহী ঢাক-ঢোল',
            'সুন্দরবনের ম্যানগ্রোভ বনের ভেতর রয়েল বেঙ্গল টাইগার, সকালের স্নিগ্ধ রোদের আলো',
            'ঐতিহাসিক লালবাগ কেল্লার প্রাঙ্গণে গোধূলিলগ্নে ফোয়ারা ও বাগান',
        ];

        return [
            'prompt' => fake()->randomElement($bengaliPrompts),
            'enhanced_prompt' => null,
            'aspect_ratio' => fake()->randomElement(['1:1', '16:9', '9:16', '4:3']),
            'model' => 'gemini-2.5-flash-image',
            'image_path' => 'generated-images/sample-'.fake()->uuid().'.png',
            'mime_type' => 'image/png',
            'file_size' => fake()->numberBetween(150000, 950000),
            'is_favorite' => fake()->boolean(20),
            'metadata' => [
                'language' => 'bn',
                'sample' => true,
            ],
        ];
    }
}
