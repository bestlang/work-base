<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Apis\Pdd;
use App\Pdd\Cat as PddCat;

class PddCats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pdd:cats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pdd = new Pdd();
        $step = 4;

        if($step == 1){
            $parent_cat_id = 0;
            $result = $pdd->goodsCatsGet($parent_cat_id);
            $cats = [];
            foreach ($result as $r){
                $cats[] = collect($r)->toArray();
            }
            PddCat::insert($cats);
        }


        if($step == 2){
            $cats1 = PddCat::where('level', 1)->get();
            foreach ($cats1 as $c1){
                $parent_cat_id = $c1->cat_id;
                $result = $pdd->goodsCatsGet($parent_cat_id);
                $cats = [];
                foreach ($result as $r){
                    $cats[] = collect($r)->toArray();
                }
                PddCat::insert($cats);
            }
        }

        if($step == 3){
            $cats2 = PddCat::where('level', 2)->get();
            foreach ($cats2 as $c2){
                $parent_cat_id = $c2->cat_id;
                $result = $pdd->goodsCatsGet($parent_cat_id);
                $cats = [];
                foreach ($result as $r){
                    $cats[] = collect($r)->toArray();
                }
                PddCat::insert($cats);
            }
        }

        if($step == 4){
            $cats3 = PddCat::where('level', 3)->get();
            foreach ($cats3 as $c3){
                $parent_cat_id = $c3->cat_id;
                $result = $pdd->goodsCatsGet($parent_cat_id);
                usleep(500);
                $cats = [];
                if(count($result)){
                    echo count($result)."\n";
                    foreach ($result as $r){
                        $cats[] = collect($r)->toArray();
                    }
                    PddCat::insert($cats);
                }
            }
        }
    }
}
