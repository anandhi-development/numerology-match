<?php

namespace Tests\Unit;

use App\Services\NumerologyService;
use PHPUnit\Framework\TestCase;

class NumerologyServiceTest extends TestCase
{
    protected NumerologyService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new NumerologyService();
    }

    public function test_it_calculates_life_path_number_correctly(): void
    {
        // 1992-06-12 -> 1+9+9+2 + 0+6 + 1+2 = 21 + 6 + 3 = 30 -> 3
        $lp = $this->service->calculateLifePath('1992-06-12');
        $this->assertEquals(3, $lp);

        // 2000-01-01 -> 2+0+0+0 + 0+1 + 0+1 = 4
        $this->assertEquals(4, $this->service->calculateLifePath('2000-01-01'));
    }

    public function test_it_calculates_destiny_number_correctly(): void
    {
        // ARUN: A(1)+R(9)+U(3)+N(5) = 18 -> 9
        // KUMAR: K(2)+U(3)+M(4)+A(1)+R(9) = 19 -> 10 -> 1
        // Total: 9 + 1 = 10 -> 1
        $destiny = $this->service->calculateDestiny('Arun Kumar');
        $this->assertEquals(1, $destiny);
    }

    public function test_it_calculates_soul_urge_from_vowels(): void
    {
        // ARUN: vowels A(1)+U(3) = 4
        // KUMAR: vowels U(3)+A(1) = 4
        // Total: 4 + 4 = 8
        $soul = $this->service->calculateSoul('Arun Kumar');
        $this->assertEquals(8, $soul);
    }

    public function test_it_calculates_personality_from_consonants(): void
    {
        // ARUN: R(9)+N(5) = 14 -> 5
        // KUMAR: K(2)+M(4)+R(9) = 15 -> 6
        // Total: 14 + 15 = 29 -> 11 -> 2
        $pers = $this->service->calculatePersonality('Arun Kumar');
        $this->assertEquals(2, $pers);
    }

    public function test_it_compares_two_profiles_with_valid_score_and_summaries(): void
    {
        $res = $this->service->compareProfiles(
            ['first_name' => 'Arun', 'last_name' => 'Kumar', 'dob' => '1992-06-12'],
            ['first_name' => 'Priya', 'last_name' => 'Raman', 'dob' => '1995-11-18']
        );

        $this->assertArrayHasKey('compatibility_score', $res);
        $this->assertGreaterThanOrEqual(40, $res['compatibility_score']);
        $this->assertLessThanOrEqual(100, $res['compatibility_score']);
        $this->assertNotEmpty($res['summary_en']);
        $this->assertNotEmpty($res['summary_ta']);
    }
}
