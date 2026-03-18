<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'ADMIN';
    case ALUMNO = 'ALUMNO';
    case PADRE = 'PADRE';
    case ENCARGADOSEDE = 'ENCARGADO_SEDE';
    case DOCENTE = 'DOCENTE';

   
    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Administrador del Sistema',
            self::ALUMNO => 'Alumno',
            self::PADRE => 'Apoderado',
            self::ENCARGADOSEDE => 'Encargado de Sede',
            self::DOCENTE => 'Docente',
        };
    }
}