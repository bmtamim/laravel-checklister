<?php


namespace App\DTO;


use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;
use Spatie\DataTransferObject\DataTransferObject;

class ChecklistDTO extends DataTransferObject
{
    public string $name;

    public static function createFromRequest(Request $request): ChecklistDTO
    {
        return new self([
            'name' => $request->input('name'),
        ]);
    }

    #[ArrayShape(['name' => "string"])]
    public function toArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
