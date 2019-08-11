<?php

use Pingu\Taxonomy\Entities\Taxonomy;

/*
|--------------------------------------------------------------------------
| Admin Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group prefixed with admin which
| contains the "web" middleware group and the permission middleware "can:access admin area".
|
*/

/**
 * Vocabularies
 */
Route::get(Taxonomy::getUri('index'), ['uses' => 'TaxonomyJsGridController@index'])
	->name('taxonomy.admin.taxonomy')
	->middleware('can:view taxonomy vocabularies');

Route::get(Taxonomy::getUri('edit'), ['uses' => 'TaxonomyController@edit'])
	->middleware('can:edit taxonomy vocabularies');
Route::put(Taxonomy::getUri('update'), ['uses' => 'TaxonomyController@update'])
	->middleware('can:edit taxonomy vocabularies');

Route::get(Taxonomy::getUri('create'), ['uses' => 'TaxonomyController@create'])
	->name('taxonomy.admin.create')
	->middleware('can:add taxonomy vocabularies');
Route::post(Taxonomy::getUri('store'), ['uses' => 'TaxonomyController@store'])
	->middleware('can:add taxonomy vocabularies');

Route::get(Taxonomy::getUri('editItems'), ['uses' => 'TaxonomyController@editItems'])
	->middleware('can:view taxonomy terms');
Route::put(Taxonomy::getUri('editItems'), ['uses' => 'TaxonomyController@updateItems'])
	->middleware('can:edit taxonomy terms');