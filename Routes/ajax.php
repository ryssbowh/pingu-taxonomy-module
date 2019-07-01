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

Route::get(Taxonomy::getAjaxUri('index'), ['uses' => 'TaxonomyJsGridController@jsGridIndex'])
	->middleware('can:view taxonomy vocabularies');
Route::delete(Taxonomy::getAjaxUri('delete'), ['uses' => 'AjaxTaxonomyController@delete'])
	->middleware('can:delete taxonomy vocabularies');
Route::put(Taxonomy::getAjaxUri('update'), ['uses' => 'AjaxTaxonomyController@update'])
	->middleware('can:edit taxonomy vocabularies');

Route::get(TaxonomyItem::getAjaxUri('create'), ['uses' => 'AjaxItemController@create'])
	->middleware('can:add taxonomy terms');
Route::post(TaxonomyItem::getAjaxUri('store'), ['uses' => 'AjaxItemController@store'])
	->middleware('can:add taxonomy terms');
Route::delete(TaxonomyItem::getAjaxUri('delete'), ['uses' => 'AjaxItemController@delete'])
	->middleware('can:delete taxonomy terms');
Route::get(TaxonomyItem::getAjaxUri('edit'), ['uses' => 'AjaxItemController@edit'])
	->middleware('can:edit taxonomy terms');
Route::put(TaxonomyItem::getAjaxUri('update'), ['uses' => 'AjaxItemController@update'])
	->middleware('can:edit taxonomy terms');
Route::patch(TaxonomyItem::getAjaxUri('patch'), ['uses' => 'AjaxItemController@patch'])
	->middleware('can:edit taxonomy terms');