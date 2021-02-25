<?php


namespace Olsgreen\AutoTrader\Api\Builders;


class CreateStockItemRequestBuilder extends AbstractBuilder
{
    protected $vehicleInfo;

    protected $vehicleFeatures;

    protected $vehicleMedia;

    protected $stockItemMetaInfo;

    protected $advertsInfo;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->vehicleInfo = new VehicleInfoBuilder($this->dataGet($attributes, 'vehicle', []));

        $this->vehicleFeatures = new VehicleFeatureInfoBuilder($this->dataGet($attributes, 'features', []));

        $this->vehicleMedia = new StockItemMediaInfoBuilder($this->dataGet($attributes, 'media', []));

        $this->advertsInfo = new StockItemAdvertsInfoBuilder($this->dataGet($attributes, 'adverts', []));

        $this->stockItemMetaInfo = new StockItemMetaInfoBuilder($this->dataGet($attributes, 'meta', []));
    }

    public function vehicle(): VehicleInfoBuilder
    {
        return $this->vehicleInfo;
    }

    public function features(): VehicleFeatureInfoBuilder
    {
        return $this->vehicleFeatures;
    }

    public function media(): StockItemMediaInfoBuilder
    {
        return $this->vehicleMedia;
    }

    public function adverts(): StockItemAdvertsInfoBuilder
    {
        return $this->advertsInfo;
    }

    public function meta(): StockItemMetaInfoBuilder
    {
        return $this->stockItemMetaInfo;
    }

    public function validate(): bool
    {
        $this->vehicle()->validate();
        $this->features()->validate();
        $this->media()->validate();
        $this->adverts()->validate();
        $this->meta()->validate();

        return true;
    }

    public function toArray(): array
    {
        $this->validate();

        return $this->filterPrepareOutput([
            'vehicle' => $this->vehicle()->prepare(),
            'features' => $this->features()->prepare(),
            'media' => $this->media()->prepare(),
            'adverts' => $this->adverts()->prepare(),
            'meta' => $this->meta()->prepare(),
        ]);
    }

    public function toJson($options = null): string
    {
        return json_encode($this->toArray(), $options);
    }
}