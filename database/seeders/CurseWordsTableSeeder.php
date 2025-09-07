<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurseWordsTableSeeder extends Seeder
{
    public function run()
    {
        $curseWords = [
            'damn',
            'hell',
            'crap',
            'bastard',
            'bitch',
            'asshole',
            'fool',
            'idiot',
            'stupid',
            'dumb',
            'jerk',
            'loser',
            'gago',
            'tanga',
            'bobo',
            'ulol',
            'tarantado',
            'bwisit',
            'hinayupak',
            'lintik',
            'putangina',
            'peste',
            'leche',
            'yawa',
            'buang',
            'bakakon',
            'samok',
            'yawyaw',
            'bahak',
            'tan-awon',
            'yabag',
            'limbong',
            'lapok'
        ];

        foreach ($curseWords as $word) {
            DB::table('curse_words')->insert([
                'word' => $word,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}