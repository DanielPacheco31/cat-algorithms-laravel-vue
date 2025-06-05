<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AlgorithmController extends Controller
{
    public function test(): JsonResponse
    {
        return response()->json([
            'message' => '🐱 API Cat Algorithms funcionando correctamente!',
            'timestamp' => now()->toISOString(),
            'laravel' => app()->version(),
            'status' => 'success'
        ]);
    }

    public function info(): JsonResponse
    {
        return response()->json([
            'app' => 'Cat Algorithms API',
            'version' => '1.0.0',
            'description' => 'API REST para resolver problemas algorítmicos con temática felina - Iyata SAS',
            'developer' => 'Daniel Pacheco',
            'endpoints' => [
                'GET /api/test' => 'Test de conexión',
                'GET /api/info' => 'Información de la API',
                'POST /api/construir-casitas' => 'Generar direcciones IP válidas',
                'POST /api/longitud-siesta' => 'Calcular secuencia consecutiva más larga',
                'POST /api/descifrar-maullido' => 'Descifrar maullidos con diccionario'
            ],
            'status' => 'active'
        ]);
    }

    public function construirCasitas(Request $request): JsonResponse
    {
        $request->validate([
            'cadenaJuguetes' => 'required|string|min:1|max:20|regex:/^[0-9]+$/'
        ]);

        try {
            $resultado = $this->resolverCasitas($request->cadenaJuguetes);
            
            return response()->json([
                'success' => true,
                'data' => $resultado,
                'total' => count($resultado),
                'input' => $request->cadenaJuguetes,
                'algorithm' => 'Backtracking con validación IP',
                'complexity' => 'O(3^4) tiempo, O(1) espacio'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la cadena de juguetes',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function longitudSiesta(Request $request): JsonResponse
    {
        $request->validate([
            'collares' => 'required|array',
            'collares.*' => 'integer|min:-1000000000|max:1000000000'
        ]);

        try {
            $resultado = $this->resolverSiesta($request->collares);
            
            return response()->json([
                'success' => true,
                'data' => $resultado,
                'input' => $request->collares,
                'total_gatos' => count($request->collares),
                'algorithm' => 'HashSet con búsqueda O(1)',
                'complexity' => 'O(n) tiempo, O(n) espacio'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al calcular la secuencia de siesta',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function descifrarMaullido(Request $request): JsonResponse
    {
        $request->validate([
            'maullido' => 'required|string|min:1|max:20|regex:/^[a-z]+$/',
            'diccionarioFelino' => 'required|array|min:1|max:1000',
            'diccionarioFelino.*' => 'string|min:1|max:10|regex:/^[a-z]+$/'
        ]);

        try {
            $resultado = $this->resolverMaullido($request->maullido, $request->diccionarioFelino);
            
            return response()->json([
                'success' => true,
                'data' => $resultado,
                'total' => count($resultado),
                'input' => [
                    'maullido' => $request->maullido,
                    'diccionario' => $request->diccionarioFelino
                ],
                'algorithm' => 'Backtracking con memorización',
                'complexity' => 'O(2^n) tiempo en el peor caso'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al descifrar el maullido',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    // ===== ALGORITMO 1: Las Casitas de los Gatos Numéricos =====
    private function resolverCasitas(string $cadenaJuguetes): array
    {
        $resultado = [];
        $n = strlen($cadenaJuguetes);
        
        $this->backtrackCasitas($cadenaJuguetes, 0, 0, '', $resultado, $n);
        
        return $resultado;
    }
    
    private function backtrackCasitas(string $cadena, int $inicio, int $partes, string $ipActual, array &$resultado, int $n): void
    {
        if ($partes === 4 && $inicio === $n) {
            $resultado[] = rtrim($ipActual, '.');
            return;
        }
        
        if ($partes === 4 || $inicio >= $n) return;
        
        for ($len = 1; $len <= 3 && $inicio + $len <= $n; $len++) {
            $segmento = substr($cadena, $inicio, $len);
            
            if ($this->esSegmentoValido($segmento)) {
                $this->backtrackCasitas($cadena, $inicio + $len, $partes + 1, $ipActual . $segmento . '.', $resultado, $n);
            }
        }
    }
    
    private function esSegmentoValido(string $segmento): bool
    {
        if (empty($segmento)) return false;
        if (strlen($segmento) > 1 && $segmento[0] === '0') return false;
        
        $num = intval($segmento);
        return $num >= 0 && $num <= 255;
    }

    // ===== ALGORITMO 2: Secuencia de Siesta Felina =====
    private function resolverSiesta(array $collares): int
    {
        if (empty($collares)) return 0;
        
        $conjuntoCollares = array_flip($collares);
        $maxLongitud = 0;
        
        foreach ($collares as $collar) {
            if (!isset($conjuntoCollares[$collar - 1])) {
                $numActual = $collar;
                $longitudActual = 1;
                
                while (isset($conjuntoCollares[$numActual + 1])) {
                    $numActual++;
                    $longitudActual++;
                }
                
                $maxLongitud = max($maxLongitud, $longitudActual);
            }
        }
        
        return $maxLongitud;
    }

    // ===== ALGORITMO 3: Descifrando el Maullido Secreto =====
    private function resolverMaullido(string $maullido, array $diccionarioFelino): array
    {
        $resultado = [];
        $conjuntoPalabras = array_flip($diccionarioFelino);
        
        $this->backtrackMaullido($maullido, 0, '', $resultado, $conjuntoPalabras);
        
        return $resultado;
    }
    
    private function backtrackMaullido(string $maullido, int $inicio, string $fraseActual, array &$resultado, array $conjuntoPalabras): void
    {
        if ($inicio === strlen($maullido)) {
            $resultado[] = trim($fraseActual);
            return;
        }
        
        for ($fin = $inicio + 1; $fin <= strlen($maullido); $fin++) {
            $palabra = substr($maullido, $inicio, $fin - $inicio);
            
            if (isset($conjuntoPalabras[$palabra])) {
                $separador = !empty($fraseActual) ? ' ' : '';
                $this->backtrackMaullido($maullido, $fin, $fraseActual . $separador . $palabra, $resultado, $conjuntoPalabras);
            }
        }
    }
}