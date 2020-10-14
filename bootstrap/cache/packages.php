<?php return array (
  'baum/baum' => 
  array (
    'providers' => 
    array (
      0 => 'Baum\\BaumServiceProvider',
    ),
  ),
  'bestlang/base' => 
  array (
    'providers' => 
    array (
      0 => 'Bestlang\\Base\\Providers\\AppServiceProvider',
      1 => 'Bestlang\\Base\\Providers\\ResponseServiceProvider',
      2 => 'Bestlang\\Base\\Providers\\RouteServiceProvider',
    ),
    'aliases' => 
    array (
      'hashconfig' => 'Bestlang\\Base\\Facades\\HashConfig',
    ),
  ),
  'bestlang/laracms' => 
  array (
    'providers' => 
    array (
      0 => 'Bestlang\\Laracms\\Providers\\AppServiceProvider',
      1 => 'Bestlang\\Laracms\\Providers\\RouteServiceProvider',
    ),
    'aliases' => 
    array (
      'laracms' => 'Bestlang\\Laracms\\Facades\\Laracms',
    ),
  ),
  'bestlang/laravel-ueditor' => 
  array (
    'providers' => 
    array (
      0 => 'Bestlang\\LaravelUEditor\\UEditorServiceProvider',
    ),
  ),
  'beyondcode/laravel-dump-server' => 
  array (
    'providers' => 
    array (
      0 => 'BeyondCode\\DumpServer\\DumpServerServiceProvider',
    ),
  ),
  'fideloper/proxy' => 
  array (
    'providers' => 
    array (
      0 => 'Fideloper\\Proxy\\TrustedProxyServiceProvider',
    ),
  ),
  'jacobcyl/ali-oss-storage' => 
  array (
    'providers' => 
    array (
      0 => 'Jacobcyl\\AliOSS\\AliOssServiceProvider',
    ),
  ),
  'jellybool/flysystem-upyun' => 
  array (
    'providers' => 
    array (
      0 => 'JellyBool\\Flysystem\\Upyun\\UpyunServiceProvider',
    ),
  ),
  'laravel/tinker' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'mpociot/laravel-apidoc-generator' => 
  array (
    'providers' => 
    array (
      0 => 'Mpociot\\ApiDoc\\ApiDocGeneratorServiceProvider',
    ),
  ),
  'nesbot/carbon' => 
  array (
    'providers' => 
    array (
      0 => 'Carbon\\Laravel\\ServiceProvider',
    ),
  ),
  'nunomaduro/collision' => 
  array (
    'providers' => 
    array (
      0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    ),
  ),
  'overtrue/laravel-wechat' => 
  array (
    'providers' => 
    array (
      0 => 'Overtrue\\LaravelWeChat\\ServiceProvider',
    ),
    'aliases' => 
    array (
      'EasyWeChat' => 'Overtrue\\LaravelWeChat\\Facade',
    ),
  ),
  'sniper/employee' => 
  array (
    'providers' => 
    array (
      0 => 'Sniper\\Employee\\Providers\\AppServiceProvider',
      1 => 'Sniper\\Employee\\Providers\\RouteServiceProvider',
    ),
    'aliases' => 
    array (
    ),
  ),
  'songshenzong/support' => 
  array (
    'providers' => 
    array (
      0 => 'Songshenzong\\Support\\StringsServiceProvider',
    ),
    'aliases' => 
    array (
      'Strings' => 'Songshenzong\\Support\\StringsFacade',
    ),
  ),
  'spatie/laravel-permission' => 
  array (
    'providers' => 
    array (
      0 => 'Spatie\\Permission\\PermissionServiceProvider',
    ),
  ),
  'tymon/jwt-auth' => 
  array (
    'aliases' => 
    array (
      'JWTAuth' => 'Tymon\\JWTAuth\\Facades\\JWTAuth',
      'JWTFactory' => 'Tymon\\JWTAuth\\Facades\\JWTFactory',
    ),
    'providers' => 
    array (
      0 => 'Tymon\\JWTAuth\\Providers\\LaravelServiceProvider',
    ),
  ),
);