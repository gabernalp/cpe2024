<?php

namespace App\Http\Controllers\Admin;

use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Http\Controllers\Controller;
use App\Models\User;

class HomeController
{
    public function index()
    {
        $settings1 = [
            'chart_title'           => 'Registrados en la plataforma',
            'chart_type'            => 'line',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\User',
            'group_by_field'        => 'email_verified_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'filter_days'           => '14',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class'          => 'col-md-6',
            'entries_number'        => '5',
            'translation_key'       => 'user',
        ];

        $chart1 = new LaravelChart($settings1);

        $settings2 = [
            'chart_title'           => 'Registrados mas recientes',
            'chart_type'            => 'latest_entries',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\User',
            'group_by_field'        => 'email_verified_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class'          => 'col-md-6',
            'entries_number'        => '10',
            'fields'                => [
                'id'         => '',
                'name'       => '',
                'department' => 'name',
            ],
            'translation_key' => 'user',
        ];

        $settings2['data'] = [];
        if (class_exists($settings2['model'])) {
            $settings2['data'] = $settings2['model']::latest()
                ->take($settings2['entries_number'])
                ->get();
        }

        if (!array_key_exists('fields', $settings2)) {
            $settings2['fields'] = [];
        }
        
        if(session('mts') == auth()->id()){
            return view('home', compact('chart1', 'settings2'));
        }
        else{
            return redirect()->route('cpe.gestion')->with('error','error')->with('message','Interfaz incorrecta de inicio de sesión por favor utilice esta pagina para ingresar con sus debidas credenciales como Usuario Administrador');
        }

    }
}
