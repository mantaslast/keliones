<?php

namespace App\Http\Controllers\API\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use PDF;

class UsersController extends Controller
{
    public function destroy(Request $request)
    {
        try{
            $id = $request->id;
            $user = User::findOrFail($id);
            $user->delete();
            return json_encode(['success' => 1]);
        } catch(Exception $e) {
            return json_encode(['success' => 0]);
        }
    }

    public function generatePdf(Request $request)
    {
        $users = $request->users;
        array_shift($users);
        view()->share('admin.users.pdf',$users);
        $pdf = PDF::loadView('admin.users.pdf', compact('users'));

        return $pdf->stream('pdf_file.pdf');
    }
}
