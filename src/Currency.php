<?php

namespace Avant\LaravelNovaCurrencyField;

use Laravel\Nova\Fields\Currency as Field;
use Symfony\Component\Intl\Currencies;

class Currency extends Field
{
    /** @var string */
    public $component = 'laravel-nova-currency-field';

    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->locale = config('app.locale', 'en');
        $this->currency = config('nova.currency', 'GBP');

        $this->step($this->getStepValue());

        $this->fillUsing(function ($request, $model, $attribute) {
            $value = $request->$attribute;

            if ($this->minorUnits) {
                $model->$attribute = $this->toMoneyInstance($value)->getMinorAmount()->toInt();
            } else {
                $model->$attribute = $value * $this->getDecimalMagnitude();
            }
        })
            ->displayUsing(function ($value) {
                if ($this->isNullValue($value)) {
                    return null;
                }
                if (!$this->minorUnits) {
                    $value = $value / $this->getDecimalMagnitude();
                }

                return $this->formatMoney($value);
            })
            ->resolveUsing(function ($value) {
                if ($this->isNullValue($value)) {
                    return null;
                }
                if (!$this->minorUnits) {
                    return $value / $this->getDecimalMagnitude();
                }

                return $this->toMoneyInstance($value)->getMinorAmount()->toInt();
            });
    }

    protected function getDecimalMagnitude(): int
    {
        return pow(10, Currencies::getFractionDigits($this->currency));
    }
}
