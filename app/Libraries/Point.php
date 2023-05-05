<?php
namespace App\Libraries;

use App\Enums\RulePointEnum;
use Illuminate\Support\Arr;

/**
 * Summary of Point
 * @author Yaden Mustopa
 * @copyright (c) 2023
 */
class Point
{
    /**
     * Summary of calculate
     * @param string $description
     * @param int $totalTransaction
     * @return int
     */
    static function get($description = "", $totalTransaction)
    {
        $rulePoints = RulePointEnum::values();
        if ($description !== "Beli Pulsa" && $description !== "Bayar Listrik") {
            return 0;
        }

        if ($description === "Beli Pulsa") {
            return self::checkBeliPulsa($totalTransaction);
        } else {
            return self::checkBayarListrik($totalTransaction);
        }
    }

    /**
     * Summary of checkBeliPulsa
     * @param int $totalTransaction
     * @return float|int
     */
    static function checkBeliPulsa($totalTransaction)
    {
        $rangeOne = 10000;
        $rangeTwo = 30000;
        if ($totalTransaction <= $rangeOne) {
            return 0;
        }
        $points = self::getPoints($totalTransaction, RulePointEnum::beliPulsa->value, $rangeOne);
        return array_sum($points);
    }

    /**
     * Summary of checkBayarListrik
     * @param mixed $totalTransaction
     * @return float|int
     */
    static function checkBayarListrik($totalTransaction)
    {
        $rangeOne = 50000;
        $rangeTwo = 100000;
        if ($totalTransaction <= $rangeOne) {
            return 0;
        }
        $points = self::getPoints($totalTransaction, RulePointEnum::bayarListrik->value, $rangeOne);
        return array_sum($points);
    }

    /**
     * Summary of getPoints
     * @param int $totalTransaction
     * @param int $rulePoint
     * @param int $rangeOne
     * @param int $rangeTwo
     * @return array<float>
     */
    static function getPoints($totalTransaction, $rulePoint, $rangeOne)
    {

        $points      = [];
        $subtraction = self::getRemainingSubtractionCalculation($rangeOne, $totalTransaction);
        $amount      = ($subtraction > 0) ? $rangeOne : $totalTransaction;
        $points[]    = self::calculate($amount, $rulePoint, 1);
        if ($subtraction) {
            $points[] = self::calculate($subtraction, $rulePoint, 2);
        }
        return $points;
    }

    /**
     * Summary of getRemainingSubtractionCalculation
     * @param  $range
     * @param mixed $totalTransaction
     * @return int
     */
    static function getRemainingSubtractionCalculation($range, $totalTransaction)
    {
        return (int) $totalTransaction - $range;
    }

    /**
     * Summary of calculate
     * @param mixed $rulePoint
     * @param mixed $rangePoint
     * @param mixed $amount
     * @return float
     */
    static function calculate($amount, $rulePoint, $rangePoint)
    {
        return (float) ($amount / $rulePoint) * $rangePoint;
    }
}
