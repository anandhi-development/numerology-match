<?php

namespace App\Services;

class NumerologyService
{
    /**
     * Standard Pythagorean letter value map (A-Z).
     */
    private const LETTER_VALUES = [
        'A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5, 'F' => 6, 'G' => 7, 'H' => 8, 'I' => 9,
        'J' => 1, 'K' => 2, 'L' => 3, 'M' => 4, 'N' => 5, 'O' => 6, 'P' => 7, 'Q' => 8, 'R' => 9,
        'S' => 1, 'T' => 2, 'U' => 3, 'V' => 4, 'W' => 5, 'X' => 6, 'Y' => 7, 'Z' => 8,
    ];

    private const VOWELS = ['A', 'E', 'I', 'O', 'U'];

    /**
     * Vibration groups for numerological compatibility:
     * - Creative/Physical: 1, 5, 7
     * - Practical/Business: 2, 4, 8
     * - Mind/Intuitive: 3, 6, 9
     */
    private const GROUPS = [
        1 => 'creative', 5 => 'creative', 7 => 'creative',
        2 => 'business', 4 => 'business', 8 => 'business',
        3 => 'mind',     6 => 'mind',     9 => 'mind',
    ];

    /**
     * Calculate Life Path Number from Date of Birth (Y-m-d).
     * Sum of day, month, and year digits reduced to a single digit (or master numbers 11, 22, 33).
     */
    public function calculateLifePath(string $dob): int
    {
        $digits = preg_replace('/\D/', '', $dob);
        if (empty($digits)) {
            return 1;
        }

        $sum = array_sum(str_split($digits));
        return $this->reduceNumber($sum);
    }

    /**
     * Calculate Destiny / Expression Number from full name.
     */
    public function calculateDestiny(string $fullName): int
    {
        $letters = $this->extractLetters($fullName);
        if (empty($letters)) {
            return 1;
        }

        $sum = 0;
        foreach ($letters as $char) {
            $sum += self::LETTER_VALUES[$char] ?? 0;
        }

        return $this->reduceNumber($sum);
    }

    /**
     * Calculate Soul Urge / Heart's Desire Number (sum of vowels).
     */
    public function calculateSoul(string $fullName): int
    {
        $letters = $this->extractLetters($fullName);
        $sum = 0;
        $found = false;

        foreach ($letters as $char) {
            if (in_array($char, self::VOWELS, true)) {
                $sum += self::LETTER_VALUES[$char] ?? 0;
                $found = true;
            }
        }

        return $found ? $this->reduceNumber($sum) : 1;
    }

    /**
     * Calculate Personality Number (sum of consonants).
     */
    public function calculatePersonality(string $fullName): int
    {
        $letters = $this->extractLetters($fullName);
        $sum = 0;
        $found = false;

        foreach ($letters as $char) {
            if (!in_array($char, self::VOWELS, true)) {
                $sum += self::LETTER_VALUES[$char] ?? 0;
                $found = true;
            }
        }

        return $found ? $this->reduceNumber($sum) : 1;
    }

    /**
     * Calculate full numerology profile for a person.
     */
    public function calculateProfile(string $firstName, ?string $lastName, string $dob): array
    {
        $fullName = trim($firstName . ' ' . ($lastName ?? ''));

        return [
            'first_name' => trim($firstName),
            'last_name' => trim($lastName ?? ''),
            'full_name' => $fullName,
            'dob' => $dob,
            'life_path' => $this->calculateLifePath($dob),
            'destiny' => $this->calculateDestiny($fullName),
            'soul' => $this->calculateSoul($fullName),
            'personality' => $this->calculatePersonality($fullName),
        ];
    }

    /**
     * Compare two profiles and generate compatibility metrics.
     */
    public function compareProfiles(array $person1, array $person2): array
    {
        $p1 = $this->calculateProfile($person1['first_name'], $person1['last_name'] ?? '', $person1['dob']);
        $p2 = $this->calculateProfile($person2['first_name'], $person2['last_name'] ?? '', $person2['dob']);

        // Individual category compatibility scores (0 - 100)
        $scoreLifePath = $this->calculatePairScore($p1['life_path'], $p2['life_path']);
        $scoreDestiny = $this->calculatePairScore($p1['destiny'], $p2['destiny']);
        $scoreSoul = $this->calculatePairScore($p1['soul'], $p2['soul']);
        $scorePersonality = $this->calculatePairScore($p1['personality'], $p2['personality']);

        // Weighted overall score:
        // Life Path (40%), Destiny (25%), Soul Urge (20%), Personality (15%)
        $overallScore = (int) round(
            ($scoreLifePath * 0.40) +
            ($scoreDestiny * 0.25) +
            ($scoreSoul * 0.20) +
            ($scorePersonality * 0.15)
        );

        // Cap within realistic pleasing bounds (minimum 45%, maximum 98%)
        $overallScore = max(45, min(98, $overallScore));

        [$summaryEn, $summaryTa] = $this->generateSummaries($overallScore, $p1, $p2);

        return [
            'person1' => $p1,
            'person2' => $p2,
            'scores' => [
                'life_path' => $scoreLifePath,
                'destiny' => $scoreDestiny,
                'soul' => $scoreSoul,
                'personality' => $scorePersonality,
                'overall' => $overallScore,
            ],
            'compatibility_score' => $overallScore,
            'summary_en' => $summaryEn,
            'summary_ta' => $summaryTa,
        ];
    }

    /**
     * Score compatibility between two root numbers (0 - 100).
     */
    public function calculatePairScore(int $num1, int $num2): int
    {
        $r1 = $this->toRoot($num1);
        $r2 = $this->toRoot($num2);

        if ($r1 === $r2) {
            return 95; // Same vibrations share innate natural sympathy
        }

        $group1 = self::GROUPS[$r1] ?? 'unknown';
        $group2 = self::GROUPS[$r2] ?? 'unknown';

        if ($group1 === $group2) {
            return 85; // Same harmonic group
        }

        // Distance on 9-cycle
        $distance = min(abs($r1 - $r2), 9 - abs($r1 - $r2));

        // Friendly pairs across groups
        $friendlyPairs = [
            '1-2' => 80, '1-3' => 88, '1-5' => 85, '1-9' => 82,
            '2-6' => 86, '2-8' => 82, '2-9' => 78,
            '3-5' => 84, '3-6' => 90, '3-9' => 92,
            '4-6' => 78, '4-8' => 86,
            '5-7' => 80, '5-9' => 82,
            '6-9' => 94, '7-9' => 76,
        ];

        $pairKey = min($r1, $r2) . '-' . max($r1, $r2);
        if (isset($friendlyPairs[$pairKey])) {
            return $friendlyPairs[$pairKey];
        }

        return max(50, 75 - ($distance * 8));
    }

    /**
     * Generate bilingual interpretations based on compatibility tier.
     */
    private function generateSummaries(int $score, array $p1, array $p2): array
    {
        $name1 = $p1['first_name'];
        $name2 = $p2['first_name'];

        if ($score >= 80) {
            $en = "This is an exceptional compatibility match. Both individuals share harmonious energetic vibrations that naturally foster deep emotional warmth, mutual respect, and long-lasting partnership.";
            $ta = "இது மிகச் சிறந்த இணக்கமான பொருத்தம். {$name1} மற்றும் {$name2} இருவரும் ஒருவருக்கொருவர் இயல்பாகவே ஒத்துப்போகும் நல்ல அதிர்வுகளைக் கொண்டுள்ளனர். இவர்களிடையே ஆழ்ந்த அன்பு, பரஸ்பர மரியாதை மற்றும் நீடித்த மகிழ்ச்சியான வாழ்க்கை அமையும்.";
        } elseif ($score >= 65) {
            $en = "This is a good compatibility match. Both individuals complement each other well and have strong emotional and intellectual understanding. There are positive energies for long-term harmony and mutual support.";
            $ta = "இது ஒரு நல்ல இணக்கமான பொருத்தம். {$name1} மற்றும் {$name2} இருவரும் ஒருவருக்கொருவர் நிறைவாகப் பொருந்துகிறார்கள். உணர்வுப்பூர்வமாகவும் அறிவுப்பூர்வமாகவும் நல்ல புரிதல் உள்ளதால், வாழ்க்கையில் மகிழ்ச்சியும் ஒத்துழைப்பும் நீடிக்கும்.";
        } else {
            $en = "This match shows moderate compatibility with dynamic differences. While personalities may approach life from different perspectives, mutual patience, communication, and conscious effort will build a balanced bond.";
            $ta = "இந்த பொருத்தம் மிதமான இணக்கத்தைக் காட்டுகிறது. வெவ்வேறு குணாதிசயங்களும் கண்ணோட்டங்களும் இருந்தாலும், விட்டுக்கொடுத்துச் செல்லுதல் மற்றும் தெளிவான உரையாடல் மூலம் சமநிலையான நல்ல பந்தத்தை உருவாக்க முடியும்.";
        }

        return [$en, $ta];
    }

    /**
     * Reduce number to single digit, preserving 11, 22, 33 if preferred.
     */
    public function reduceNumber(int $num, bool $preserveMaster = false): int
    {
        while ($num > 9) {
            if ($preserveMaster && in_array($num, [11, 22, 33], true)) {
                return $num;
            }
            $num = array_sum(str_split((string) $num));
        }

        return $num;
    }

    /**
     * Reduce to 1-9 root.
     */
    public function toRoot(int $num): int
    {
        while ($num > 9) {
            $num = array_sum(str_split((string) $num));
        }
        return $num;
    }

    /**
     * Extract uppercase English letters.
     */
    private function extractLetters(string $text): array
    {
        $clean = preg_replace('/[^A-Za-z]/', '', $text);
        return str_split(strtoupper($clean));
    }
}
