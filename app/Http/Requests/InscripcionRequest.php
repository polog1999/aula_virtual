<?php

namespace App\Http\Requests;

use App\Models\Categoria;
use App\Models\oracle\Distrito;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InscripcionRequest extends FormRequest
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
        $codigosDistritos = Distrito::pluck('districodi');
        $codigosDistritos[] = '999';
        $this->merge([
            'parentDistrito' => $this->parentDistrito ?? $this->parentDistritoHidden, 
            'studentDistrito' => $this->studentDistrito ?? $this->studentDistritoHidden, 
        ]);
        // $codigosDistritos =    ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '51', '52', '53', '54', '55', '56'];
        // return $codigosDistritos[2];
        return [
            'idTaller' => ['required', Rule::exists('secciones', 'id')->where(function ($q) {
                $q->where('activo', true);
            })],
            'inscriptionType' => ['required', 'string', 'in:minor,adult'],
            'parentDNI' => ['exclude_if:inscriptionType,adult', 'required', 'digits:8'],
            'studentDNI' => ['required', 'digits:8'],
            'idCategoria' => ['required', 'exists:categorias,id'],
            'studentBirthdate' => ['required', 'date'],
            'parentDistrito' => ['exclude_if:inscriptionType,adult', 'required', 'string', Rule::in($codigosDistritos)],
            'parentEmail' => ['exclude_if:inscriptionType,adult', 'required', 'string', 'email', 'max:320'],
            'studentNames' => ['required', 'string', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u'],
            'studentPaternalLastName' => ['required', 'string', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u'],
            'studentMaternalLastName' => ['required', 'string', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u'],
            'conadis_number' => [Rule::excludeIf(Categoria::where('id', $this->idCategoria)->value('tiene_discapacidad') === false), 'required', 'string', 'max:30'],
            'parentNames' => ['exclude_if:inscriptionType,adult', 'required', 'string', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u'],
            'parentPaternalLastName' => ['exclude_if:inscriptionType,adult', 'required', 'string', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u', 'max:100'],
            'parentMaternalLastName' => ['exclude_if:inscriptionType,adult', 'required', 'string', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u', 'max:100'],
            'parentDireccion' => ['exclude_if:inscriptionType,adult', 'required', 'string', 'min:5', 'max:500'],
            'parentPhone' => ['exclude_if:inscriptionType,adult', 'required', 'string', 'max:9'],
            'parent_verification_code' => ['exclude_if:inscriptionType,adult', 'required', 'string', 'email', 'max:320'],
            'studentDistrito' => ['exclude_if:inscriptionType,minor', 'required', 'string', Rule::in($codigosDistritos)],
            'studentEmail' => ['exclude_if:inscriptionType,minor', 'required', 'string', 'email', 'max:320'],
            'parent_verification_code' => ['exclude_if:inscriptionType,adult', 'required', function ($attribute, $value, $fail) {
                $record = DB::table('email_verifications')
                    ->where('email', $this->parentEmail) // El correo que puso el usuario
                    ->where('code', $value)           // El código que escribió
                    ->where('expires_at', '>', now()) // Que no esté vencido
                    ->first();

                if (!$record) {
                    $fail('El código de verificación es incorrecto o ha expirado.');
                }
            }],
            'student_verification_code' => ['exclude_if:inscriptionType,minor', 'required', function ($attribute, $value, $fail) {
                $record = DB::table('email_verifications')
                    ->where('email', $this->studentEmail) // El correo que puso el usuario
                    ->where('code', $value)           // El código que escribió
                    ->where('expires_at', '>', now()) // Que no esté vencido
                    ->first();

                if (!$record) {
                    $fail('El código de verificación es incorrecto o ha expirado.');
                }
            }],

            'studentDireccion' => ['exclude_if:inscriptionType,minor', 'required', 'string', 'min:5', 'max:500'],
            'studentPhone' => ['exclude_if:inscriptionType,minor', 'required', 'string', 'max:9'],
            'terms' => ['accepted']

        ];
    }

    public function attributes(): array
    {
        return [
            'idTaller' => 'taller',
            'parentDistrito' => 'distrito',
            'inscriptionType' => 'tipo de inscripción',
            'studentDNI' => 'DNI del alumno',
            'idCategoria' => 'categoría',
            'studentBirthdate' => 'fecha de nacimiento',
            'studentNames' => 'nombres del alumno',
            'studentPaternalLastName' => 'apellido paterno del alumno',
            'studentMaternalLastName' => 'apellido materno del alumno',
            'parentDNI' => 'DNI del apoderado',
            'parentNames' => 'nombres del apoderado',
            'parentPaternalLastName' => 'apellido paterno del apoderado',
            'parentMaternalLastName' => 'apellido materno del apoderado',
            'parentDireccion' => 'dirección',
            'parentPhone' => 'celular',
            'parentEmail' => 'email',
            'studentDistrito' => 'distrito',
            'studentEmail' => 'email',
            'studentDireccion' => 'dirección',
            'studentPhone' => 'celular',
            'conadis_number' => 'número del CONADIS',
            'parent_verification_code' => 'código de verificación',
            'student_verification_code' => 'código de verificación',

            'terms' => 'términos y condiciones'



        ];
    }
}
