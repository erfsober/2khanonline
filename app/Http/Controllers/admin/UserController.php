<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('orders');

        if ($search = $request->input('search')) {
            $query->where('phone', 'like', "%{$search}%");
        }

        switch ($request->input('sort')) {
            case 'oldest':
                $query->oldest();
                break;
            default:
                $query->latest();
                break;
        }

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['orders' => function ($q) {
            $q->latest()->with('items');
        }]);

        return view('admin.users.show', compact('user'));
    }
}
