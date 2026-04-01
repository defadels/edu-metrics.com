<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LikertScale;
use App\Models\LikertScaleOption;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\UpdateLikertScaleOption;
use Illuminate\Support\Facades\DB;


class ScaleOptionController extends Controller
{
    public function edit(LikertScale $likertScale) : View
    {


        return view('dashboard.likert-scales.edit-scale', compact('likertScale'));
    }


    public function update(Request $request, $likertScale){

        $optionsData = $request->input('options');

       try{
           foreach($optionsData as $id => $data){
               
            if(!$optionsData){
                return redirect()->back()->with('error', 'Tidak ada data untuk diupdate');
            }
// 
                DB::table('likert_scale_options')
                ->where('id', $id)
                ->update([
                    'value' => $data['value'],
                    'label' => $data['label'],
                    'order' => $data['order']
                ]);

            // dd($likertScaleOption);

            // $likertScaleOption->save();
        }

       }catch(Exception $e){
            return redirect()->route('dashboard.likert-scales.show', $likertScale)
                ->with('error', 'Scale options update failed.');
       }

        return redirect()->route('dashboard.likert-scales.show', $likertScale)
                ->with('success', 'Scale options updated successfully.');

    }
}
