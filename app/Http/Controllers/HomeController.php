<?php namespace chineseClass\Http\Controllers;

class HomeController extends Controller {

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home');
	}

}
