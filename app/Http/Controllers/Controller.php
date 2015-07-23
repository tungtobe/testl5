<?php



use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseControllers;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseControllers
{
    use DispatchesJobs, ValidatesRequests;
    public function callAction($method, $parameters)
	{
		$this->setupLayout();
		$response = call_user_func_array(array($this, $method), $parameters);
		// If no response is returned from the controller action and a layout is being
		// used we will assume we want to just return the layout view as any nested
		// views were probably bound on this view during this controller actions.
		if (is_null($response) && ! is_null($this->layout))
		{
			$response = $this->layout;
		}
		return $response;
	}
}
