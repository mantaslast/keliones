<?php

namespace App\Http\Controllers\API\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use PDF;

class CategoriesController extends Controller
{
    public function destroy(Request $request)
    {
        try{
            $id = $request->id;
            $category = Category::findOrFail($id);
            $category->delete();
            return json_encode(['success' => 1]);
        } catch(Exception $e) {
            return json_encode(['success' => 0]);
        }
    }

    public function generatePdf(Request $request)
    {
        $categories = $request->categories;
        array_shift($categories);
        view()->share('admin.categories.pdf',$categories);
        $pdf = PDF::loadView('admin.categories.pdf', compact('categories'));

        return $pdf->stream('pdf_file.pdf');
    }
}
