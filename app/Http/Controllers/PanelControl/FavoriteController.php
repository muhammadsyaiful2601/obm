<?php

namespace App\Http\Controllers\PanelControl;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // Menambahkan atau menghapus film dari favorit
    public function toggle(Request $request)
    {
        $request->validate([
            'imdb_id' => 'required|string',
            'title' => 'nullable|string',
            'year' => 'nullable|string',
            'poster' => 'nullable|string',
            'type' => 'nullable|string',
        ]);

        $userId = Auth::id();
        $imdbId = $request->imdb_id;

        // Cek apakah film sudah ada di favorit user ini
        $favorite = Favorite::where('user_id', $userId)
            ->where('imdb_id', $imdbId)
            ->first();

        if ($favorite) {
            // Jika sudah ada, hapus dari favorit
            $favorite->delete();
            return response()->json([
                'success' => true,
                'message' => trans('messages.removed_from_favorites'),
                'isFavorite' => false,
            ]);
        } else {
            // Jika belum ada dan title tidak kosong, tambahkan ke favorit
            if (empty($request->title)) {
                return response()->json([
                    'success' => false,
                    'message' => trans('messages.incomplete_data'),
                ], 400);
            }

            Favorite::create([
                'user_id' => $userId,
                'imdb_id' => $imdbId,
                'title' => $request->title,
                'year' => $request->year,
                'poster' => $request->poster,
                'type' => $request->type,
            ]);

            return response()->json([
                'success' => true,
                'message' => trans('messages.added_to_favorites'),
                'isFavorite' => true,
            ]);
        }
    }

    // Mengecek apakah film sudah difavoritkan oleh user
    public function check($imdbId)
    {
        $userId = Auth::id();
        $isFavorite = Favorite::where('user_id', $userId)
            ->where('imdb_id', $imdbId)
            ->exists();

        return response()->json([
            'isFavorite' => $isFavorite,
        ]);
    }

    // Mendapatkan semua favorit user
    public function getFavorites()
    {
        $userId = Auth::id();
        $favorites = Favorite::where('user_id', $userId)->get();

        return response()->json([
            'favorites' => $favorites,
        ]);
    }
}
