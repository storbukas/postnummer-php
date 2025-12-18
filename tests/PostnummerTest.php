<?php

declare(strict_types=1);

namespace Storbukas\Postnummer\Tests;

use PHPUnit\Framework\TestCase;
use Storbukas\Postnummer\Postnummer;

class PostnummerTest extends TestCase
{
    public function testGetReturnsPostalCodeInfo(): void
    {
        $info = Postnummer::get('4633');

        $this->assertIsArray($info);
        $this->assertEquals('KRISTIANSAND S', $info['poststed']);
        $this->assertEquals('4204', $info['kommunenummer']);
        $this->assertEquals('KRISTIANSAND', $info['kommunenavn']);
        $this->assertEquals('G', $info['kategori']);
    }

    public function testGetReturnsNullForInvalidPostalCode(): void
    {
        $info = Postnummer::get('9999');

        $this->assertNull($info);
    }

    public function testGetAcceptsIntegerPostalCode(): void
    {
        $info = Postnummer::get(4879);

        $this->assertIsArray($info);
        $this->assertEquals('GRIMSTAD', $info['poststed']);
    }

    public function testGetPadsShortPostalCodes(): void
    {
        $info = Postnummer::get('1');

        $this->assertIsArray($info);
        $this->assertEquals('OSLO', $info['poststed']);
    }

    public function testPoststedReturnsPlaceName(): void
    {
        $this->assertEquals('KRISTIANSAND S', Postnummer::poststed('4633'));
        $this->assertEquals('SANDVIKA', Postnummer::poststed('1337'));
        $this->assertEquals('GRIMSTAD', Postnummer::poststed(4879));
    }

    public function testPoststedReturnsNullForInvalidPostalCode(): void
    {
        $this->assertNull(Postnummer::poststed('9999'));
    }

    public function testKommunenavnReturnsMunicipalityName(): void
    {
        $this->assertEquals('KRISTIANSAND', Postnummer::kommunenavn('4633'));
    }

    public function testKommunenavnReturnsNullForInvalidPostalCode(): void
    {
        $this->assertNull(Postnummer::kommunenavn('9999'));
    }

    public function testKommunenummerReturnsMunicipalityNumber(): void
    {
        $this->assertEquals('4204', Postnummer::kommunenummer('4633'));
    }

    public function testKommunenummerReturnsNullForInvalidPostalCode(): void
    {
        $this->assertNull(Postnummer::kommunenummer('9999'));
    }

    public function testKategoriReturnsCategory(): void
    {
        $this->assertEquals('G', Postnummer::kategori('4633'));
    }

    public function testExistsReturnsTrueForValidPostalCode(): void
    {
        $this->assertTrue(Postnummer::exists('4633'));
        $this->assertTrue(Postnummer::exists(1337));
    }

    public function testExistsReturnsFalseForInvalidPostalCode(): void
    {
        $this->assertFalse(Postnummer::exists('9999'));
    }

    public function testSearchReturnsMatchingPostalCodes(): void
    {
        $results = Postnummer::search('KRISTIANSAND');

        $this->assertIsArray($results);
        $this->assertNotEmpty($results);
        $this->assertArrayHasKey('4633', $results);
    }

    public function testSearchIsCaseInsensitive(): void
    {
        $results = Postnummer::search('kristiansand');

        $this->assertNotEmpty($results);
    }

    public function testAllReturnsAllPostalCodes(): void
    {
        $all = Postnummer::all();

        $this->assertIsArray($all);
        $this->assertGreaterThan(5000, count($all));
    }
}
