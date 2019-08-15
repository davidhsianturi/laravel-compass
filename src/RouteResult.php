<?php

namespace Davidhsianturi\Compass;

use JsonSerializable;

class RouteResult implements JsonSerializable
{
    /**
     * The route's ID.
     *
     * @var string
     */
    public $id;

    /**
     * The route storage id primary key.
     *
     * @var mixed
     */
    public $storageId;

    /**
     * The routeables title.
     *
     * @var string|null
     */
    public $title;

    /**
     * The routeables description.
     *
     * @var string|null
     */
    public $description;

    /**
     * The routeables network.
     *
     * @var array|null
     */
    public $network;

    /**
     * The datetime that the route was created.
     *
     * @var \Carbon\CarbonInterface|\Carbon\Carbon
     */
    public $createdAt;

    /**
     * The datetime that the route was updated.
     *
     * @var \Carbon\CarbonInterface|\Carbon\Carbon
     */
    public $updatedAt;

    /**
     * The additional route's information.
     *
     * @var array
     */
    public $info;

    /**
     * Create a new route result instance.
     *
     * @param  string  $id
     * @param  mixed  $storageId
     * @param  string|null  $title
     * @param  string|null  $description
     * @param  array|null  $network
     * @param  array  $info
     * @param  \Carbon\CarbonInterface|\Carbon\Carbon  $createdAt
     * @param  \Carbon\CarbonInterface|\Carbon\Carbon  $updatedAt
     */
    public function __construct(string $id, $storageId, ?string $title, ?string $description, ?array $network, array $info, $createdAt, $updatedAt)
    {
        $this->id = $id;
        $this->storageId = $storageId;
        $this->title = $title;
        $this->description = $description;
        $this->network = $network;
        $this->info = $info;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get the array representation of the route.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "storageId" => $this->storageId,
            "title" => $this->title,
            "description" => $this->description,
            "network" => $this->network,
            "info" => $this->info,
            "createdAt" => $this->createdAt->toDateTimeString(),
            "updatedAt" => $this->updatedAt->toDateTimeString(),
        ];
    }
}
