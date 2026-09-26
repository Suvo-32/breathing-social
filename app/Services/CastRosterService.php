<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CastRosterService
{
    /**
     * Get all available cast members / faces uploaded in public/cast/.
     *
     * @return array<int, array{id: string, name: string, image_url: string, file: string, exists: bool}>
     */
    public function getAvailableCast(): array
    {
        $castDir = public_path('cast');
        if (! File::isDirectory($castDir)) {
            File::makeDirectory($castDir, 0755, true);
        }

        $files = File::glob($castDir.'/*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}', GLOB_BRACE) ?: [];
        $castList = [];

        foreach ($files as $file) {
            $filename = basename($file);
            $cleanName = Str::headline(pathinfo($filename, PATHINFO_FILENAME));

            $castList[] = [
                'id' => Str::slug($cleanName),
                'name' => $cleanName,
                'image_url' => asset('cast/'.$filename),
                'file' => $filename,
                'exists' => true,
            ];
        }

        return $castList;
    }

    /**
     * Return actor visual persona descriptions for AI prompt conditioning.
     */
    public function getActorPromptEnhancement(string $actorName): string
    {
        $actorKey = strtolower(trim($actorName));

        // Curated persona hints for popular Bengali OTT franchises
        $knownActors = [
            'byomkesh' => 'Bengali gentleman detective, intellectual sharp jawline, iconic round thin-rimmed spectacles, neatly combed side-parted dark hair, crisp traditional Bengali kurta or dhuti with overcoat, observant piercing eyes, 1930s-1940s Kolkata aesthetic.',
            'anirban' => 'Distinguished Bengali actor Anirban Bhattacharya likeness, sharp intense gaze, structured jawline, expressive eyes, artistic Kolkata intellectual charm, subtle stubble or clean-shaven.',
            'feluda' => 'Tall athletic Bengali sleuth Feluda (Pradosh Mitter), charismatic sharp features, keen analytical eyes, confident slight smirk, classic safari jacket or solid cotton kurta, timeless 1970s-modern Bengali aesthetic.',
            'tota' => 'Tota Roy Chowdhury likeness, athletic build, high cheekbones, disciplined piercing eyes, sharp masculine features.',
            'mandaar' => 'Mandaar seaside noir antihero, rugged salt-and-pepper beard, weathered intense eyes, raw coastal crime drama intensity, loose sea-breeze linen shirt.',
            'indrani' => 'Elegant powerhouse Bengali actress, intense expressive dark eyes, sophisticated modern Bengali attire, authoritative and mysterious aura.',
        ];

        foreach ($knownActors as $key => $description) {
            if (str_contains($actorKey, $key)) {
                return " Lead Character visual likeness: {$description}.";
            }
        }

        return " Lead Character: {$actorName}, authentic facial structure, expressive dramatic OTT protagonist eyes, cinematic portrait lighting matching the actor.";
    }
}
