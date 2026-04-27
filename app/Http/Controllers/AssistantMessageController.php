<?php

namespace App\Http\Controllers;

use App\Services\BusinessAssistantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssistantMessageController extends Controller
{
    public function __invoke(Request $request, BusinessAssistantService $assistant): JsonResponse
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:800'],
            'history' => ['nullable', 'array'],
            'history.*.role' => ['required_with:history', 'in:user,assistant'],
            'history.*.content' => ['required_with:history', 'string', 'max:800'],
        ]);

        return response()->json(
            $assistant->reply(
                $data['message'],
                $data['history'] ?? []
            )
        );
    }
}
