<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 18/10/19 14:00
 */

namespace Booking\Renting\Infrastructure\Utils;


class CombinatorialOptimization
{
	public function createCombinations(array $array = []) {
		$results = [[]];
		foreach ($array as $key => $value) {
			foreach ($results as $i => $combination) {
				$results[] = $combination + [$i => $value];
			}
		}
		$results = array_filter($results);
		$results = array_values($results);

		return $results;
	}

	public function filterRequestById(string $searchId, array $requests, string $key)
	{
		$item = array_filter($requests, function ($request) use ($searchId, $key){
			if (isset($request[$key]) && $request[$key] === $searchId) {
				return $request;
			}
		});
		return current($item);
	}
}