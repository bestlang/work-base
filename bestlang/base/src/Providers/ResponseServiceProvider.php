<?php

namespace Bestlang\Base\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // normal ajax macro
        Response::macro('ajax', function ($content = [], $code = 200, $status = 200, array $headers = [], $options = 0) {

            if ($content instanceof Arrayable) {
                $content = $content->toArray();
            }

            $data = [
                'hasError' => false,
                'success'  => true,
                'error'    => '',
                'code'     => $code,
                'data'     => $content
            ];

            return response()->json($data, $status, $headers, $options);
        });

        // wrong ajax macro
        Response::macro('error', function ($error, $code = 200, $status = 200, array $headers = [], $options = 0) {
            $data = [
                'hasError' => true,
                'success'  => false,
                'error'    => $error,
                'code'     => $code,
                'data'     => [],
            ];
            return response()->json($data, $status, $headers, $options);
        });

        // csv
        Response::macro('csv', function (array $list, string $filename, array $tebleHeader) {
            $tebleHeader = implode(",", $tebleHeader);
            $strexport = $tebleHeader."\r";
            foreach ($list as $row) {
                $strexport.=implode(",", $row);
                $strexport.="\r";
            }
            $strexport = iconv('UTF-8',"GB2312//IGNORE",$strexport);

            return response($strexport, 200, [
                'Content-type' => 'application/vnd.ms-excel',
                'Content-Disposition' => "filename={$filename}.csv",
            ]);
        });
    }
}
