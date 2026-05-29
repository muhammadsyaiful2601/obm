<?php

namespace App\Http\Controllers\PanelControl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(\App\Services\MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index(Request $request)
    {
        try {
            $query = $request->get('q', '');
            $page = $request->get('page', 1);

            if (empty($query)) {
                if ($request->ajax()) {
                    return response()->json([
                        'movies' => [],
                        'total' => 0,
                        'error' => null,
                    ]);
                }
            }

            $result = $this->movieService->search($query, $page);

            if ($request->ajax()) {
                return response()->json($result);
            }

            return view('controll-panel.movie', $result);
        } catch (\throwable $th) {
            Log::error('Error during movie search: ' . $th->getMessage(), [
                'line'      => $th->getLine(),
                'file'      => $th->getFile(),
                'message'   => $th->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mencari film.');
        }
    }
}
