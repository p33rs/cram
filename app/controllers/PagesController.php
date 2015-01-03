<?php

class PagesController extends BaseController {

	public function landing()
    {
        if (Auth::check()) {
            //return Redirect::route('photos');
        }
        return View::make('pages/landing');
    }

}
