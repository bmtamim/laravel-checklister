<?php


namespace App\DTO;


use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;
use Spatie\DataTransferObject\DataTransferObject;

class TaskDTO extends DataTransferObject
{
    public string $name;
    public ?string $description;
    public int $order;

    public static function createFromRequest(Request $request): TaskDTO
    {
        $orderCount = $request->checklist->tasks()->max('order') + 1;

        return new self([
            'name'        => $request->input('name'),
            'description' => $request->input('description'),
            'order'       => $orderCount,
        ]);
    }


    #[ArrayShape(['name' => "string", 'description' => "null|string", 'order' => "int"])]
    public function toArray(): array
    {
        return [
            'name'        => $this->name,
            'description' => $this->description,
            'order'       => $this->order,
        ];
    }
}
