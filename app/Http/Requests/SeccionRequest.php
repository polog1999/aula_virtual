<?php

namespace App\Http\Requests;

use App\Enums\DiaSemana;
use App\Models\Seccion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SeccionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'createTaller' => ['required', Rule::exists('cursos', 'id')->where(function ($q) {
                $q->where('activo', true);
            })],
            'createDocente' => ['required', Rule::exists('docentes', 'user_id')],
            // 'createLugar' => ['required', Rule::exists('lugares', 'id')],
            'createNombre' => ['required', 'string', 'max:100'],
            'createVacantes' => ['required', 'integer', 'min:1'],
            'createPeriodo' => ['required', Rule::exists('periodos', 'id')],
            'createFechaInicio' => ['required','date'],
            // 'createFechaFin' => ['required','date', 'after_or_equal:createFechaInicio'],
            'createEstado' => ['required','boolean'],
            'createDias.*' => ['required', Rule::in(array_column(DiaSemana::cases(), 'value'))],
            'createHoraInicio.*' => ['required', 'date_format:H:i'], 
            'createHoraFin.*' => ['required' => 'date_format:H:i', 'after:createHoraInicio.*']

        ];
    }
}
