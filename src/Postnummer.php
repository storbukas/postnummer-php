<?php

declare(strict_types=1);

namespace Storbukas\Postnummer;

/**
 * Norwegian postal code lookup
 *
 * @author Lars Erik Storbukås <https://github.com/storbukas>
 * @license MIT
 */
class Postnummer
{
    private static ?array $data = null;

    /**
     * Load postal code data from JSON file
     */
    private static function loadData(): array
    {
        if (self::$data === null) {
            $jsonPath = __DIR__ . '/resources/postnummer.json';
            $json = file_get_contents($jsonPath);
            self::$data = json_decode($json, true);
        }

        return self::$data;
    }

    /**
     * Get full postal code information
     *
     * @param string|int $postnummer The postal code
     * @return array|null Returns array with poststed, kommunenummer, kommunenavn, kategori or null if not found
     */
    public static function get(string|int $postnummer): ?array
    {
        $data = self::loadData();
        $key = str_pad((string) $postnummer, 4, '0', STR_PAD_LEFT);

        return $data[$key] ?? null;
    }

    /**
     * Get place name for a postal code
     *
     * @param string|int $postnummer The postal code
     * @return string|null The place name or null if not found
     */
    public static function poststed(string|int $postnummer): ?string
    {
        $info = self::get($postnummer);

        return $info['poststed'] ?? null;
    }

    /**
     * Get municipality name for a postal code
     *
     * @param string|int $postnummer The postal code
     * @return string|null The municipality name or null if not found
     */
    public static function kommunenavn(string|int $postnummer): ?string
    {
        $info = self::get($postnummer);

        return $info['kommunenavn'] ?? null;
    }

    /**
     * Get municipality number for a postal code
     *
     * @param string|int $postnummer The postal code
     * @return string|null The municipality number or null if not found
     */
    public static function kommunenummer(string|int $postnummer): ?string
    {
        $info = self::get($postnummer);

        return $info['kommunenummer'] ?? null;
    }

    /**
     * Get category for a postal code
     *
     * Categories:
     * - B = Both street addresses and PO boxes
     * - F = Multiple use
     * - G = Street addresses only
     * - P = PO boxes only
     * - S = Service postal codes
     *
     * @param string|int $postnummer The postal code
     * @return string|null The category or null if not found
     */
    public static function kategori(string|int $postnummer): ?string
    {
        $info = self::get($postnummer);

        return $info['kategori'] ?? null;
    }

    /**
     * Check if a postal code exists
     *
     * @param string|int $postnummer The postal code
     * @return bool True if the postal code exists
     */
    public static function exists(string|int $postnummer): bool
    {
        return self::get($postnummer) !== null;
    }

    /**
     * Search for postal codes by place name
     *
     * @param string $search The search string
     * @return array Array of matching postal codes with their info
     */
    public static function search(string $search): array
    {
        $data = self::loadData();
        $search = mb_strtoupper($search);
        $results = [];

        foreach ($data as $postnummer => $info) {
            if (str_contains($info['poststed'], $search) || str_contains($info['kommunenavn'], $search)) {
                $results[$postnummer] = $info;
            }
        }

        return $results;
    }

    /**
     * Get all postal codes
     *
     * @return array All postal codes with their info
     */
    public static function all(): array
    {
        return self::loadData();
    }
}
