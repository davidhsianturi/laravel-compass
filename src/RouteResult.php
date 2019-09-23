<?php

namespace Davidhsianturi\Compass;

use JsonSerializable;

class RouteResult implements JsonSerializable
{
    /**
     * The route's hash ID.
     *
     * @var string
     */
    public $id;

    /**
     * The routeable primary key.
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
     * The routeables content.
     *
     * @var array|null
     */
    public $content;

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
     * The routeables is an example or not.
     *
     * @var boolean
     */
    public $isExample;

    /**
     * The route response as an example.
     *
     * @var array
     */
    public $examples;

    /**
     * Create a new route result instance.
     *
     * @param  string  $id
     * @param  mixed  $storageId
     * @param  string|null  $title
     * @param  string|null  $description
     * @param  array|null  $content
     * @param  array  $info
     * @param  \Carbon\CarbonInterface|\Carbon\Carbon  $createdAt
     * @param  \Carbon\CarbonInterface|\Carbon\Carbon  $updatedAt
     * @param  boolean  $isExample
     * @param  array  $examples
     */
    public function __construct(string $id, $storageId, ?string $title, ?string $description, ?array $content, array $info, $createdAt, $updatedAt, $isExample, $examples = [])
    {
        $this->id = $id;
        $this->storageId = $storageId;
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->info = $info;
        $this->isExample = $isExample;
        $this->examples = $examples;
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
            "content" => $this->content,
            "info" => $this->info,
            "isExample" => $this->isExample,
            "examples" => $this->examples,
            "createdAt" => $this->createdAt->toDateTimeString(),
            "updatedAt" => $this->updatedAt->toDateTimeString(),
        ];
    }
}
