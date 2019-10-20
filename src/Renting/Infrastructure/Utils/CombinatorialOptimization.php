<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 18/10/19 14:00
 */

namespace Booking\Renting\Infrastructure\Utils;


use DateInterval;
use DateTime;

class CombinatorialOptimization
{
    const DATE_FORMAT = 'Y-m-d';

    public function createCombinations(array $array = []) {
		$results = [[]];
		foreach ($array as $key => $value) {
			foreach ($results as $i => $combination) {
				$results[] = array_values($combination + [$i => $value]);
			}
		}
		$results = array_filter($results);
		$results = array_values($results);

		return $results;
	}

	public function filterRequestById(string $searchId, string $key, array $requests = [])
	{
		$item = array_filter($requests, function ($request) use ($searchId, $key){
			if (!empty($request[$key]) && $request[$key] === $searchId) {
				return $request;
			}
		});
		return current($item);
	}

	public function getRequestIds(array $requests, string $key): array
    {
        return array_map(function ($request) use ($key) {
            if(!empty($request[$key])){
                return $request[$key];
            }
        }, $requests);
    }

    public function getDatePeriodByNights(string $date, int $nights)
    {
        $d = DateTime::createFromFormat(self::DATE_FORMAT, $date);
        $nd = clone $d;
        $nd->add(new DateInterval(sprintf('P%dD', $nights)));

        return [$d, $nd];
    }

    public function checkOverlappingRangesDate(array $ranges): bool
    {
        $overlap = false;
        foreach ($ranges as $key => $range) {
            $r1s = $range[0];
            $r1e = $range[1];

            foreach ($ranges as $key2 => $range2) {
                if ($key != $key2) {
                    $r2s = $range2[0];
                    $r2e = $range2[1];

                    if ($r1s >= $r2s && $r1s <= $r2e || $r1e >= $r2s && $r1e <= $r2e || $r2s >= $r1s && $r2s <= $r1e || $r2e >= $r1s && $r2e <= $r1e) {
                        $overlap = true;
                        break;
                    }
                }
            }
        }
        return $overlap;
    }
}