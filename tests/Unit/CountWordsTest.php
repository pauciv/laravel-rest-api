<?php

namespace Tests\Unit;

use App\Services\CountWordsService;
use PHPUnit\Framework\TestCase;

class CountWordsTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_empty_string_returns_zero(): void
    {
        $service = new CountWordsService();
        // $this->assertTrue($service->count('') === 0);
        $this->assertEquals($service->count(''), 0); // si tuviéramos varias assertions en el mimso test, podríamos distinguirlos más facilmente añadiendo un mensaje como 3r parámetro.
    }

    public function test_works_with_trailing_and_leading_spaces(): void
    {
        $service = new CountWordsService();
        $this->assertEquals($service->count('   '), 0);
        $this->assertEquals($service->count('Test   '), 1);
        $this->assertEquals($service->count('   Test   '), 1);
    }

    public function test_counts_correctly(): void
    {
        $service = new CountWordsService();
        $this->assertEquals($service->count('This is a test'), 4);
        $this->assertEquals($service->count('This is'), 2);
    }
}
