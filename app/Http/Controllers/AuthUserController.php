<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\ErrorResolve;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthUserController extends Controller
{
  use ErrorResolve;

  public function __construct(private User $model)
  {
  }

  public function getUserAuth(): JsonResponse
  {
    try {
      $user = request()->user();
      return response()->json($user);
    } catch (Exception $exception) {
      return $this->displayError($exception, 'Erro na autenticação');
    }
  }

  public function signIn(Request $request): JsonResponse
  {
    try {
      $request->validate([
        'email' => 'required|email',
        'password' => 'required',
      ]);

      $user = User::query()
        ->where('email', $request->email)
        ->first();

      if (!$user || !Hash::check($request->password, $user->password)) {
        throw new AuthenticationException('Usuário ou senha inválidos');
      }

      $token = $user->createToken('auth_token')->plainTextToken;

      return response()->json([
        'token' => $token,
        'user' => $user,
      ]);
    } catch (AuthenticationException $exception) {
      return response()->json([
        'title' => 'NotFound',
        'message' => $exception->getMessage(),
      ], Response::HTTP_NOT_FOUND);
    } catch (Exception $exception) {
      return response()->json([
        'title' => 'BadRequest',
        'message' => $exception->getMessage(),
      ], Response::HTTP_BAD_REQUEST);
    }
  }

  public function logout(Request $request)
  {
    try {
      $request->user()->currentAccessToken()->delete();

      return response()->noContent();
    } catch (Exception $exception) {
      return $this->displayError($exception, 'Erro ao sair');
    }
  }

  public function getUsers(Request $request)
  {
    try {
      $users = User::query()->get();

      return response()->json($users);
    } catch (Exception $exception) {
      $this->displayError($exception);
    }
  }
}
