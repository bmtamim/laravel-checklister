<?php
namespace App\DTO;

use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ChecklistGroupDTO extends DataTransferObject
{
    public string $name;

    public static function createFromRequest(Request $request): ChecklistGroupDTO
    {
        $checklistGroupData = [
            'name' => $request->input('name'),
        ];

        return new self($checklistGroupData);
    }

    #[ArrayShape(['name' => "string"])]
    public function toArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
