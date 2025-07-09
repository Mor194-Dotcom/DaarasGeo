<?php

namespace App;

namespace App\Models\Enums;

enum TypeTuteurEnum: string
{
    case Famille = 'Famille';
    case Benevole = 'Bénévole';
    case EncadrantLocal = 'Encadrant local';

        // Tu peux ajouter d'autres cas plus tard :
    case AssistantSocial = 'Assistant social';
    case Parrain = 'Parrain';
    case Marrain = 'Marrain';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
