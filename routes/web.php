<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'UsuarioController@index');
Route::post('/login', 'UsuarioController@login');
Route::get('/administracion', 'UsuarioController@administracion');
Route::get('/logout', 'UsuarioController@logout');

// RUTAS PROVEEDORES
Route::get('/proveedores', 'ProveedorController@gestion');
Route::post('/proveedores/eliminar', 'ProveedorController@eliminar');
Route::get('/proveedores/nuevo', 'ProveedorController@nuevo');
Route::post('/proveedores/guardar', 'ProveedorController@guardar');
Route::get('/proveedores/editar/{id}', 'ProveedorController@editar');
Route::put('/proveedores/modificar/{id}', 'ProveedorController@modificar');
// RUTAS PROVEEDORES

// RUTAS PRODUCTOS
Route::get('/productos', 'ProductoController@gestion');
Route::post('/productos/eliminar', 'ProductoController@eliminar');
Route::get('/productos/nuevo', 'ProductoController@nuevo');
Route::post('/productos/guardar', 'ProductoController@guardar');
Route::get('/productos/editar/{id}', 'ProductoController@editar');
Route::put('/productos/modificar/{id}', 'ProductoController@modificar');
// RUTAS PRODUCTOS

// RUTAS COBERTURAS
Route::get('/cobertura', 'CoberturaController@gestion');
Route::post('/cobertura/subir', 'CoberturaController@subir');
// RUTAS COBERTURAS
