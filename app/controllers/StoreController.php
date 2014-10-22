<?php

class StoreController extends BaseController {

    public function __construct()
    {
        parent::__construct();
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    public function getIndex()
    {
        return View::make('store.index')
                ->with('products', Product::take(4)->orderBy('created_at', 'DESC')->get());
    }

    public function getView($id)
    {
        return View::make('store.view')
                ->with('product', Product::find($id));
    }

    public function getCategory($cat_id)
    {
        return View::make('store.category')
                ->with('products', Product::where('category_id', '=', $cat_id))->paginate(6)
                ->with('category', Category::find($cat_id));
    }
}