<?php

namespace App\Exports;
use App\Models\Character;
use Maatwebsite\Excel\Concerns\FromCollection;

class CharacterExport implements FromCollection
{
  public function collection()
  {
    return Character::all();
  }
}
