<?php

use Pingu\Taxonomy\Entities\Taxonomy;
use Pingu\Taxonomy\Entities\TaxonomyItem;

/*
|--------------------------------------------------------------------------
| Ajax Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register ajax web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group prefixed with ajax which
| contains the "ajax" middleware group.
|
*/

/**
 * Vocabularies
 */
Route::get(Taxonomy::getUri('index'), ['uses' => 'TaxonomyJsGridController@jsGridIndex'])
	->middleware('can:view taxonomy vocabularies');
Route::delete(Taxonomy::getUri('delete'), ['uses' => 'AjaxTaxonomyController@delete'])
	->middleware('can:delete taxonomy vocabularies');
Route::put(Taxonomy::getUri('update'), ['uses' => 'AjaxTaxonomyController@update'])
	->middleware('can:edit taxonomy vocabularies');

/**
 * Items
 */
Route::get(TaxonomyItem::getUri('create'), ['uses' => 'AjaxItemController@create'])
	->middleware('can:add taxonomy terms');
Route::post(TaxonomyItem::getUri('store'), ['uses' => 'AjaxItemController@store'])
	->middleware('can:add taxonomy terms');
Route::delete(TaxonomyItem::getUri('delete'), ['uses' => 'AjaxItemController@delete'])
	->middleware('can:delete taxonomy terms');
Route::get(TaxonomyItem::getUri('edit'), ['uses' => 'AjaxItemController@edit'])
	->middleware('can:edit taxonomy terms');
Route::put(TaxonomyItem::getUri('update'), ['uses' => 'AjaxItemController@update'])
	->middleware('can:edit taxonomy terms');
Route::patch(TaxonomyItem::getUri('patch'), ['uses' => 'AjaxItemController@patch'])
	->middleware('can:edit taxonomy terms');