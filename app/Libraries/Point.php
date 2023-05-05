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
        if ($description !== "Beli Pulsa" || $description !== "Bayar Listrik") {
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
        $checked  = false;
        if ($totalTransaction <= $rangeOne) {
            return 0;
        }
        $points = self::getPoints($totalTransaction, RulePointEnum::beliPulsa->value, $rangeOne, $rangeTwo);
        return array_sum($points);
    }

    /**
     * Summary of checkBayarListrik
     * @param mixed $totalTransaction
     * @return float|int
     */
    static function checkBayarListrik($totalTransaction)
    {
        $rangeOne = 10000;
        $rangeTwo = 30000;
        $checked  = false;
        if ($totalTransaction <= $rangeOne) {
            return 0;
        }
        $points = self::getPoints($totalTransaction, RulePointEnum::beliPulsa->value, $rangeOne, $rangeTwo);
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
    static function getPoints($totalTransaction, $rulePoint, $rangeOne, $rangeTwo)
    {
        $modulus  = self::getModulusCalculation($rangeOne, $totalTransaction);
        $amount   = ($modulus <= $rangeOne) ? $modulus : $rangeOne;
        $points[] = self::calculate($rulePoint, $rangeOne, $amount);
        if ($modulus > $rangeTwo) {
            $modulus  = self::getModulusCalculation($rangeTwo, $totalTransaction);
            $points[] = self::calculate($rulePoint, $rangeOne, $modulus);
        }

        return $points;
    }

    /**
     * Summary of getModulusCalculation
     * @param  $range
     * @param mixed $totalTransaction
     * @return int
     */
    static function getModulusCalculation($range, $totalTransaction)
    {
        return (int) $totalTransaction % $range;
    }

    /**
     * Summary of calculate
     * @param mixed $rulePoint
     * @param mixed $rangePoint
     * @param mixed $amount
     * @return float
     */
    static function calculate($rulePoint, $rangePoint, $amount)
    {
        return (float) ($amount / $rulePoint) * $rangePoint;
    }
}